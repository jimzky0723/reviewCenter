<?php

namespace App\Http\Controllers\admin;

use App\Center;
use App\Classes;
use App\Feedback;
use App\Lesson;
use App\Payment;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('admin');
    }

    public function index()
    {
        $feedback = Feedback::select('feedback.type','users.fname','users.lname','feedback.created_at','feedback.contents','feedback.satisfaction as heart')
            ->leftJoin('users','users.id','=','feedback.user_id')
            ->orderBy('feedback.created_at','desc')
            ->paginate(10);

        return view('admin.home',[
            'title' => 'Administrator Dashboard',
            'totalInstructor' => User::where('level','instructor')->count(),
            'totalMale' => User::where('level','reviewee')->where('status','registered')->where('sex','Male')->count(),
            'totalFemale' => User::where('level','reviewee')->where('status','registered')->where('sex','Female')->count(),
            'totalSatisfied' => Feedback::where('satisfaction',1)->count(),
            'feedback' => $feedback
        ]);
    }

    public function center()
    {
        return view('admin.centers');
    }

    public function addCenter()
    {
        return view('admin.addCenter');
    }

    public function chart()
    {
        $labels = array('Instructors','Male Students','Female Students','Satisfied');
        $total = array(
            User::where('level','instructor')->count(),
            User::where('level','reviewee')->where('status','registered')->where('sex','Male')->count(),
            User::where('level','reviewee')->where('status','registered')->where('sex','Female')->count(),
            Feedback::where('satisfaction',1)->count()
        );
        $data = array(
            'labels' => $labels,
            'total' => $total
        );
        return $data;
    }
}
