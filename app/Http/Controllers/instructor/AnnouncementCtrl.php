<?php

namespace App\Http\Controllers\instructor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        return view('instructor.announcement',[
            'record' => $record,
            'title' => 'Announcement'
        ]);
    }
}
