<?php

namespace App\Http\Controllers\admin;

use App\Center;
use App\Province;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CenterCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('admin');
    }

    public function index()
    {
        $centers = Center::orderBy('desc','asc')
            ->paginate(15);
        return view('admin.centers',[
            'centers' => $centers,
            'title' => 'List of Review Centers'
        ]);
    }

    public function add()
    {

        return view('admin.addCenter');
    }

    public function edit($id)
    {
        $center = Center::select(
                'center.id',
                'code',
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
            'code' => $req->code,
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
            $q->status = 'registered';
            $q->save();

            $user_id = User::where('username',$req->username)->first()->id;

            $c = new Center();
            $c->code = $req->code;
            $c->desc = $req->name;
            $c->limit = $req->num;
            $c->regCode = $regCode;
            $c->provCode = $req->province;
            $c->muncityCode = $req->muncity;
            $c->barangayCode = $req->barangay;
            $c->user_id = $user_id;
            $c->save();

            return redirect()->back()->with('status','saved');
        }

    }

    public function update(Request $req)
    {
        $data = array(
            'code' => $req->code,
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
                    'code' => $req->code,
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
}
