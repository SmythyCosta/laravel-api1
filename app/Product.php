<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    
    protected $table = 'product';

    //protected $fillable = ['serial_number','category_id', 'sub_category_id', 'name', 'purchase_price', 'selling_price', 'note', 'stock_quantity', 'status'];

    public function productAll()
    {
        return DB::table('product')
            ->leftJoin('category', 'product.category_id', '=', 'category.id')
            ->leftJoin('damaged_product', 'product.id', '=', 'damaged_product.product_id')
            ->select('product.id','product.serial_number','product.name','product.purchase_price','product.selling_price','product.stock_quantity','product.status','damaged_product.quantity as damagedQuantity','category.name as categoryName')
            ->orderBy('product.id', 'desc')
            ->get();
    }
}
