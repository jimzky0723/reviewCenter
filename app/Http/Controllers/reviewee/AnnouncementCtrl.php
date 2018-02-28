<?php

namespace App\Http\Controllers\reviewee;

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
        $this->middleware('reviewee');
    }

    public function index()
    {
        $user = Session::get('access');
        $center = Session::get('center');

        $count = Announcement::select('announcement.date_created','announcement.id','announcement.content');
        $count = $count->orwhere(function($q) use ($user){
            $q = $q->where('target','reviewee')
                ->where('user_id',$user->id);
        });

        $count = $count->orwhere(function($q) use ($user){
            $q = $q->where('target','center')
                ->where('center_id',$user->center_id);
        });

        $count = $count->orderBy('date_created','asc')
            ->get();
        $record = array();
        return view('reviewee.announcement',[
            'record' => $count,
            'title' => 'Announcement'
        ]);
    }

    public static function countAnnoucement()
    {
        $user = Session::get('access');
        $center = Session::get('center');

        $count = Announcement::select('announcement.id','announcement.content');
        $count = $count->orwhere(function($q) use ($user){
            $q = $q->where('target','reviewee')
                    ->where('user_id',$user->id);
        });

        $count = $count->orwhere(function($q) use ($user){
            $q = $q->where('target','center')
                ->where('center_id',$user->center_id);
        });

        $count = $count->count();
        return $count;

    }
}
