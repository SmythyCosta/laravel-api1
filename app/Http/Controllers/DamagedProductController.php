<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DamagedProduct;


class DamagedProductController extends Controller
{

	public function productSave(Request $request)
    {
        $product_id = $request->input('allProduct');
        $quantity = $request->input('quantity');

        $damagedProduct = new DamagedProduct;
        $damagedProduct->product_id = $product_id;
        $damagedProduct->quantity = $quantity;
        $damagedProduct->note = $request->input('note');
        $damagedProduct->created_at = date('Y-m-d');
        $damagedProduct->save();

        return response()->json(['status'=>200,'mesg'=>'Damaged Product Save Success']);
    
    }


    public function allDamagedProduct(Request $request)
    {
                                
        $product =  new DamagedProduct;
        $all = $product->productAll();

        return response()->json(['status'=>200,'product'=>$all]);
    }


    public function allProduct(Request $request)
    {
             
        $type = $request->input('type');
        if($type==0){
            $product =  DB::select('SELECT id,name FROM product WHERE id NOT in (SELECT id FROM damaged_product)');
        }else{
            $product = DB::select('SELECT id,name FROM product');
        }                   

        return response()->json(['status'=>200,'product'=>$product]);
    }


    public function getDamagedProduct(Request $request)
    {
        $id = $request->input('id'); 
        $single =  DamagedProduct::find($id);
        return response()->json(['status'=>200,'product'=>$single]); 
    }


    public function productUpdate(Request $request)
    {
        $id = $request->input('id');
        $product_id = $request->input('allProduct');
        $quantity = $request->input('quantity');

        $damagedProduct = DamagedProduct::find($id);
        $damagedProduct->product_id = $product_id;
        $damagedProduct->quantity = $quantity;
        $damagedProduct->note = $request->input('note');
        $damagedProduct->updated_at = date('Y-m-d');
        $damagedProduct->save();

        return response()->json(['status'=>200,'mesg'=>'Damaged Product Update Success']);
    
    }

}