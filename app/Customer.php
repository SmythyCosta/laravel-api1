<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Customer extends Model
{

    protected $table = 'customer';

    public function allCustomer()
    {
        return DB::table('customer')
                        ->select('id','name','email','phone','address','status')
                        ->orderBy('id','DESC')
                        ->get();
    }

}
