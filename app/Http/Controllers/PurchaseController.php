<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Product;
use App\Purchase;

class PurchaseController extends Controller{
    
    public function getAllPurchasesProduct(Request $request)
    {
        $all = Product::select('id','name')->where('status',1)->get();           
        return response()->json(['status'=>200,'product'=>$all]); 
    }
    
}	
