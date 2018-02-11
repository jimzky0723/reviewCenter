<?php

namespace App\Http\Controllers\instructor;

use App\Classes;
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

    public function index($class_id)
    {
        $data = Quiz::where('class_id',$class_id)
            ->paginate(20);
        $class = Classes::find($class_id);
        return view('instructor.quiz',[
            'data' => $data,
            'class_name' => $class->code,
            'class_id' => $class_id,
            'title' => 'Quizzes'
        ]);
    }

    public function create($class_id)
    {
        $count = Quiz::where('class_id',$class_id)
            ->orderBy('id','desc')
            ->first();

        if($count){
            $count = $count->id;
        }else{
            $count = 0;
        }
        $last_id = $count + 1;

        return view('instructor.addQuiz',[
            'class_id' => $class_id,
            'title' => 'Add New Quiz',
            'last_id' => $last_id
        ]);
    }

    public function store(Request $req)
    {
        $q = new Quiz();
        $q->code =  $req->code;
        $q->class_id = $req->class_id;
        $q->date_open = date('Y-m-d',strtotime($req->date_open));
        $q->save();
        return redirect()->back()->with('status','saved');
    }

    public function show($id)
    {
        $data = Quiz::find($id);
        return view('instructor.editQuiz',[
            'title' => 'Update Quiz',
            'data' => $data,
            'class_id' => $data->class_id
        ]);
    }

    public function update(Request $req, $id)
    {
        Quiz::where('id',$id)
            ->update([
                'date_open' => date('Y-m-d',strtotime($req->date_open))
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
        $class_id = Quiz::find($id)->class_id;
        $code = Quiz::find($id)->code;
        $name = 'Quiz-'.str_pad($code,4,0,STR_PAD_LEFT);
        Quiz::where('id',$id)
            ->delete();
        Question::where('quiz_id',$id)
            ->delete();
        return redirect('instructor/quiz/'.$class_id)->with([
            'status' => 'deleted','name' => $name]);
    }
}
