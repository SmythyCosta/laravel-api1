<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Invoice extends Model
{
    //
    protected $table = "invoice";

    public function getAllSales()
    {
    	return DB::table('invoice')
                        ->join('customer','invoice.customer_id','=','customer.id')
                        ->join('payment','invoice.id','=','payment.invoice_id')
                        ->select(DB::raw('DATE_FORMAT(invoice.created_at,"%d %M %Y") as date'),DB::raw('sum(payment.amount) as totalAmount'),'payment.payment_type','invoice.id','invoice.invoice_code','invoice.due','customer.name as customerName')
                        ->groupBy('invoice.id')
                        ->orderBy('invoice.id', 'desc')
                        ->get();
    }

    public function salesReportData(Request $request)
    {
        $fromDate = $request->input('fromdate');
        $toDate = $request->input('todate');

        $report =   DB::table('invoice')
                            ->join('customer','invoice.customer_id','=','customer.id')
                            ->join('payment','invoice.id','=','payment.invoice_id')
                            ->select(DB::raw('DATE_FORMAT(invoice.created_at,"%d %M %Y") as date'),'invoice.due','invoice.invoice_code','payment.payment_type',DB::raw('sum(payment.amount) as amount'),'customer.name')
                            ->where('payment.type','income')
                            ->whereRaw("invoice.created_at >= '".$fromDate." 00:00:00' AND invoice.created_at <= '".$toDate." 00:00:00'")
                            ->groupBy('invoice.id')
                            ->orderBy('invoice.id','DESC')
                            ->get();

        return $report; 
    }
    

}