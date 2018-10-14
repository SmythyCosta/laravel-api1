<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Product;
use App\Purchase; 
use App\Supplier;
use App\Setting; 
use App\LibPDF\PurchasePDF;

class PurchaseController extends Controller{
    
    public function getAllPurchasesProduct(Request $request)
    {
        $all = Product::select('id','name')->where('status',1)->get();           
        return response()->json(['status'=>200,'product'=>$all]); 
    }

    public function getProductForPurchases(Request $request)
    {
    	$id = $request->productId;
    	$single = Product::find($id);
        $data = [
            'id'  => $single->id,
            'serial_number'  => $single->serial_number,
            'name'  => $single->name,
            'category_id'  => $single->category_id,
            'sub_category_id'  => $single->sub_category_id,
            'purchase_price'  => $single->purchase_price,
            'selling_price'  => $single->selling_price,
            'note'  => $single->note,
            'stock_quantity'  => $single->stock_quantity
        ];
        return response()->json(['status'=>200,'product'=>$data]);
    }

    public function getAllSupplier(Request $request)
    {
        $all = Supplier::select('id','company','name')->where('status',1)->get();           
        return response()->json(['status'=>200,'supplier'=>$all]); 
    }

    public function getAllPurchases(Request $request)
    {
        $purchase =  new Purchase();
        $all = $purchase->allPurchase();
        return response()->json(['status'=>200,'purchase'=>$all]);
    }

    public function createNewPurchase(Request $request)
    {
        $product = $request->input('products');
        $purchase['purchase_code'] = $request->input('purchaseCode');
        $purchase['supplier_id'] = $request->input('supplierName');
        $purchase['due'] = $request->input('due');
        $purchase['created_at'] = $request->input('date');

        for ($i=0; $i <count($product) ; $i++) {
            $products[] = [
                'id' => $product[$i]['id'],
                'quantity' => $product[$i]['quantity'],
                'purchase_price' => $product[$i]['purchase_price'],
            ];
            $quantity = Product::find($product[$i]['id']);
            $quantity->stock_quantity = $quantity->stock_quantity + $product[$i]['quantity'];
            $quantity->save();
        }

        $purchase['purchase_info']   =   json_encode($products);
        $insert_id = DB::table('purchase')->insertGetId($purchase);
        $payment['purchase_id'] = $insert_id;
        $payment['amount'] = $request->input('receivedAmount');
        $payment['type']   =   'expense';
        $payment['supplier_id'] = $request->input('supplierName');
        $payment['payment_type'] = $request->input('paymentType');
        $payment['created_at'] = $request->input('date');

        DB::table('payment')->insert($payment);
        return response()->json(['status'=>200,'purchase_id'=>$insert_id]);
    }

    public function getPurchasesDetails(Request $request)
    {
        $setting = new Setting;  
        $settingData = $setting->settingData(); 

        $id = $request->input('id');
        $purchase =  DB::table('purchase')
                        ->join('supplier', 'purchase.supplier_id', '=', 'supplier.id')
                        ->select('purchase.id',DB::raw('DATE_FORMAT(purchase.created_at,"%d %M %Y") as date'),'purchase.purchase_code','purchase.due','purchase.purchase_info','supplier.company','supplier.name','supplier.email','supplier.phone')
                        ->where('purchase.id',$id)
                        ->first(); 

        $payment = DB::table('payment')->select(DB::raw('sum(amount) as totalAmount'))->where('purchase_id',$purchase->id)->first();

        $data['company']       =  $purchase->company;                                
        $data['name']          =  $purchase->name;                                
        $data['email']         =  $purchase->email;                                
        $data['phone']         =  $purchase->phone;                                
        $data['purchase_code'] =  $purchase->purchase_code;                                
        $data['date']          =  $purchase->date;                                
        $data['due']           =  $purchase->due;
        $data['totalAmount']      =  $payment->totalAmount;
        $product = [];  
        $purchase_info =json_decode($purchase->purchase_info);
        $subtotal = 0;                          
        foreach ($purchase_info as $key => $value) {
            $product_info = DB::table('product')->select('serial_number','name')->where('id',$value->id)->first();
            $product['product_id'] = $value->id;
            $product['product_name'] = $product_info->name;
            $product['serial_number'] = $product_info->serial_number;
            $product['quantity'] = $value->quantity;
            $product['purchase_price'] = $value->purchase_price;
            $data['purchase_info'][] = $product;
            $subtotal += $value->quantity * $value->purchase_price;
        }
        $data['subtotal'] = $subtotal;
        $data['settingData'] = $settingData;
        return response()->json(['status'=>200,'purchase' => $data]);
    }

