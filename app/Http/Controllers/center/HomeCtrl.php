<?php

namespace App\Http\Controllers\center;

use App\AnnoucementStatus;
use App\Announcement;
use App\Feedback;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class HomeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('center');
    }

    public function index()
    {
        $user = Session::get('access');
        $announcement = Announcement::where('target','center')
                ->orderBy('updated_at','desc')
                ->paginate(10);
        $feedback = Feedback::select('users.fname','users.lname','feedback.created_at','feedback.contents','feedback.satisfaction as heart')
                ->leftJoin('users','users.id','=','feedback.user_id')
                ->where('users.center_id',$user->center_id)
                ->where('feedback.type','feedback')
                ->orderBy('feedback.created_at','desc')
                ->limit(10)
                ->get();
        return view('center.home',[
            'title' => 'Welcome '.$user->fname,
            'countAnnouncement' => self::countAnnouncement(),
            'announcement' => $announcement,
            'feedback' => $feedback
        ]);
    }

    public static function countAnnouncement()
    {
        $user = Session::get('access');
        $x = Announcement::where('target','center')->count();
        $y = AnnoucementStatus::where('user_id',$user->id)->count();
        $count = $x - $y;
        return $count;
    }

    public function center()
    {
        return view('admin.centers');
    }

    public function addCenter()
    {
        return view('admin.addCenter');
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
