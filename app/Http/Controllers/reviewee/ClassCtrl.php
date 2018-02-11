<?php

namespace App\Http\Controllers\reviewee;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClassCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('reviewee');
    }

    public function index()
    {
        return view('reviewee.class');
    }
}
