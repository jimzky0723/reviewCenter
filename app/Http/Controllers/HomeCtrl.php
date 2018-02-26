<?php

namespace App\Http\Controllers;

use App\Center;
use App\Classes;
use App\Province;
use App\Region;
use App\Reviewee;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

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

        $data = array();
        $user_id = User::where('username',$req->username)
                ->first()
                ->id;
        foreach($req->subjects as $class_id){
            $data[] =  [
                'user_id' => $user_id,
                'center_id' => $req->center,
                'class_id' => $class_id
            ];
        }
        Reviewee::insert($data);
        return redirect()->back()->with('status','saved');
    }

    public function show_subjects($center_id)
    {
        $date_now = date('Y-m-d');
        $subjects = Classes::select('id','code',DB::raw('DATE_FORMAT(date_close,"%b %d, %Y") as date_close'))
                ->where('center_id',$center_id)
                ->where(function($q) use($date_now){
                    $q = $q->orwhere('date_close','>=',$date_now)
                            ->orwhere('date_close','=','0000-00-00');
                })
                ->orderBy('code','asc')
                ->get();
        return $subjects;
    }
}
