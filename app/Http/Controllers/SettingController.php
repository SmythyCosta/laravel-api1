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
}