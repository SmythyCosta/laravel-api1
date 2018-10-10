<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Purchase extends Model
{
	//
	protected $table = "purchase";


    public function allPurchase()
    {
    	$purchase = DB::table('purchase')
    				->join('supplier', 'purchase.supplier_id', '=', 'supplier.id')
    				->select(DB::raw('DATE_FORMAT(purchase.created_at,"%d %M %Y") as date'),'purchase.id','purchase.due','purchase.purchase_code','supplier.company')
    				->orderBy('purchase.id', 'desc')->get();
    	$data = [];
    	foreach ($purchase as $key => $value) {
    		$payment = DB::table('payment')->select(DB::raw('sum(amount) as totalAmount'))->where('purchase_id',$value->id)->first();
            // print_r($payment->totalAmount);
    		$data []= [
    			'id' => $value->id,
    			'date' => $value->date,
    			'due' => $value->due,
    			'purchase_code' => $value->purchase_code,
    			'company' => $value->company,
    			'amount' => $payment->totalAmount
    		];
    	}
    	return $data;
    }

    public function purchaseReportData(Request $request)
    {
        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');
        $report =   DB::table('purchase')
                            ->join('supplier', 'purchase.supplier_id', '=', 'supplier.id')
                            ->join('payment','payment.purchase_id','=','purchase.id')
                            ->select(DB::raw('DATE_FORMAT(purchase.created_at,"%d %M %Y") as date'),'purchase.due','purchase.purchase_code','payment.payment_type',DB::raw('sum(payment.amount) as amount'),'supplier.company')
                            ->whereRaw("purchase.created_at >= '".$fromDate." 00:00:00' AND purchase.created_at <= '".$toDate." 00:00:00'")
                            ->groupBy('purchase.id')
                            ->orderBy('purchase.id','DESC')
                            ->get();
        return $report;
    }


}