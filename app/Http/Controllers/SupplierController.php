<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Models\Supplier;
use App\Models\Setting;


class SupplierController extends Controller
{
    //
    public function getAllSupplier(Request $request)
    {
        $all = Supplier::select('id','company','name','email','phone','status')->orderBy('id','DESC')->get();           
        return response()->json(['status'=>200,'supplier'=>$all]); 
    }



}
