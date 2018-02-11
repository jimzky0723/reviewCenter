<?php

namespace App\Http\Controllers\instructor;

use App\Answers;
use App\Question;
use App\Quiz;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class QuestionCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('instructor');
    }

    public function index($quiz_id)
    {
        $quiz = Quiz::find($quiz_id);
        $quiz_name = 'Quiz-'.str_pad($quiz->id,4,0,STR_PAD_LEFT);
        $data = Question::where('quiz_id',$quiz_id)
            ->orderBy('id','desc')
            ->get();
        return view('instructor.question',[
            'data' => $data,
            'quiz_id' => $quiz_id,
            'quiz_name' => $quiz_name,
            'title' => 'Questions',
            'class_id' => $quiz->class_id
        ]);
    }

    public function store(Request $req,$quiz_id)
    {
        $uniq_question = self::convert_unique($quiz_id,$req->question);
        $q = "INSERT IGNORE questions(quiz_id,unique_id,question) VALUES(
                '".$quiz_id."',
                '".$uniq_question."',
                '".$req->question."'
            )";
        DB::select($q);

        $question_id = Question::where('unique_id',$uniq_question)
                ->first()
                ->id;
        self::addQuestion($question_id,$req->answer,1);
        self::addQuestion($question_id,$req->choice2,0);
        self::addQuestion($question_id,$req->choice3,0);
        self::addQuestion($question_id,$req->choice4,0);

        return redirect()->back()->with('status','saved');
    }

    public function addQuestion($question_id,$choice,$value)
    {
        $unique = self::convert_unique($question_id,$choice);
        $q = "INSERT IGNORE answers(question_id,unique_id,choice,value) VALUES(
                '".$question_id."',
                '".$unique."',
                '".$choice."',
                '".$value."'
            )";
        DB::select($q);
    }
    public function convert_unique($id,$string)
    {
        return $id.'_'.urlencode($string);
    }

    public function bulk(Request $req,$quiz_id)
    {
        $file = $_FILES['file']['name'];
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        if($ext=='csv') {
            $file = fopen($_FILES['file']['tmp_name'], "r");
            $data = array();
            while (!feof($file)) {
                $data[] = fgetcsv($file);
            }
            fclose($file);
            $cont = 0;
            foreach ($data as $row) {
                if($cont==0){
                    $cont++;
                    continue;
                }
                if($row){
                    $question = $row[0];
                    $answer = $row[1];
                    $choice2 = $row[2];
                    $choice3 = $row[3];
                    $choice4 = $row[4];

                    $uniq_question = self::convert_unique($quiz_id,$question);
                    $q = "INSERT IGNORE questions(quiz_id,unique_id,question) VALUES(
                    '".$quiz_id."',
                    '".$uniq_question."',
                    '".$question."'
                )";
                    DB::select($q);

                    $question_id = Question::where('unique_id',$uniq_question)
                        ->first()
                        ->id;
                    self::addQuestion($question_id,$answer,1);
                    self::addQuestion($question_id,$choice2,0);
                    self::addQuestion($question_id,$choice3,0);
                    self::addQuestion($question_id,$choice4,0);
                }
            }
        }
        return redirect()->back()->with('status','bulkSaved');
    }

    public function show($question_id)
    {
        $questions = Question::find($question_id);
        $choices = Answers::where('question_id',$question_id)->get();
        return array(
            'question' => $questions,
            'choices' => $choices
        );
    }

    public function update(Request $req,$quiz_id)
    {
        Question::where('id',$req->question_id)->delete();
        Answers::where('question_id',$req->question_id)->delete();

        $uniq_question = self::convert_unique($quiz_id,$req->question);
        $q = "INSERT IGNORE questions(quiz_id,unique_id,question) VALUES(
                '".$quiz_id."',
                '".$uniq_question."',
                '".$req->question."'
            )";
        DB::select($q);

        $question_id = Question::where('unique_id',$uniq_question)
            ->first()
            ->id;
        self::addQuestion($question_id,$req->answer,1);
        self::addQuestion($question_id,$req->choice2,0);
        self::addQuestion($question_id,$req->choice3,0);
        self::addQuestion($question_id,$req->choice4,0);

        return redirect()->back()->with('status','updated');
    }

    public function destroy(Request $req,$quiz_id)
    {
        $question_id = $req->question_id;
        Question::where('id',$question_id)->delete();
        Answers::where('question_id',$question_id)->delete();
        return redirect()->back()->with('status','deleted');
    }
}
