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
    

}	
