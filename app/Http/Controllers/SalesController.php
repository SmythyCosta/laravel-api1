<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Product;
use App\Purchase; 
use App\Invoice;
use App\Setting; 
use App\LibPDF\SalesPDF;

//libs
use Excel;

class SalesController extends Controller
{

	public function getCategoryByProduct(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('cat');
        $where = '';
        if ($type==1) {
            $where = " p.category_id={$id}";
        }else{
            $where = " p.sub_category_id={$id}";
        }
        $product = DB::select('SELECT p.id,p.name,p.stock_quantity,d.quantity as damagedQuantity FROM product p left join damaged_product d On p.id=d.product_id where p.status=1 and  '.$where);

        return response()->json(['status'=>200,'product'=>$product]);
    } 

    public function createNewSales(Request $request)
    {
        $product = $request->input('products');
        $sales['invoice_code'] = $request->input('invoiceCode');
        $sales['discount_percentage'] = $request->input('discount');
        $sales['vat_percentage'] = $request->input('vat');
        $sales['sub_total'] = $request->input('subTotal');
        $sales['grand_total'] = $request->input('grandTotal');
        $sales['due'] = $request->input('due');
        $sales['customer_id'] = $request->input('customer');
        $sales['created_at'] = $request->input('date');

        for ($i=0; $i <count($product) ; $i++) {
            $products[] = [
                'id' => $product[$i]['id'],
                'quantity' => $product[$i]['quantity'],
                'selling_price' => $product[$i]['selling_price'],
            ];
            $quantity = Product::find($product[$i]['id']);
            $quantity->stock_quantity = $quantity->stock_quantity - $product[$i]['quantity'];
            $quantity->save();

        }
        
        $sales['invoice_entries']   =   json_encode($products);
        $insert_id = DB::table('invoice')->insertGetId($sales);
        $payment['invoice_id'] = $insert_id;
        $payment['amount'] = $request->input('receivedAmount');
        $payment['type']   =   'income';
        $payment['customer_id'] = $request->input('customer');
        $payment['payment_type'] = $request->input('paymentType');
        $payment['created_at'] = $request->input('date');
        DB::table('payment')->insert($payment);

        return response()->json(['status'=>200,'sales_id'=>$insert_id]);
    }

    public function getAllSales(Request $request)
    {
        $sales =  new Invoice();
        $allData = $sales->getAllSales();
        return response()->json(['status'=>200,'sales'=>$allData]);
    }

