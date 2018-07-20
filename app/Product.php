<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $table = 'product';

    protected $fillable = ['serial_number','category_id', 'sub_category_id', 'name', 'purchase_price', 'selling_price', 'note', 'stock_quantity', 'image', 'status'];

}
