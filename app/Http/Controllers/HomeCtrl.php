<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeCtrl extends Controller
{
    //
    public function __construct()
    {

    }

    public function index()
    {
        return view('home');
    }
}
