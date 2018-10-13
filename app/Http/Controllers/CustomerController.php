<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Customer;

class CustomerController extends Controller
{

    public function customerSave(Request $request)
    {
        $customer = new Customer;
        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->address = $request->input('address');
        $customer->discount_percentage = $request->input('discount_percentage');
        $customer->status = $request->input('status');
        $customer->gender = $request->input('gender');
        $customer->created_at = date('Y-m-d');
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $customer->image = $contents;
        }

        $customer->save();
        return response()->json(['status'=>200,'mesg'=>'Customer Save Success']); 
    }

    public function allCustomerList()
    {
        $all = DB::table('customer')->select('customer.id', 'customer.name')
                    ->where('status',1)
                    ->orderBy('id','DESC')
                    ->get();

        return response()->json(['status'=>200,'customer'=>$all]);
    }

    public function allCustomer()
    {
        $customer = new Customer();
        $data = $customer->allCustomer();
        return response()->json(['status'=>200,'customer'=>$data]);
    }

    public function getCustomer(Request $request)
    {
        $id = $request->input('id');
        $find = Customer::find($id);
        $data = [
            'id' => $find->id,
            'name' => $find->name,
            'email' => $find->email,
            'phone' => $find->phone,
            'address' => $find->address,
            'discount_percentage' => $find->discount_percentage,
            'status' => $find->status,
            'gender' => $find->gender,
            'image' => base64_encode($find->image)
        ];
        // echo '<img src="data:image/jpeg;base64,'.base64_encode( $find->image ).'"/>';
        return response()->json(['status'=>200,'customer'=>$data]);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::find($id);
        $customer->name = $request->input('name');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        $customer->address = $request->input('address');
        $customer->discount_percentage = $request->input('discount_percentage');
        $customer->status = $request->input('status');
        $customer->gender = $request->input('gender');
        $customer->updated_at = date('Y-m-d');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $customer->image = $contents;
        }
        $customer->save();
        return response()->json(['status'=>200,'mesg'=>'Customer Update Success']); 
    }

    public function getCustomerByDiscount(Request $request)
    {
        $id = $request->input('id');
        $customer = Customer::select('id','discount_percentage')->where('id',$id)->first();
        return response()->json(['status'=>200,'customer'=>$customer]); 
    }

}