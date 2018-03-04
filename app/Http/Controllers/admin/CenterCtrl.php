<?php

namespace App\Http\Controllers\admin;

use App\Center;
use App\Payment;
use App\Province;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CenterCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('admin');
    }

    public function index()
    {
        $keyword = Session::get('centerKeyword');
        $centers = Center::select('center.*');

        if($keyword){
            $centers = $centers->where('desc','like',"%$keyword%");
        }
        $centers = $centers->orderBy('desc','asc')
            ->paginate(15);
        return view('admin.centers',[
            'centers' => $centers,
            'title' => 'List of Review Centers'
        ]);
    }

    public function search(Request $req)
    {
        Session::put('centerKeyword',$req->keyword);
        return self::index();
    }

    public function add()
    {

        return view('admin.addCenter');
    }

    public function edit($id)
    {
        $center = Center::select(
                'center.id',
                'owner',
                'desc',
                'provCode',
                'muncityCode',
                'barangayCode',
                'limit',
                'users.username',
                'users.contact',
                'users.email',
                'users.id as user_id'
            )
            ->leftJoin('users','users.id','=','center.user_id')
            ->where('center.id',$id)
            ->first();
        return view('admin.editCenter',['center'=>$center]);
    }

    public function save(Request $req)
    {
        $data = array(
            'desc' => $req->name,
            'provCode' => $req->province,
            'muncityCode' => $req->muncity
        );
        $regCode = Province::where('provCode',$req->province)->first()->regCode;

        $check = User::where('username',$req->username)->first();
        if($check){
            $data['barangayCode'] = $req->barangay;
            $data['num'] = $req->num;
            $data['username'] = $req->username;
            $data['password'] = $req->password;
            $data['contact'] = $req->contact;
            $data['email'] = $req->email;
            $data['owner'] = $req->owner;

            return redirect()->back()->with([
                    'status' => 'duplicateUsername','data' => $data]);
        }

        $validateCenter = Center::where($data)->first();
        if($validateCenter)
        {
            $data['barangayCode'] = $req->barangay;
            $data['num'] = $req->num;
            $data['username'] = $req->username;
            $data['password'] = $req->password;
            $data['contact'] = $req->contact;
            $data['email'] = $req->email;
            $data['owner'] = $req->owner;

            return redirect()->back()->with([
                'status' => 'duplicateEntry','data' => $data]);
        }

        if(!$check && !$validateCenter)
        {
            $q = new User();
            $q->fname = $req->name;
            $q->contact = $req->contact;
            $q->email = $req->email;
            $q->barangay_id = $req->barangay;
            $q->muncity_id = $req->muncity;
            $q->province_id = $req->province;
            $q->region_id = $regCode;
            $q->username = $req->username;
            $q->password = bcrypt($req->password);
            $q->level = 'center';
            $q->status = 'pending';
            $q->save();

            $user_id = $q->id;

            $r = new Center();
            $r->desc = $req->name;
            $r->user_id = $user_id;
            $r->owner = $req->owner;
            $r->limit = $req->num;
            $r->regCode = $regCode;
            $r->provCode = $req->province;
            $r->muncityCode = $req->muncity;
            $r->barangayCode = $req->barangay;
            $r->save();

            return redirect()->back()->with('status','saved');
        }

    }

    public function update(Request $req)
    {
        $data = array(
            'desc' => $req->name,
            'provCode' => $req->province,
            'muncityCode' => $req->muncity
        );

        $regCode = Province::where('provCode',$req->province)->first()->regCode;

        $check = User::where('username',$req->username)
            ->where('id','!=',$req->userID)
            ->first();

        if($check){
            $data['barangayCode'] = $req->barangay;
            $data['num'] = $req->num;
            $data['username'] = $req->username;
            $data['password'] = $req->password;
            $data['contact'] = $req->contact;
            $data['email'] = $req->email;
            $data['owner'] = $req->owner;

            return redirect()->back()->with([
                'status' => 'duplicateUsername','data' => $data]);
        }

        $validateCenter = Center::where($data)
            ->where('id','!=',$req->currentID)
            ->first();
        if($validateCenter)
        {
            $data['barangayCode'] = $req->barangay;
            $data['num'] = $req->num;
            $data['username'] = $req->username;
            $data['password'] = $req->password;
            $data['contact'] = $req->contact;
            $data['email'] = $req->email;
            $data['owner'] = $req->owner;

            return redirect()->back()->with([
                'status' => 'duplicateEntry','data' => $data]);
        }

        if(!$check && !$validateCenter)
        {
            $password = isset($req->password) ? bcrypt($req->password) : User::find($req->userID)->password;
            User::where('id',$req->userID)
                ->update([
                    'username' => $req->username,
                    'password' => $password,
                    'fname' => $req->name,
                    'email' => $req->email,
                    'barangay_id' => $req->barangay,
                    'muncity_id' => $req->muncity,
                    'province_id' => $req->province,
                    'region_id' => $regCode
                ]);

            Center::where('id',$req->currentID)
                ->update([
                    'owner' => $req->owner,
                    'desc' => $req->name,
                    'limit' => $req->num,
                    'regCode' => $regCode,
                    'provCode' => $req->province,
                    'muncityCode' => $req->muncity,
                    'barangayCode' => $req->barangay
                ]);

            return redirect()->back()->with('status','saved');
        }
    }

    public function delete(Request $req)
    {
        $id = $req->currentID;
        $center = Center::find($id);
        $name = $center->desc;
        $user_id = $center->user_id;
        Center::where('id',$id)
            ->delete();
        User::where('id',$user_id)
            ->delete();
        return redirect('admin/center')->with([
            'status' => 'deleted','name' => $name]);
    }

    public function accept(Request $req)
    {
        $id = $req->currentID;

        $q = new Payment();
        $q->type = 'center';
        $q->user_id = $id;
        $q->payment = $req->amount;
        $q->save();

        $date_subscribed = date('Y-m-d');
        $no = Center::where('user_id',$id)->first()->no_month;
        $date_expired = date('Y-m-d',strtotime("+$no month"));

        Center::where('user_id',$id)
            ->update([
                'date_subscribed' => $date_subscribed,
                'date_expired'=> $date_expired,
                'status' => 'active'
            ]);

        User::where('id',$id)
            ->update([
                'status'=> 'registered'
            ]);
        $user = User::find($id);
        $name = $user->fname.' '.$user->lname;
        return redirect('admin/center')->with([
            'status' => 'accepted','name' => $name]);
    }

    public function ignore(Request $req)
    {
        $id = $req->currentID;

        $user = User::find($id);
        $name = $user->fname.' '.$user->lname;
        User::where('id',$id)
            ->delete();
        Center::where('user_id',$id)
            ->delete();
        return redirect('admin/center')->with([
            'status' => 'ignored','name' => $name]);
    }
}
