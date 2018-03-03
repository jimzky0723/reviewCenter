<?php

namespace App\Http\Controllers;

use App\Center;
use App\classDays;
use App\Classes;
use App\Grade;
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
        $centers = Center::select('center.*')
            ->leftJoin('users','users.id','=','center.user_id')
            ->where('users.status','registered')
            ->orderBy('desc','asc')->get();

        $provinces = Province::orderBy('desc','asc')->get();
        $registered = Center::select('region.regCode','region.desc')
                ->leftJoin('region','region.regCode','=','center.regCode')
                ->leftJoin('users','users.id','=','center.user_id')
                ->where('users.status','registered')
                ->orderBy('region.desc','asc')
                ->groupBy('center.regCode')
                ->get();
        //dd($regions);
        $satisfied = Grade::where('percentage','>=',75)
                ->groupBy('student_id')
                ->get();

        $data = array(
            'provinces' => Province::orderBy('desc','asc')->get()
        );

        return view('home',[
            'centers' => $centers,
            'provinces' =>$provinces,
            'registered' => $registered,
            'countCenter' => count($centers),
            'countInstructor' => User::where('level','instructor')->where('status','registered')->count(),
            'countReviewee' => User::where('level','reviewee')->where('status','registered')->count(),
            'countSatisfied' => count($satisfied)
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
        if($req->subjects){
            foreach($req->subjects as $class_id){
                $data[] =  [
                    'user_id' => $user_id,
                    'center_id' => $req->center,
                    'class_id' => $class_id
                ];
            }
            Reviewee::insert($data);
        }

        return redirect()->back()->with('status','saved');
    }

    public function show_subjects($center_id)
    {
        $data = array();
        $date_now = date('Y-m-d');
        $subjects = Classes::select('time_in','time_out','id','code',DB::raw('DATE_FORMAT(date_close,"%b %d, %Y") as date_close'))
                ->where('center_id',$center_id)
                ->where(function($q) use($date_now){
                    $q = $q->orwhere('date_close','>=',$date_now)
                            ->orwhere('date_close','=','0000-00-00');
                })
                ->orderBy('code','asc')
                ->get();
        foreach($subjects as $row){
            $time = "$row->time_in - $row->time_out";
            $days = classDays::where('class_id',$row->id)->get();
            $tmp = array();
            foreach($days as $day)
            {
                $tmp[] = $day->day;
            }
            $days = implode(',', $tmp);
            if(count($tmp)==0)
            {
                $days = 'Always Open';
            }
            if($time===" - "){
                $time = 'Whole Day';
            }
            $data[] = array(
                'id' => $row->id,
                'code' => $row->code,
                'date_close' => $row->date_close,
                'time' => $time,
                'days' => $days
            );
        }
        return $data;
    }

    public function subscribe(Request $req)
    {

        $regCode = Province::where('provCode',$req->province)
            ->first()
            ->regCode;

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
        $r->limit = $req->need;
        $r->regCode = $regCode;
        $r->provCode = $req->province;
        $r->muncityCode = $req->muncity;
        $r->barangayCode = $req->barangay;
        $r->save();

        return redirect()->back()->with('status','saved');
    }
}
