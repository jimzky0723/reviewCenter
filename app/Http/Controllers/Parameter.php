<?php

namespace App\Http\Controllers;

use App\Center;
use App\Instructor;
use App\Reviewee;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class Parameter extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
    }

    public function checkProfile(Request $req)
    {
        $center_id = Session::get('center');

        $record = array();

        $users = User::where('level','!=','admin')
                ->where('level','!=','center')
                ->where('center_id',$center_id);

        if($req->fname){
            $users = $users->where('fname','like',"%$req->fname%");
        }

        if($req->mname){
            $users = $users->where('mname','like',"%$req->mname%");
        }

        if($req->lname){
            $users = $users->where('lname','like',"%$req->lname%");
        }


        $users = $users ->orderBy('lname','asc')
            ->get();


        return $users;
    }

    public function checkUsername(Request $req)
    {
        $username = $req->username;
        $check = User::where('username',$username);
        if($req->id){
            $check = $check->where('id','!=',$req->id);
        }
        $check = $check->first();
        if($check){
            return 1;
        }
        return 0;
    }

    static function getAge($date){
        //date in mm/dd/yyyy format; or it can be in other formats as well
        $birthDate = date('m/d/Y',strtotime($date));
        //explode the date to get month, day and year
        $birthDate = explode("/", $birthDate);
        //get age from date or birthdate
        $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
            ? ((date("Y") - $birthDate[2]) - 1)
            : (date("Y") - $birthDate[2]));
        return $age;
    }
}
