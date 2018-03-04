<?php

namespace App\Http\Controllers\reviewee;

use App\AnnoucementStatus;
use App\Announcement;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HomeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('reviewee');
    }

    public function index()
    {
        $user = Session::get('access');
        $announcement = Announcement::select('announcement.*')
            ->leftJoin('reviewee','reviewee.class_id','=','announcement.subject_id')
            ->where(function($q) use($user){
                $q = $q->orwhere('announcement.user_id',0)
                        ->orwhere('announcement.user_id',$user->id);
            })
            ->where('announcement.center_id',$user->center_id)
            ->where('target','reviewee')
            ->orderBy('updated_at','desc')
            ->groupBy('announcement.id')
            ->paginate(10);

        return view('reviewee.home',[
            'title' => 'Welcome '.$user->fname,
            'countAnnouncement' => self::countAnnouncement(),
            'announcement' => $announcement
        ]);
    }

    public static function countAnnouncement()
    {
        $user = Session::get('access');
        $x = Announcement::leftJoin('reviewee','reviewee.class_id','=','announcement.subject_id')
            ->where(function($q) use($user){
                $q = $q->orwhere('announcement.user_id',0)
                    ->orwhere('announcement.user_id',$user->id);
            })
            ->where('announcement.center_id',$user->center_id)
            ->where('target','reviewee')
            ->groupBy('announcement.id')
            ->get();
        $x = count($x);
        $y = AnnoucementStatus::where('user_id',$user->id)->count();
        $count = $x - $y;
        return $count;
    }

    public function read($announcement_id)
    {
        $user = Session::get('access');
        $q = new AnnoucementStatus();
        $q->announcement_id = $announcement_id;
        $q->user_id = $user->id;
        $q->save();

        return self::countAnnouncement();
    }
}
