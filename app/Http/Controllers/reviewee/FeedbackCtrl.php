<?php

namespace App\Http\Controllers\reviewee;

use App\Feedback;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class FeedbackCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('reviewee');
    }

    public function store(Request $req)
    {
        $user = Session::get('access');
        $q = new Feedback();
        $q->user_id = $user->id;
        $q->satisfaction = $req->satisfaction;
        $q->contents = $req->contents;
        $q->save();

        return redirect()->back()->with('status','feedbackSent');
    }
}
