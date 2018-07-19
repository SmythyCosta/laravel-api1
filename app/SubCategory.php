<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

    protected $table = 'sub_category';
    protected $fillable = ['name','description', 'status', 'category_id'];
    public $timestamps = false;

}
