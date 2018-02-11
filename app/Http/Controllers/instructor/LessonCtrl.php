<?php

namespace App\Http\Controllers\instructor;

use App\Classes;
use App\Http\Controllers\FileCtrl;
use App\Lesson;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LessonCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('instructor');
    }

    public function searchLesson(Request $req,$id)
    {
        if($req->keyword){
            Session::put('searchLesson',$req->keyword);
        }else{
            Session::forget('searchLesson');
        }
        return self::index($id);
    }
    public function index($id)
    {
        $keyword = Session::get('searchLesson');
        $user = Session::get('access');
        $check = Classes::where('instructor_id',$user->id)
            ->where('id',$id)
            ->first();

        if(!$check)
        {
            return redirect('instructor/home');
        }

        $data = Lesson::where('class_id',$id);
        if($keyword){
            $data = $data->where('title','like',"%$keyword%");
        }
        $data = $data->paginate(20);
        return view('instructor.lesson',[
            'title' => 'My Lessons',
            'data' => $data,
            'className' => Classes::find($id)->code,
            'classID' => $id
        ]);
    }

    static function string_limit_words($string, $word_limit) {
        $words = explode(' ', $string);
        return implode(' ', array_slice($words, 0, $word_limit));
    }

    public function create($id)
    {
        return view('instructor.addLesson',[
            'className' => Classes::find($id)->code,
            'classID' => $id,
            'title' => 'Add new lesson'
        ]);
    }

    public function store(Request $req,$id)
    {
        $title = $req->title;
        $content = $req->contents;
        $file = $req->file('file');
        $filename = '';
        if($file)
        {
            $filetype = $file->getClientOriginalExtension();
            $origin = $file->getClientOriginalName();
            $path = 'public/upload';
            $filename = urlencode($title).'.'.$filetype;
            $file->move($path,$filename);
        }

        $dateOpen = date('Y-m-d',strtotime($req->dateOpen));

        $q = new Lesson();
        $q->class_id = $id;
        $q->title = $title;
        $q->content = $content;
        $q->file = $filename;
        $q->date_open = $dateOpen;
        $q->save();

        return redirect()->back()->with('status','saved');

        //dd($_FILES);
    }

    public function show($id,$lesson_id)
    {
        $lesson = Lesson::find($lesson_id);

        return view('instructor.editLesson',[
            'title' => 'Update Lesson',
            'classID' => $id,
            'lessonID' => $lesson_id,
            'lesson' => $lesson
        ]);
    }

    public function update(Request $req, $lesson_id)
    {
        $title = $req->title;
        $content = $req->contents;
        $file = $req->file('file');
        if($file){
            $filetype = $file->getClientOriginalExtension();
            $origin = $file->getClientOriginalName();
            $path = 'public/upload';
            $filename = urlencode($title).'.'.$filetype;
            $file->move($path,$filename);

            Lesson::where('id',$lesson_id)
                ->update([
                    'file' => $filename
                ]);
        }

        $dateOpen = date('Y-m-d',strtotime($req->dateOpen));

        Lesson::where('id',$lesson_id)
            ->update([
                'title' => $title,
                'content' => $content,
                'date_open' => $dateOpen,
            ]);

        return redirect()->back()->with('status','saved');
    }

    public function destroy($id)
    {
        $mask = str_pad($id,4,0,STR_PAD_LEFT);
        $name = 'Lesson ID'.$mask;
        $class_id = Lesson::find($id)->class_id;
        $file = Lesson::find($id)->file;
        FileCtrl::removeFile($file);
        Lesson::where('id',$id)
            ->delete();
        return redirect('instructor/lesson/'.$class_id)->with([
            'status' => 'deleted','name' => $name]);
    }

}
