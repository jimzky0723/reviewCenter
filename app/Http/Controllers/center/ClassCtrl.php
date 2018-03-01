<?php

namespace App\Http\Controllers\center;

use App\classDays;
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
        $data = Classes::select('classes.time_in','classes.time_out','classes.desc','classes.id','classes.code','classes.instructor_id','users.fname','users.lname','classes.date_open','classes.date_close')
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
            'title' => 'List of Subjects',
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
                ->where('level','instructor')
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
            'title' => 'Add New Subject',
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
        $date_open = '0000-00-00';
        $date_close = '0000-00-00';
        if($request->date_range){
            $range = explode(" - ",$request->date_range);
            $date_open = date('Y-m-d',strtotime($range[0]));
            $date_close = date('Y-m-d',strtotime($range[1]));
        }

        $q = new Classes();
        $q->instructor_id = $instructor_id;
        $q->code = $code;
        $q->desc = $request->desc;
        $q->center_id = $center_id;
        $q->time_in = $request->time_in;
        $q->time_out = $request->time_out;
        $q->date_open = $date_open;
        $q->date_close = $date_close;
        $q->save();

        if(count($request->days)){
            foreach($request->days as $day){
                $r = new classDays();
                $r->class_id = $q->id;
                $r->day = $day;
                $r->save();
            }
        }

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
        $date_open = '0000-00-00';
        $date_close = '0000-00-00';
        if($request->date_range){
            $range = explode(" - ",$request->date_range);
            $date_open = date('Y-m-d',strtotime($range[0]));
            $date_close = date('Y-m-d',strtotime($range[1]));
        }
        Classes::where('id',$id)
            ->update([
                'instructor_id' => $request->instructor,
                'code' => $request->code,
                'date_open' => $date_open,
                'date_close' => $date_close,
                'desc' => $request->desc,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out
            ]);

        classDays::where('class_id',$id)->delete();
        if(count($request->days)){
            foreach($request->days as $day){
                $r = new classDays();
                $r->class_id = $id;
                $r->day = $day;
                $r->save();
            }
        }

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
            ->where('level','reviewee')
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

    public static function checkDay($class_id,$day)
    {
        $check = classDays::where('class_id',$class_id)
                ->where('day',$day)
                ->first();
        if($check){
            return true;
        }
        return false;
    }
}
