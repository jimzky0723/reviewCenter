<?php

namespace App\Http\Controllers;

use App\Province;
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
        $data = array(
            'provinces' => Province::orderBy('desc','asc')->get()
        );
        return view('home',$data);
    }
}
