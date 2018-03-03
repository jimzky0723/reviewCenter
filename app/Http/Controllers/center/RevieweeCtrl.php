<?php

namespace App\Http\Controllers\center;

use App\Payment;
use App\Province;
use App\Reviewee;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class RevieweeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('center');
    }

    public function search(Request $req)
    {
        if($req->keyword){
            Session::put('searchReviewee',$req->keyword);
        }else{
            Session::forget('searchReviewee');
        }

        return self::index();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $center_id = Session::get('center');
        $keyword = Session::get('searchReviewee');
        $data = User::where('center_id',$center_id);
        if($keyword){
            $data = $data->where(function($q) use($keyword){
                $q = $q->where('fname','like',"%$keyword%")
                    ->orwhere('mname','like',"%$keyword%")
                    ->orwhere('lname','like',"%$keyword%");
            });
        }
        $data = $data->where('level','reviewee')
            ->orderBy('status','asc')
            ->orderBy('lname','asc')
            ->paginate(20);
        return view('center.reviewee',[
            'title' => 'List of Students',
            'record' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('center.addReviewee',[
            'title' => 'Add Student'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $center_id = Session::get('center');
        $check = User::where('username',$req->username)->first();
        if($check)
        {
            return redirect()->back()->with([
                'status' => 'duplicateUsername',
                'data' => $req
            ]);
        }
        $region_id = Province::where('provCode',$req->province)->first()->regCode;
        $q = new User();
        $q->fname = $req->fname;
        $q->mname = $req->mname;
        $q->lname = $req->lname;
        $q->suffix = $req->suffix;
        $q->sex = $req->sex;
        $q->dob = date('Y-m-d',strtotime($req->dob));
        $q->contact = $req->contact;
        $q->email = $req->email;
        $q->center_id = $center_id;
        $q->username = $req->username;
        $q->password = bcrypt($req->password);
        $q->province_id = $req->province;
        $q->muncity_id = $req->muncity;
        $q->barangay_id = $req->barangay;
        $q->region_id = $region_id;
        $q->level = 'reviewee';
        $q->status = 'pending';
        $q->save();

        return redirect()->back()->with('status','saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $center_id = Session::get('center');

        $data = User::find($id);


        if($data->center_id!=$center_id)
        {
            return redirect('center/home');
        }

        return view('center.editReviewee',[
            'title' => 'Edit Student',
            'user' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $check = User::where('username',$req->username)
            ->where('id','!=',$id)
            ->first();

        if($check)
        {
            return redirect()->back()->with([
                'status' => 'duplicateUsername',
                'data' => $req
            ]);
        }
        $region_id = Province::where('provCode',$req->province)->first()->regCode;
        $data = array(
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'suffix' => $req->suffix,
            'sex' => $req->sex,
            'dob' => date('Y-m-d',strtotime($req->dob)),
            'contact' => $req->contact,
            'email' => $req->email,
            'username' => $req->username,
            'province_id' => $req->province,
            'muncity_id' => $req->muncity,
            'barangay_id' => $req->barangay,
            'region_id' => $region_id
        );
        if($req->password)
        {
            $data['password'] = bcrypt($req->password);
        }

        User::where('id',$id)
            ->update($data);
        return redirect()->back()->with('status','saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $name = $user->fname.' '.$user->lname;
        User::where('id',$id)
            ->delete();
        Reviewee::where('user_id',$id)
            ->delete();
        return redirect('center/reviewee')->with([
            'status' => 'deleted','name' => $name]);
    }

    public function accept(Request $req)
    {
        $id = $req->currentID;

        $q = new Payment();
        $q->type = 'reviewee';
        $q->user_id = $id;
        $q->payment = $req->amount;
        $q->save();

        User::where('id',$id)
            ->update([
                'status'=> 'registered'
            ]);
        $user = User::find($id);
        $name = $user->fname.' '.$user->lname;
        return redirect('center/reviewee')->with([
            'status' => 'accepted','name' => $name]);
    }

    public function ignore(Request $req)
    {
        $id = $req->currentID;

        $user = User::find($id);
        $name = $user->fname.' '.$user->lname;
        User::where('id',$id)
            ->delete();
        Reviewee::where('user_id',$id)
            ->delete();
        return redirect('center/reviewee')->with([
            'status' => 'ignored','name' => $name]);
    }
}
