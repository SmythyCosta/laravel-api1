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

}	
