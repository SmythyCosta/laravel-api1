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

}