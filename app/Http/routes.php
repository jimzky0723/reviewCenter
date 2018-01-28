<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeCtrl@index');

//LOGIN PROCESS
Route::post('login/validate','LoginCtrl@validateLogin');
Route::get('logout',function(){
    \Illuminate\Support\Facades\Session::flush();
    return redirect('/');
});
//..LOGIN PROCESS

//ADMIN PAGE
Route::get('admin/home', 'admin\HomeCtrl@index');

Route::get('admin/center', 'admin\CenterCtrl@index');
Route::get('admin/center/add', 'admin\CenterCtrl@add');
Route::post('admin/center/save','admin\CenterCtrl@save');
//..ADMIN PAGE

//VALIDATE LOGIN
Route::get('validate',function(){
    $user = \Illuminate\Support\Facades\Session::get('access');
    if($user->level==='admin'){
        return redirect('admin/home');
    }else if($user->level==='center'){
        return redirect('center/home');
    }else if($user->level==='instructor'){
        return redirect('instructor/home');
    }else if($user->level==='student'){
        return redirect('student/home');
    }else{
        return redirect('home');
    }
});
//...VALIDATE LOGIN

//LOCATION ROUTES
Route::get('location/muncity/{provCode}','LocationCtrl@muncity');
Route::get('location/barangay/{muncityCode}','LocationCtrl@barangay');
//...LOCATION ROUTES