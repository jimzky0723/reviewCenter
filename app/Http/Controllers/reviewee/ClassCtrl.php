<?php

namespace App\Http\Controllers\reviewee;

use App\Classes;
use App\Grade;
use App\Lesson;
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
        $this->middleware('reviewee');
    }
    public function checkAvailability($class_id)
    {
        $user = Session::get('access');
        $check = Reviewee::where('class_id',$class_id)
            ->where('user_id',$user->id)
            ->first();
        if(!$check)
        {
            return 'denied';
        }
        $date_now = date('Y-m-d');
        $classes = Classes::find($class_id);
        if($date_now > $classes->date_close && $classes->date_close!='0000-00-00')
        {
            return 'denied';
        }

    }

    public function index()
    {
        $user = Session::get('access');
        $class = Reviewee::where('user_id',$user->id)->get();
        return view('reviewee.class',[
            'title' => 'My Subjects',
            'class' => $class
        ]);
    }

    public function show($class_id)
    {
        $check = self::checkAvailability($class_id);
        if($check==='denied'){
            return redirect('reviewee/class')->with('status',$check);
        }

        $lessons = Lesson::where('class_id',$class_id)
            ->orderBy('date_open','asc')
            ->get();

        return view('reviewee.lesson',[
            'title' => 'My Lessons',
            'lessons' => $lessons
        ]);
    }
}
