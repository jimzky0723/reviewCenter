<?php

namespace App\Http\Controllers\reviewee;

use App\Grade;
use App\Question;
use App\Quiz;
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

    public function get_score(Request $req,$quiz_id)
    {
        $student_id = Session::get('access')->id;

        $questions = Question::where('quiz_id',$quiz_id)->get();
        $check = 0;
        foreach($questions as $row){
           $item = 'question_'.$row->id;

           $choice = $req->$item;
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

        return redirect('reviewee/quiz/'.$lesson_id)->with('status','done_quiz');
    }

    public function timer(Request $req)
    {
        Session::put('quiz_timer',$req->timer);
    }

    public function answer(Request $req)
    {
        Session::put($req->question_id,$req->answer_id);
    }
}
