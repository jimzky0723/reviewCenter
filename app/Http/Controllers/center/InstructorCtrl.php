<?php

namespace App\Http\Controllers\center;

use App\Center;
use App\Instructor;
use App\Province;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class InstructorCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('center');
    }

    public function search(Request $req)
    {
        if($req->keyword){
            Session::put('searchInstructor',$req->keyword);
        }else{
            Session::forget('searchInstructor');
        }

        return self::index();
    }

    public function index()
    {
        $center_id = Session::get('center');
        $keyword = Session::get('searchInstructor');
        $data = User::where('center_id',$center_id);
        if($keyword){
            $data = $data->where(function($q) use ($keyword){
                $q = $q->where('fname','like',"%$keyword%")
                    ->orwhere('mname','like',"%$keyword%")
                    ->orwhere('lname','like',"%$keyword%");
            });
        }
        $data = $data->orderBy('lname','asc')
            ->where('level','instructor')
            ->paginate(20);
        return view('center.instructor',[
            'title' => 'List of Instructors',
            'record' => $data
        ]);
    }

    public function add()
    {
        return view('center.addInstructor',[
            'title' => 'Add Instructor'
        ]);
    }

    public function save(Request $req)
    {
//        dd($_POST);
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
        $q->level = 'instructor';
        $q->status = 'registered';
        $q->save();

        return redirect()->back()->with('status','saved');
    }

    public function edit($id)
    {
        $center_id = Session::get('center');

        $data = User::find($id);
        $record = User::find($id);

        if($record->center_id!=$center_id)
        {
            return redirect('center/home');
        }

        return view('center.editInstructor',[
            'title' => 'Edit Instructor',
            'user' => $data,
            'record' => $record
        ]);
    }

    public function update(Request $req)
    {
        $id = $req->currentID;
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
            'region_id' => $region_id,
            'status' => $req->status
        );
        if($req->password)
        {
            $data['password'] = bcrypt($req->password);
        }

        User::where('id',$id)
            ->update($data);
        return redirect()->back()->with('status','saved');
    }

    public function delete(Request $req)
    {
        $id = $req->currentID;
        $user = User::find($id);
        $name = $user->fname.' '.$user->lname;
        User::where('id',$id)
            ->delete();
        Instructor::where('user_id',$id)
            ->delete();
        return redirect('center/instructor')->with([
            'status' => 'deleted','name' => $name]);
    }
}
