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

    public function getSupplier(Request $request)
    {
        $id = $request->input('id');
        $supplier = Supplier::find($id); 
        $data = [
            'id' => $supplier->id,
            'company' => $supplier->company,
            'name' => $supplier->name,
            'email' => $supplier->email,
            'phone' => $supplier->phone,
            'status' => $supplier->status,
            'image' => base64_encode($supplier->image)
        ];          
        return response()->json(['status'=>200,'supplier'=>$data]); 
    }

}
