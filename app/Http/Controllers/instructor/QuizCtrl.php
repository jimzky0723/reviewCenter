<?php

namespace App\Http\Controllers\instructor;

use App\Classes;
use App\Lesson;
use App\Question;
use App\Quiz;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class QuizCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('instructor');
    }

    public function index($lesson_id)
    {
        $data = Quiz::where('lesson_id',$lesson_id)
            ->paginate(20);
        $lesson = Lesson::find($lesson_id);
        return view('instructor.quiz',[
            'data' => $data,
            'lesson_name' => $lesson->title,
            'class_id' => $lesson->class_id,
            'lesson_id' => $lesson_id,
            'title' => 'Quizzes'
        ]);
    }

    public function create($lesson_id)
    {
        $count = Quiz::where('lesson_id',$lesson_id)
            ->orderBy('id','desc')
            ->first();

        if($count){
            $count = $count->id;
        }else{
            $count = 0;
        }
        $last_id = $count + 1;

        return view('instructor.addQuiz',[
            'lesson_id' => $lesson_id,
            'title' => 'Add New Quiz',
            'last_id' => $last_id
        ]);
    }

    public function store(Request $req)
    {
        $q = new Quiz();
        $q->code =  $req->code;
        $q->lesson_id = $req->lesson_id;
        $q->minute = $req->minute;
        $q->save();
        return redirect()->back()->with('status','saved');
    }

    public function show($id)
    {
        $data = Quiz::find($id);
        return view('instructor.editQuiz',[
            'title' => 'Update Quiz',
            'data' => $data,
            'lesson_id' => $data->lesson_id
        ]);
    }

    public function update(Request $req, $id)
    {
        Quiz::where('id',$id)
            ->update([
                'minute' => $req->minute
            ]);
        $code = Quiz::find($id)->code;
        return redirect()->back()->with([
            'status'=>'saved',
            'name' => 'Quiz-'.str_pad($code,4,0,STR_PAD_LEFT)
        ]);
    }

    public function destroy(Request $req)
    {
        $id = $req->quiz_id;
        $lesson_id = Quiz::find($id)->lesson_id;
        $code = Quiz::find($id)->code;
        $name = 'Quiz-'.str_pad($code,4,0,STR_PAD_LEFT);
        Quiz::where('id',$id)
            ->delete();
        Question::where('quiz_id',$id)
            ->delete();
        return redirect('instructor/quiz/'.$lesson_id)->with([
            'status' => 'deleted','name' => $name]);
    }
}
