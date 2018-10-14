<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Product;
use App\Purchase; 
use App\Supplier;

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

}	
