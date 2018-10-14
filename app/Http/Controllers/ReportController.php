<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Invoice;

//libs
use Excel;

class ReportController extends Controller
{

    public function getSalesReportData(Request $request)
    {
        $invoice = new Invoice();
        $report = $invoice->salesReportData($request);
    	return response()->json(['status'=>200,'report'=>$report]); 
    }

    
}