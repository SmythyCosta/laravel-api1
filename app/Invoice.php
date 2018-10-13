<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

}