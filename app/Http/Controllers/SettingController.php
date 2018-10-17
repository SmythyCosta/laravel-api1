<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Setting;
use App\Menu; 
use App\Submenu;

//libs
use Excel;
use JWTAuth;

class SettingController extends Controller
{

    public function getSetting(Request $request)
    {  
        $find = Setting::where('id',1)->first();  
        $data = [
            'company_name' => $find->company_name,
            'address' => $find->address,
            'phone' => $find->phone,
            'email' => $find->email,
            'vat_percentage' => $find->vat_percentage,
            'currency' => $find->currency,
            'image' => base64_encode($find->image)
        ];
         return response()->json(['status'=>200,'setting'=>$data]);
    }

    public function settingUpdate(Request $request)
    {
        $id = 1;
        $setting = Setting::find($id);
        $setting->company_name = $request->input('company_name');
        $setting->address = $request->input('address');
        $setting->phone = $request->input('phone');
        $setting->email = $request->input('email');
        $setting->currency = $request->input('currency');
        $setting->vat_percentage = $request->input('vat_percentage');
        $setting->discount_percentage = $request->input('discount_percentage');
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $setting->image = $contents;
        }
        $setting->save();
        
        return response()->json(['status'=>200,'mesg'=>'Setting Update Success']);
    }
}