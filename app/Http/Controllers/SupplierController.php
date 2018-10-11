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

    public function supplierSave(Request $request)
    {
        $supplier = new Supplier;
        $supplier->name = $request->input('name');
        $supplier->company = $request->input('company');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('phone');
        $supplier->status = $request->input('status');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $supplier->image = $contents;
        }
        
        $supplier->save();
        return response()->json(['status'=>200,'mesg'=>'Supplier Save Success']); 
    }

    public function supplierUpdate(Request $request)
    {
        $id = $request->input('id');
        $supplier = Supplier::find($id);
        $supplier->name = $request->input('name');
        $supplier->company = $request->input('company');
        $supplier->email = $request->input('email');
        $supplier->phone = $request->input('phone');
        $supplier->status = $request->input('status');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $supplier->image = $contents;
        }
        $supplier->save();
        return response()->json(['status'=>200,'mesg'=>'Supplier Update Success']); 
    }


}
