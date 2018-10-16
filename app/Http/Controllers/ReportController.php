<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Invoice;
use App\Setting;
use App\Purchase;
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

    public function salesReportDownloadExcel(Request $request)
    {
        $setting = Setting::where('id',1)->first();
        Excel::create('sales report', function ($excel) use ($request) {
            $excel->setTitle('Sales Report');

            // Chain the setters
            $excel->sheet('sales report', function ($sheet) use ($request) {

                // first row styling and writing content
                $sheet->mergeCells('A1:E1');
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(30);
                    // $row->setBorder('solid', 'none', 'none', 'solid');
                });
                // $sheet->setBorder('A1:F1', 'thin');

                // Set all borders (top, right, bottom, left)
                // $cells->setBorder('solid', 'none', 'none', 'solid');
                $sheet->row(1, array('Sales Report'));


                // getting data to display - in my case only one record

              
                // setting column names for data - you can of course set it manually

                $sheet->appendRow(2,
                                    array(
                                        'SL',
                                        'Invoice Code',
                                        'Customer Name',
                                        'Date',
                                        'Amount',
                                        'Due',
                                        'Payment Type'
                                        )
                                    );

                // getting last row number (the one we already filled and setting it to bold
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setBorder('thin', 'thin', 'thin', 'thin');
                });
                
                $sheet->setColumnFormat(array( //se formatea la columna a texto
                    'B' => \PHPExcel_Style_NumberFormat::FORMAT_NUMBER,
                ));
                
                $invoice = new Invoice();
                $report = $invoice->salesReportData($request);
                // putting users data as next rows
                foreach ($report as $key => $data) {

                    $sheet->appendRow(
                                    array(
                                        $key+1,
                                        strval($data->invoice_code),
                                        $data->name,
                                        $data->date,
                                        $data->amount,
                                        $data->due,
                                        (($data->payment_type==1) ? 'cash' :($data->payment_type==2) ? 'check' : 'card')
                                        )
                                    );
                    $sheet->row($sheet->getHighestRow(), function ($row) {
                        $row->setAlignment('center');
                        $row->setBorder('thin', 'thin', 'thin', 'thin');
                    });
                }

                // die();
            });

        })->export('xls');
    }

    public function getPurchaseReportData(Request $request)
    {
        $purchase = new Purchase();
        $report = $purchase->purchaseReportData($request);
    	return response()->json(['status'=>200,'data'=>$report]); 
    }

}