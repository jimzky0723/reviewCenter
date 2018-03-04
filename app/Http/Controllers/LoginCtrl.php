<?php

namespace App\Http\Controllers;

use App\Center;
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
            $center_id = $login->center_id;
            if($center_id){
                $status = self::checkCenter($center_id);
                if($status==='inactive')
                {
                    return 'inactive';
                }
            }

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

    public function checkCenter($id)
    {
        $center = Center::find($id);
        $current = date('Y-m-d');
        $expire = $center->date_expired;
        if($current>=$expire)
        {
            Center::where('id',$id)
                ->update([
                    'status' => 'inactive'
                ]);
            return 'inactive';
        }else{
            return 'active';
        }
    }

}
