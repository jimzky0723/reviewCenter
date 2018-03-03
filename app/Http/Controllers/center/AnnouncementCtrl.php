<?php

namespace App\Http\Controllers\center;

use App\Announcement;
use App\Center;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AnnouncementCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('center');
    }

    public function index()
    {
        $user = Session::get('access');
        $record = Announcement::where('created_by',$user->id)
            ->orderBy('updated_at','desc')
            ->paginate(10);

        return view('center.announcement',[
            'title' => 'Announcements',
            'record' => $record
        ]);
    }

    public function create()
    {
        return view('center.addAnnouncement',[
            'title' => 'Add Announcement',
            'type' => 'add',
            'record' => array()
        ]);
    }

    public function edit($id)
    {
        $record = Announcement::find($id);

        return view('center.addAnnouncement',[
            'title' => 'Update Announcement',
            'type' => 'edit',
            'record' => $record
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
        $center_id = Center::where('user_id',$user->id)->first()->id;
        $q = new Announcement();
        $q->target = 'instructor';
        $q->center_id = $center_id;
        $q->content = $req->contents;
        $q->created_by = $user->id;
        $q->title = $req->title;
        $q->save();

        return redirect()->back()->with('status','saved');
    }

    public function delete(Request $req)
    {
        $id = $req->currentID;
        Announcement::where('id',$id)->delete();
        return redirect()->back()->with('status','deleted');
    }
}
