<?php

namespace App\Http\Controllers\center;

use App\Payment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('center');
    }

    public function history($user_id)
    {
        $payments = Payment::where('user_id',$user_id)
            ->get();
        $data = array();
        foreach($payments as $row){
            $data[] = array(
                'id' => $row->id,
                'amount' => number_format($row->payment,2),
                'date' => date('M d, Y',strtotime($row->created_at)),
                'remarks' => $row->remarks
            );
        }
        return $data;
    }

    public function pay(Request $req)
    {
        $user_id = $req->currentID;

        $q = new Payment();
        $q->type = 'center';
        $q->user_id = $user_id;
        $q->payment = $req->amount;
        $q->remarks = $req->remarks;
        $q->save();

        return redirect()->back()->with('status','paid');
    }
}
