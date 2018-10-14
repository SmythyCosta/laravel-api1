<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Invoice;
use App\Setting;
use App\LibPDF\SalesPDF;

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

    public function salesReportExportPdf(Request $request)
    {
        $invoice = new Invoice();
        $report = $invoice->salesReportData($request);

        $setting = Setting::where('id',1)->first();
        $pdf = new SalesPDF();
        $pdf->SetMargins(25, 10, 11.7);
        $pdf->AliasNbPages();
        $pdf->AddPage();
    
        $pdf->SetFont('Arial','B',12);
        // $pdf->Cell(5);
        $pdf->Cell(200,5,'Sales Report',0,1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,$setting->company_name,0,1,'L');
        $pdf->Cell(200,5,$setting->phone,0,1,'L');
        $pdf->Cell(200,5,$setting->address,0,1,'L');
        $pdf->Cell(200,5,'Currency : '.$setting->currency,0,1,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',12);
        $pdf->cell(15,6,"SL",1,"","C");
        $pdf->cell(35,6,"Invoice Code",1,"","C");
        $pdf->cell(45,6,"Customer Name",1,"","C");
        $pdf->cell(35,6,"Date",1,"","C");
        $pdf->cell(45,6,"Amount",1,"","C");
        $pdf->cell(35,6,"Due",1,"","C");
        $pdf->cell(35,6,"Payment Type",1,"","C");
        $pdf->Ln();
        $pdf->SetFont('Times','',10);

        foreach ($report as $key => $value) {
            $pdf->cell(15,5,$key+1,1,"","C");
            $pdf->cell(35,5,$value->invoice_code,1,"","L");
            $pdf->cell(45,5,$value->name,1,"","L");
            $pdf->cell(35,5,$value->date,1,"","C");
            $pdf->cell(45,5,$value->amount,1,"","C");
            $pdf->cell(35,5,$value->due,1,"","C");
            $pdf->cell(35,5,(($value->payment_type==1) ? 'cash' :($value->payment_type==2) ? 'check' : 'card'),1,"","C");
            $pdf->Ln();
        }

        $pdf->Output();
        exit;
    }

}