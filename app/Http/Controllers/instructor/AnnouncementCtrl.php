<?php

namespace App\Http\Controllers\instructor;

use App\Announcement;
use App\Center;
use App\Classes;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AnnouncementCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('instructor');
    }

    public function index()
    {
        $user = Session::get('access');
        $record = Announcement::where('created_by',$user->id)
            ->orderBy('updated_at','desc')
            ->paginate(10);

        return view('instructor.announcement',[
            'title' => 'Announcements',
            'record' => $record
        ]);
    }

    public function create()
    {
        $user = Session::get('access');
        $class = Classes::where('instructor_id',$user->id)
            ->orderBy('code','asc')
            ->get();


        return view('instructor.addAnnouncement',[
            'title' => 'Add Announcement',
            'type' => 'add',
            'record' => array(),
            'class' => $class
        ]);
    }

    public function edit($id)
    {
        $user = Session::get('access');
        $record = Announcement::find($id);
        $class = Classes::where('instructor_id',$user->id)
            ->orderBy('code','asc')
            ->get();
        return view('instructor.addAnnouncement',[
            'title' => 'Update Announcement',
            'type' => 'edit',
            'record' => $record,
            'class' => $class
        ]);
    }

    public function update(Request $req)
    {
        Announcement::where('id',$req->currentID)
            ->update([
                'content' => $req->contents,
                'title' => $req->title
            ]);
        return redirect()->back()->with('status','updated');
    }

    public function store(Request $req)
    {

        $user = Session::get('access');
        foreach($req->targets as $target){
            $q = new Announcement();
            $q->target = 'reviewee';
            $q->center_id = $user->center_id;
            $q->content = $req->contents;
            $q->subject_id = $target;
            $q->created_by = $user->id;
            $q->title = $req->title;
            $q->save();
        }

        return redirect()->back()->with('status','saved');
    }

    public function delete(Request $req)
    {
        $id = $req->currentID;
        Announcement::where('id',$id)->delete();
        return redirect()->back()->with('status','deleted');
    }
}
