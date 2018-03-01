<?php

namespace App\Http\Controllers\reviewee;

use App\Announcement;
use App\Lesson;
use App\Quiz;
use App\Reviewee;
use App\RevieweeLesson;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LessonCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('reviewee');
    }

    public function checkAvailability($lesson_id)
    {
        $lesson = Lesson::find($lesson_id);
        $current_date = date('Y-m-d');
        $class_id = $lesson->class_id;
        if($current_date < $lesson->date_open)
        {
            return 'not_open';
        }
        $user = Session::get('access');
        $check = Reviewee::where('class_id',$class_id)
            ->where('user_id',$user->id)
            ->first();
        if(!$check)
        {
            return 'denied';
        }
    }

    public function show($lesson_id)
    {
        $check = self::checkAvailability($lesson_id);

        $user = Session::get('access');
        $check_reviewee_lesson = RevieweeLesson::where('user_id',$user->id)
            ->where('lesson_id',$lesson_id)
            ->first();

        if($check==='not_open' || $check==='denied')
        {
            return redirect('reviewee/class')->with('status',$check);
        }

        if($check_reviewee_lesson)
        {
            return redirect('reviewee/class')->with('status','finish');
        }

        $lesson = Lesson::find($lesson_id);
        return view('reviewee.viewlesson',[
            'title' => 'View lesson',
            'lesson' => $lesson
        ]);

    }

    public function showReview($lesson_id)
    {
        $user = Session::get('access');
        $check = RevieweeLesson::where('lesson_id', $lesson_id)
            ->where('user_id', $user->id)
            ->where('status','open')
            ->first();
        if (!$check) {
            return redirect('reviewee/class')->with('status', 'denied');
        }
        $lesson = Lesson::find($lesson_id);
        return view('reviewee.viewlesson',[
            'title' => 'Review lesson',
            'lesson' => $lesson
        ]);

    }

    public function finish($lesson_id)
    {
        $check = self::checkAvailability($lesson_id);
        if($check==='not_open' || $check==='denied')
        {
            return redirect('reviewee/class')->with('status',$check);
        }
        $class_id = Lesson::find($lesson_id)->class_id;
        $user = Session::get('access');
        $q = new RevieweeLesson();
        $q->lesson_id = $lesson_id;
        $q->user_id = $user->id;
        $q->status = 'close';
        $q->save();

        $lesson = Lesson::find($lesson_id);
        $content = 'You have finished <strong>'.$lesson->title.'</strong>.';
        $q = new Announcement();
        $q->target = 'reviewee';
        $q->user_id = $user->id;
        $q->content = $content;
        $q->date_created = date('Y-m-d');
        $q->save();
        return redirect('reviewee/class/'.$class_id)->with('status','finish');
    }

    public function quiz($lesson_id)
    {
        $user = Session::get('access');
        $data = Quiz::where('lesson_id',$lesson_id)->get();
        $class_id = Lesson::find($lesson_id)->class_id;
        return view('reviewee.quiz',[
            'class_id' => $class_id,
            'title' => 'My Quizzes',
            'data' => $data,
            'user' => $user
        ]);
    }
}
