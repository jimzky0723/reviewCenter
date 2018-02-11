<?php

namespace App\Http\Controllers\center;

use App\Classes;
use App\Instructor;
use App\Reviewee;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ClassCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('center');
    }

    public function search(Request $req)
    {
        if($req->keyword){
            Session::put('searchClass',$req->keyword);
        }else{
            Session::forget('searchClass');
        }

        return self::index();
    }

    public function index()
    {
        $center_id = Session::get('center');
        $keyword = Session::get('searchClass');
        $data = Classes::select('classes.id','classes.code','classes.instructor_id','users.fname','users.lname')
            ->leftJoin('users','users.id','=','classes.instructor_id')
            ->where('users.center_id',$center_id);
        if($keyword){
            $data = $data->where(function($q) use ($keyword){
                $q = $q->where('users.fname','like',"%$keyword%")
                    ->orwhere('users.lname','like',"%$keyword%")
                    ->orwhere('classes.code','like',"%$keyword%");
            });
        }
        $data = $data->orderBy('code','asc')
            ->paginate(20);
        return view('center.class',[
            'title' => 'List of Classes',
            'record' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $center_id = Session::get('center');
        $instructors = User::where('center_id',$center_id)
                ->orderBy('lname','asc')
                ->get();

        $last_id = Classes::where('center_id',$center_id)
                ->orderBy('id','desc')
                ->first();
        if(!$last_id){
            $last_id = 0;
        }else{
            $last_id = $last_id->id;
        }
        $last_id += 1;
        $last_id_name = str_pad($last_id, 3, '0', STR_PAD_LEFT);

        return view('center.addClass',[
            'title' => 'Add New Class',
            'instructors' => $instructors,
            'className' => $last_id_name.'-'.date('Y')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $instructor_id = $request->instructor;
        $code = $request->code;
        $center_id = Session::get('center');

        $q = new Classes();
        $q->instructor_id = $instructor_id;
        $q->code = $code;
        $q->center_id = $center_id;
        $q->save();

        return redirect()->back()->with('status','saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $center_id = Session::get('center');

        $record = Classes::where('id',$id)->first();
        $instructors = User::where('center_id',$center_id)
            ->orderBy('users.lname','asc')
            ->get();

        return view('center.editClass',[
            'title' => 'Edit Class',
            'record' => $record,
            'instructors' => $instructors
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Classes::where('id',$id)
            ->update([
                'instructor_id' => $request->instructor
            ]);
        return redirect()->back()->with('status','saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $name = Classes::find($id)->code;
        Classes::where('id',$id)
            ->delete();
        return redirect('center/class')->with([
            'status' => 'deleted','name' => $name]);
    }

    public function enroll($id)
    {
        $center_id = Session::get('center');

        $current = Reviewee::select('reviewee.user_id','users.*')
            ->leftJoin('users','users.id','=','reviewee.user_id')
            ->where('reviewee.class_id',$id)
            ->get();
        $ids = [];
        foreach($current as $row)
        {
            array_push($ids,$row->user_id);
        }
        $reviewees = User::where('users.center_id',$center_id)
            ->whereNotIn('id',$ids)
            ->orderBy('users.lname','asc')
            ->get();

        return view('center.assignReviewee',[
            'title' => 'Assign Reviewee',
            'record' => $reviewees,
            'current' => $current,
            'classID' => $id,
            'className' => Classes::find($id)->code
        ]);
    }

    public function enrollReviewee(Request $req, $id)
    {
        $user_id = $req->user_id;
        $q = new Reviewee();
        $q->user_id = $user_id;
        $q->center_id = Session::get('center');
        $q->class_id = $id;
        $q->save();
    }

    public function removeReviewee(Request $req, $id)
    {
        $user_id = $req->user_id;
        Reviewee::where('user_id',$user_id)
            ->where('class_id',$id)
            ->delete();
    }
}
