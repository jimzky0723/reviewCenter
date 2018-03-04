<?php

namespace App\Http\Controllers\admin;

use App\Center;
use App\Payment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PaymentCtrl extends Controller
{
    public function __construct()
    {
        $this->middleware('access');
        $this->middleware('admin');
    }

    public function history($center_id)
    {
        $center = Center::find($center_id);
        $payments = Payment::where('user_id',$center->user_id)
                ->get();
        $data = array();
        foreach($payments as $row){
            $data[] = array(
                'id' => $row->id,
                'amount' => number_format($row->payment,2),
                'date' => date('M d, Y',strtotime($row->created_at)),
                'no_month' => $row->no_month,
                'remarks' => $row->remarks
            );
        }
        return $data;
    }

    public function pay(Request $req)
    {
        $center_id = $req->currentID;
        $center = Center::find($center_id);
        $no_month = $req->no_month;
        if($no_month>0){
            $date = $center->date_expired;
            $newdate = strtotime("+$no_month month",strtotime($date));
            $newdate = date('Y-m-d',$newdate);
            Center::where('id',$center_id)
                ->update([
                    'date_expired' => $newdate,
                    'no_month' => $no_month
                ]);
            $q = new Payment();
            $q->type = 'center';
            $q->user_id = $center->user_id;
            $q->payment = $req->amount;
            $q->no_month = $no_month;
            $q->remarks = $req->remarks;
            $q->save();

            return redirect()->back()->with('status','paid');
        }else{
            $q = new Payment();
            $q->type = 'center';
            $q->user_id = $center->user_id;
            $q->payment = $req->amount;
            $q->no_month = $no_month;
            $q->remarks = $req->remarks;
            $q->save();

            return redirect()->back()->with('status','paid');
        }
    }
}