    public function purchasesInvoiceDetails(Request $request)
    {
        $setting = new Setting;  
        $settingData = $setting->settingData(); 

        $id = $request->input('id');
        $purchase =  DB::table('purchase')
                        ->select('purchase.id',DB::raw('DATE_FORMAT(purchase.created_at,"%d %M %Y") as date'),'purchase.purchase_code','purchase.purchase_info','purchase.supplier_id','purchase.due')
                        ->where('purchase.id',$id)
                        ->first(); 
        $payment = DB::table('payment')->select(DB::raw('sum(amount) as totalAmount'))->where('purchase_id',$purchase->id)->first();                  
        $data['settingData']      = $settingData;                                 
        $data['purchase_id']      =  $purchase->id;                                                               
        $data['purchase_code']    =  $purchase->purchase_code;                                
        $data['date']             =  $purchase->date;                                
        $data['due']              =  $purchase->due;
        $data['supplier_id']      =  $purchase->supplier_id;
        $data['totalAmount']      =  $payment->totalAmount;                                
        $product = [];  
        $purchase_info =json_decode($purchase->purchase_info);
         $totalPrice = 0;               
        foreach ($purchase_info as $key => $value) {
            $product_info = DB::table('product')->select('serial_number','name')->where('id',$value->id)->first();
            $product['product_id'] = $value->id;
            $product['product_name'] = $product_info->name;
            $product['serial_number'] = $product_info->serial_number;
            $product['quantity'] = $value->quantity;
            $product['purchase_price'] = $value->purchase_price;
            $data['product_info'][] = $product;
            $totalPrice += $value->purchase_price * $value->quantity;
            
        }
        $data['total_price']   = $totalPrice;
    
        return response()->json(['status'=>200,'purchase' => $data]);
    }

    public function purchasesPaymentUpdate(Request $request)
    {
        if(!empty($request->input('receivedAmount'))){
            $purchase_id = $request->input('purchase_id');
            $receivedAmount = $request->input('receivedAmount');
            $date = $request->input('date');
            $purchase = Purchase::find($purchase_id);
            $purchase->due = $purchase->due-$receivedAmount;
            $purchase->updated_at = $date;
            $purchase->save();

            $payment['amount'] = $receivedAmount;
            $payment['type']   =   'expense';
            $payment['supplier_id'] = $request->input('supplier_id');
            $payment['purchase_id'] = $purchase_id;
            $payment['payment_type'] = $request->input('paymentType');
            $payment['created_at'] = $request->input('date');
            DB::table('payment')->insert($payment);
        }
        return response()->json(['status'=>200,'purchase_id'=>$purchase_id]); 
    }

    public function exportpdf(Request $request)
    {
        $purchase =  new Purchase();
        $allPurchase = $purchase->allPurchase();
        $setting = Setting::where('id',1)->first();
        $pdf = new PurchasePDF();
        $pdf->SetMargins(40, 10, 11.7);
        $pdf->AliasNbPages();
        $pdf->AddPage();
    
        $pdf->SetFont('Arial','B',12);
        // $pdf->Cell(5);
        $pdf->Cell(200,5,'Purchases History List',0,1,'L');
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(200,5,$setting->company_name,0,1,'L');
        $pdf->Cell(200,5,$setting->phone,0,1,'L');
        $pdf->Cell(200,5,$setting->address,0,1,'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial','B',12);
        $pdf->cell(25,6,"ID",1,"","C");
        $pdf->cell(45,6,"Purchase Code",1,"","C");
        $pdf->cell(45,6,"Name",1,"","C");
        $pdf->cell(35,6,"date",1,"","C");
        $pdf->cell(35,6,"Amount",1,"","C");
        $pdf->cell(35,6,"Due",1,"","C");
        $pdf->Ln();
        $pdf->SetFont('Times','',10);

        foreach ($allPurchase as $key => $value) {
            $pdf->cell(25,5,$key+1,1,"","C");
            $pdf->cell(45,5,$value->purchase_code,1,"","L");
            $pdf->cell(45,5,$value->company,1,"","L");
            $pdf->cell(35,5,$value->date,1,"","L");
            $pdf->cell(35,5,$value->amount,1,"","L");
            $pdf->cell(35,5,$value->due,1,"","L");
            $pdf->Ln();
        }
        $pdf->Output();
        exit;
    }

    public function downloadExcel()
    {
        $type = 'xlsx';
        
        $setting = Setting::where('id',1)->first();
        Excel::create('purchases-history-list', function ($excel) {
            $excel->setTitle('Purchases History List');

            // Chain the setters
            $excel->sheet('Purchases History', function ($sheet) {

                // first row styling and writing content
                $sheet->mergeCells('A1:E1');
                $sheet->row(1, function ($row) {
                    $row->setFontFamily('Comic Sans MS');
                    $row->setFontSize(30);
                });
                $sheet->row(1, array('Purchases History List'));

                // getting data to display - in my case only one record

                $purchase =  new Purchase();
                $allPurchase = $purchase->allPurchase();
                // setting column names for data - you can of course set it manually
                $sheet->appendRow(2,
                                    array(
                                        'ID',
                                        'Purchases Code',
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
                foreach ($allPurchase as $data) {
                    $payment = DB::table('payment')->select(DB::raw('sum(amount) as totalAmount'))->where('purchase_id',$data->id)->first();
                    $sheet->appendRow(
                                    array(
                                        $data->id,
                                        $data->purchase_code,
                                        $data->company,
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

            });

        })->export('xls');
    }


}	
