<?php

namespace App\Http\Controllers\reviewee;

use App\AnnoucementStatus;
use App\Announcement;
use App\Answers;
use App\Grade;
use App\Lesson;
use App\Question;
use App\Quiz;
use App\RevieweeLesson;
use App\RevieweeQuiz;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class QuizCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('reviewee');
    }

    public function take_quiz($quiz_id)
    {
        $user = Session::get('access');
        //dd(Session::all());
        $check_quiz = RevieweeQuiz::where('quiz_id',$quiz_id)
            ->where('user_id',$user->id)
            ->first();
        if($check_quiz){
            return redirect('reviewee/quiz/'.$quiz_id);
        }
        $quiz = Quiz::find($quiz_id);
        $questions = Question::where('quiz_id',$quiz_id)
                ->inRandomOrder()
                ->get();
        return view('reviewee.take_quiz',[
            'quiz_id' => $quiz_id,
            'title' => 'Take Exam',
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }

    public function practice_quiz($quiz_id)
    {
        $user = Session::get('access');
        //dd(Session::all());
        $check_quiz = RevieweeQuiz::where('quiz_id',$quiz_id)
            ->where('user_id',$user->id)
            ->first();
        if(!$check_quiz){
            return redirect('reviewee/quiz/'.$quiz_id);
        }
        $quiz = Quiz::find($quiz_id);
        $questions = Question::where('quiz_id',$quiz_id)
            ->inRandomOrder()
            ->get();
        return view('reviewee.practice_quiz',[
            'quiz_id' => $quiz_id,
            'title' => 'Practice Quiz',
            'quiz' => $quiz,
            'questions' => $questions
        ]);
    }

    public function get_score(Request $req,$quiz_id)
    {
        $user = Session::get('access');
        $student_id = $user->id;

        Session::forget('quiz_timer_'.$quiz_id);
        $questions = Question::where('quiz_id',$quiz_id)->get();
        $check = 0;
        foreach($questions as $row){
           $item = 'question_'.$row->id;
            Session::forget($item);
            $choice = Answers::find($req->$item)->value;
           if($choice=='1'){
                $check++;
           }
        }
        $total = ($check/$req->total_item)*50+50;
        $q = new Grade();
        $q->student_id = $student_id;
        $q->score = $check;
        $q->total = $req->total_item;
        $q->percentage = $total;
        $q->quiz_id = $quiz_id;
        $q->save();

        $q = new RevieweeQuiz();
        $q->user_id = $student_id;
        $q->quiz_id = $quiz_id;
        $q->save();

        $lesson_id = Quiz::find($quiz_id)
            ->lesson_id;

        $code = Quiz::find($quiz_id)->code;
        $quiz = 'Quiz-'.str_pad($code,4,0,STR_PAD_LEFT);
        $msg = "Congratulations you have passed the $quiz ";
        $total = number_format($total,1);
        if($total < 75)
        {
            $msg = "You have finished $quiz";
        }

        $content = "$msg with a score of $check out of $req->total_item items. Your final grade is <strong>$total</strong>!";
        $q = new Announcement();
        $q->target = 'reviewee';
        $q->user_id = $student_id;
        $q->content = $content;
        $q->center_id = $user->center_id;

        $q->save();

        //check if lesson is available for review
        $quiz = Quiz::find($quiz_id);
        $total_quiz = Quiz::where('lesson_id',$quiz->lesson_id)->count();
        $current_quiz = RevieweeQuiz::leftJoin('quiz','quiz.id','=','reviewee_quiz.quiz_id')
            ->where('quiz.lesson_id',$quiz->lesson_id)
            ->where('reviewee_quiz.user_id',$student_id)
            ->count();
        if($total_quiz==$current_quiz)
        {
            RevieweeLesson::where('lesson_id',$quiz->lesson_id)
                ->where('user_id',$student_id)
                ->update([
                    'status' => 'open'
                ]);

            $content = "You can now review the lesson in this <a target='_blank' href='".url('reviewee/lesson/review/'.$lesson_id)."'>LINK</a>. And also take review quiz in this <a target='_blank' href='".url('reviewee/quiz/'.$lesson_id)."'>LINK</a>.";
            $q = new Announcement();
            $q->target = 'reviewee';
            $q->user_id = $student_id;
            $q->content = $content;
            $q->center_id = $user->center_id;
            $q->save();
        }

        Session::put('review_questions',$_POST);
        return redirect('reviewee/quiz/review/'.$quiz_id);
    }

    public function practice_score(Request $req,$quiz_id)
    {
        $student_id = Session::get('access')->id;


        Session::forget('quiz_timer_'.$quiz_id);
        $questions = Question::where('quiz_id',$quiz_id)->get();
        $check = 0;
        foreach($questions as $row){
            $item = 'question_'.$row->id;
            Session::forget($item);
            $choice = Answers::find($req->$item)->value;
            if($choice=='1'){
                $check++;
            }
        }
        $total = ($check/$req->total_item)*50+50;

        Session::put('review_questions',$_POST);
        return redirect('reviewee/quiz/review/'.$quiz_id);
    }


    public function review_quiz($quiz_id)
    {
        $user = Session::get('access');
        $valid = RevieweeQuiz::where('user_id',$user->id)
                ->where('quiz_id',$quiz_id)
                ->first();
        if(!$valid){
            return redirect('reviewee/class')->with('status','denied');
        }
        $post = Session::get('review_questions');
        $quiz = Quiz::find($quiz_id);
        return view('reviewee.review_quiz',[
            'questions' => $post,
            'quiz' => $quiz,
            'lesson_id' =>$quiz->lesson_id
        ]);
    }
    public function timer(Request $req)
    {
        Session::put('quiz_timer_'.$req->quiz_id,$req->timer);
    }

    public function answer(Request $req)
    {
        Session::put($req->question_id,$req->answer_id);
    }
}
