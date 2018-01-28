<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.home');
    }

    public function center()
    {
        return view('admin.centers');
    }

    public function addCenter()
    {
        return view('admin.addCenter');
    }
}
