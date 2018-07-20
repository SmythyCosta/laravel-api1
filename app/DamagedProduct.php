<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DamagedProduct extends Model
{
    //
    protected $table = "damaged_product";


    public function productAll()
    {
    	return DB::table('damaged_product')
                        ->join('product', 'damaged_product.product_id', '=', 'product.id')
                        ->join('category', 'product.category_id', '=', 'category.id')
                        ->select(DB::raw('DATE_FORMAT(damaged_product.created_at,"%d %M %Y") as date'),'damaged_product.id','damaged_product.quantity','damaged_product.note','damaged_product.note','product.serial_number','product.name','product.purchase_price', 'category.name as categoryName')
                        ->orderBy('damaged_product.id','DESC')
                        ->get();                   
    }

}
