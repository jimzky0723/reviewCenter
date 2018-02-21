<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Http\Requests;

class LoginCtrl extends Controller
{
    public function __construct()
    {

    }

    public function validateLogin(Request $req)
    {
        $login = User::where('username',$req->user)
            ->first();
        if($login){
            if($login->status==='pending'){
                return 'pending';
            }else{
                if(Hash::check($req->pass,$login->password))
                {
                    Session::put('access',$login);
                    return 'success';
                }
                else
                {
                    return 'error';
                }
            }
        }else{
            return 'error';
        }
    }
}