    public function getInvoiceDetails(Request $request)
    {
        $setting = new Setting;  
        $settingData = $setting->settingData(); 
        $id = $request->input('id');
        $invoice =  DB::table('invoice')
                        ->join('customer', 'invoice.customer_id', '=', 'customer.id')
                        ->select('invoice.id',DB::raw('DATE_FORMAT(invoice.created_at,"%d %M %Y") as date'),'invoice.invoice_code','invoice.due','invoice.sub_total','invoice.grand_total','invoice.discount_percentage','invoice.vat_percentage','invoice.invoice_entries','invoice.customer_id','customer.name','customer.email','customer.phone')
                        ->where('invoice.id',$id)
                        ->first(); 
        $data['settingData']   =  $settingData;                      
        $data['customer_id']   =  $invoice->customer_id;                                
        $data['name']          =  $invoice->name;                                
        $data['email']         =  $invoice->email;                                
        $data['phone']         =  $invoice->phone;                                
        $data['discount']      =  $invoice->discount_percentage;                                
        $data['vat']           =  $invoice->vat_percentage;                                
        $data['invoice_id']    =  $invoice->id;                                
        $data['invoice_code']  =  $invoice->invoice_code;                                
        $data['date']          =  $invoice->date;                                
        $data['due']           =  $invoice->due;
        $data['sub_total']     =  $invoice->sub_total;
        $data['grand_total']   =  $invoice->grand_total;
        $product = [];  
        $invoice_info =json_decode($invoice->invoice_entries);
                        
        foreach ($invoice_info as $key => $value) {
            $product_info = DB::table('product')->select('serial_number','name')->where('id',$value->id)->first();
            $product['product_id'] = $value->id;
            $product['product_name'] = $product_info->name;
            $product['serial_number'] = $product_info->serial_number;
            $product['quantity'] = $value->quantity;
            $product['selling_price'] = $value->selling_price;
            $data['invoice_info'][] = $product;
            
        }
        $payment_info = DB::table('payment')->select('id',DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as date'),'amount','payment_type')->where('invoice_id',$invoice->id)->get();
        $totalPay = 0;
        foreach ($payment_info as $key => $value) {
            $totalPay += $value->amount;
            $payment[] = [
                'payment_id'    =>  $value->id,
                'payment_date'    =>  $value->date,
                'payment_amount'    =>  $value->amount,
                'payment_type'    =>  $value->payment_type,
            ];
        }
        $data['payment_info'] = $payment;
        $data['total_paid']   = $totalPay;
        return response()->json(['status'=>200,'invoice' => $data]);
    }

    public function salesTakePayment(Request $request)
    {
        if(!empty($request->input('receivedAmount'))){
            $invoice_id = $request->input('invoice_id');
            $receivedAmount = $request->input('receivedAmount');
            $date = $request->input('date');
            $invoice = Invoice::find($invoice_id);
            $invoice->due = $invoice->due-$receivedAmount;
            $invoice->updated_at = $date;
            $invoice->save();

            $payment['amount'] = $receivedAmount;
            $payment['type']   =   'income';
            $payment['customer_id'] = $request->input('customer_id');
            $payment['invoice_id'] = $invoice_id;
            $payment['payment_type'] = $request->input('paymentType');
            $payment['created_at'] = $request->input('date');
            DB::table('payment')->insert($payment);
        }
        return response()->json(['status'=>200,'invoice_id'=>$invoice_id]); 
    }

    public function exportpdf(Request $request)
    {
        $sales =  new Invoice();
        $allSales = $sales->getAllSales();
        $setting = Setting::where('id',1)->first();
        $pdf = new SalesPDF();
        $pdf->SetMargins(30, 10, 11.7);
        $pdf->AliasNbPages();
        $pdf->AddPage();
    
        $pdf->SetFont('Arial','B',12);
        // $pdf->Cell(5);
        $pdf->Cell(200,5,'Sales History List',0,1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,$setting->company_name,0,1,'L');
        $pdf->Cell(200,5,$setting->phone,0,1,'L');
        $pdf->Cell(200,5,$setting->address,0,1,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',12);
        $pdf->cell(20,6,"SL",1,"","C");
        $pdf->cell(35,6,"Invoice Code",1,"","C");
        $pdf->cell(45,6,"Customer Name",1,"","C");
        $pdf->cell(35,6,"date",1,"","C");
        $pdf->cell(35,6,"Amount",1,"","C");
        $pdf->cell(35,6,"Due",1,"","C");
        $pdf->cell(35,6,"Payment Type",1,"","C");
        $pdf->Ln();
        $pdf->SetFont('Times','',10);

        foreach ($allSales as $key => $value) {
            $payment = DB::table('payment')->select(DB::raw('sum(amount) as totalAmount'))->where('invoice_id',$value->id)->first();
            $pdf->cell(20,5,$key+1,1,"","C");
            $pdf->cell(35,5,$value->invoice_code,1,"","L");
            $pdf->cell(45,5,$value->customerName,1,"","L");
            $pdf->cell(35,5,$value->date,1,"","L");
            $pdf->cell(35,5,$payment->totalAmount,1,"","C");
            $pdf->cell(35,5,$value->due,1,"","C");
            $pdf->cell(35,5,(($value->payment_type==1) ? 'cash' :($value->payment_type==2) ? 'check' : 'card'),1,"","C");
            $pdf->Ln();
        }
        $pdf->Output();
        exit;
    }

    public function downloadExcel()
    {
        $type = 'xlsx';
        
        $setting = Setting::where('id',1)->first();
        Excel::create('Sales-history-list', function ($excel) {
            $excel->setTitle('Sales History List');

            // Chain the setters
            $excel->sheet('Sales History', function ($sheet) {

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
                $sheet->row(1, array('Sales History List'));

                // second row styling and writing content
                /*$sheet->row(2, function ($row) {

                    // call cell manipulation methods
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(15);
                    $row->setFontWeight('bold');

                });*/

                // $sheet->row(2, array('Something else here'));

                // getting data to display - in my case only one record

                $sales =  new Invoice();
                $allSales = $sales->getAllSales();
                // setting column names for data - you can of course set it manually
                //$sheet->appendRow(array_keys($users[0])); // column names

                $sheet->appendRow(2,
                                    array(
                                        'ID',
                                        'Invoice Code',
                                        'Name',
                                        'Date',
                                        'Amount',
                                        'Deu'
                                        )
                                    );

                // getting last row number (the one we already filled and setting it to bold
                $sheet->row($sheet->getHighestRow(), function ($row) {
                    $row->setFontWeight('bold');
                    $row->setAlignment('center');
                    $row->setBorder('thin', 'thin', 'thin', 'thin');
                });

                // putting users data as next rows
                foreach ($allSales as $data) {
                    $payment = DB::table('payment')->select(DB::raw('sum(amount) as totalAmount'))->where('invoice_id',$data->id)->first();
                    $sheet->appendRow(
                                    array(
                                        $data->id,
                                        $data->invoice_code,
                                        $data->customerName,
                                        $data->date,
                                        $payment->totalAmount,
                                        $data->due
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

}