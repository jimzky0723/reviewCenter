<?php

namespace App\Http\Controllers\instructor;

use App\Classes;
use App\Reviewee;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ClassCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('instructor');
    }

    public function index()
    {
        $center_id = Session::get('center');
        $user = Session::get('access');
        $data = Classes::where('instructor_id',$user->id)->paginate(20);
        return view('instructor.class',[
            'data' => $data,
            'title' => 'My Class'
        ]);
    }
    public function searchReviewee(Request $req,$id)
    {
        if($req->keyword){
            Session::put('searchReviewee',$req->keyword);
        }else{
            Session::forget('searchReviewee');
        }
        return self::reviewee($id);
    }
    public function reviewee($id)
    {
        $keyword = Session::get('searchReviewee');
        $user = Session::get('access');
        $check = Classes::where('instructor_id',$user->id)
            ->where('id',$id)
            ->first();
        if(!$check)
        {
            return redirect('instructor/home');
        }

        $data = Reviewee::where('class_id',$id)
            ->leftJoin('users','users.id','=','reviewee.user_id');
        if($keyword){
            $data = $data->where(function($q) use($keyword){
                $q = $q->where('fname','like',"%$keyword%")
                    ->orwhere('mname','like',"%$keyword%")
                    ->orwhere('lname','like',"%$keyword%");
            });
        }
        $data = $data->paginate(20);
        return view('instructor.reviewee',[
            'title' => 'My Reviewees',
            'data' => $data,
            'className' => Classes::find($id)->code,
            'classID' => $id
        ]);
    }
}
