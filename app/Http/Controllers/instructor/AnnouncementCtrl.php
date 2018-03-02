<?php

namespace App\Http\Controllers\instructor;

use App\Announcement;
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
        $record = array();
        $user = Session::get('access');

        $count = Announcement::select('announcement.date_created','announcement.id','announcement.content');

        $count = $count->orwhere(function($q) use ($user){
            $q = $q->where('target','instructor')
                ->where('user_id',0);
        });

        $count = $count->orwhere('created_by',$user->id);

        $count = $count->where('center_id',$user->center_id);

        $count = $count->orderBy('date_created','desc')
            ->orderBy('id','desc')
            ->paginate(10);
        return view('instructor.announcement',[
            'record' => $count,
            'title' => 'Announcement'
        ]);
    }

    public function create()
    {
        return view('instructor.addAnnouncement',[
            'title' => 'Add Announcement'
        ]);
    }

    public function store(Request $req)
    {
        $user = Session::get('access');
        $q = new Announcement();
        $q->target = 'reviewee';
        $q->content = $req->contents;
        $q->date_created = date('Y-m-d');
        $q->created_by = $user->id;
        $q->center_id = $user->center_id;
        $q->save();

        return redirect()->back()->with('status','saved');
    }
}
