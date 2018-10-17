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

    public function getMenu(Request $request)
    {
        $token = explode(" ", $request->header('Authorization'));
        if(!empty($token[1])){

            $user = JWTAuth::toUser($token[1]);
            // print_r($user['id']);die();
            if($user['type'] !=1){

                $roleData = DB::table('user_role')->select('menu_id','sub_menu_id')->where('user_id',$user['id'])->first();

                $all = DB::select(DB::raw('SELECT * FROM menu where id in ('.$roleData->menu_id.') ORDER BY priority ASC'));
                $menu = [];

                foreach ($all as $key => $value) {
                    $submenu = DB::select(DB::raw('SELECT * FROM submenu where status=1 AND menu_id='.$value->id.' AND id in ('.$roleData->sub_menu_id.') ORDER BY priority ASC'));
                    $menu[] = [
                        'id' =>$value->id,
                        'name' =>$value->name,
                        'icon' =>$value->icon,
                        'route' =>$value->route,
                        'type' =>$value->type,
                        'children' =>(($value->type==1) ? $submenu :''),
                    ];
                }
            }else{

                $all = DB::select(DB::raw('SELECT * FROM menu ORDER BY priority ASC'));
                $menu = [];

                foreach ($all as $key => $value) {
                    $submenu = DB::select(DB::raw('SELECT * FROM submenu where status=1 AND menu_id='.$value->id.' ORDER BY priority ASC'));
                    $menu[] = [
                        'id' =>$value->id,
                        'name' =>$value->name,
                        'icon' =>$value->icon,
                        'route' =>$value->route,
                        'type' =>$value->type,
                        'children' =>(($value->type==1) ? $submenu :''),
                    ];
                }
            }
        }else{
            $menu = '';
        }

        return response()->json(['status'=>200,'data'=>$menu]);
    }

}