<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Muncity;
use Illuminate\Http\Request;

use App\Http\Requests;

class LocationCtrl extends Controller
{
    public function __construct()
    {

    }

    public function muncity($provCode)
    {
        return Muncity::where('provCode',$provCode)
            ->orderBy('desc','asc')
            ->get();
    }

    public function barangay($muncityCode)
    {
        return Barangay::where('muncityCode',$muncityCode)
            ->orderBy('desc','asc')
            ->get();
    }
}
