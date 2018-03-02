<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AnnouncementCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.announcement',[
            'title' => 'Announcements',
            'record' => array()
        ]);
    }
}
