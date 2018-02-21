<?php

namespace App\Http\Controllers;

use App\Center;
use App\Province;
use App\Region;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class HomeCtrl extends Controller
{
    //
    public function __construct()
    {

    }

    public function index()
    {
        $centers = Center::orderBy('code','asc')->get();
        $provinces = Province::orderBy('desc','asc')->get();
        $registered = Center::select('region.regCode','region.desc')
                ->leftJoin('region','region.regCode','=','center.regCode')
                ->orderBy('region.desc','asc')
                ->groupBy('center.regCode')
                ->get();
        //dd($regions);
        $data = array(
            'provinces' => Province::orderBy('desc','asc')->get()
        );
        return view('home',[
            'centers' => $centers,
            'provinces' =>$provinces,
            'registered' => $registered
        ]);
    }

    public function store(Request $req)
    {
        $check_username = User::where('username',$req->username)->first();
        if($check_username){
            return redirect()->back()->with('status','duplicate');
        }

        $region_id = Province::where('provCode',$req->province)->first()->regCode;

        $q = new User();
        $q->center_id = $req->center;
        $q->fname = $req->fname;
        $q->mname = $req->mname;
        $q->lname = $req->lname;
        $q->suffix = $req->suffix;
        $q->sex = $req->sex;
        $q->dob = $req->dob;
        $q->contact = $req->contact;
        $q->email = $req->email;
        $q->province_id = $req->province;
        $q->muncity_id = $req->muncity;
        $q->barangay_id = $req->barangay;
        $q->region_id = $region_id;
        $q->username = $req->username;
        $q->password = bcrypt($req->password);
        $q->level = 'reviewee';
        $q->status = 'pending';
        $q->save();

        return redirect()->back()->with('status','saved');
    }
}
