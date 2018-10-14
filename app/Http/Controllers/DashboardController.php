<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Customer;
use App\Setting;

class DashboardController extends Controller
{

	public function getAllTotalCount(Request $request)
	{
		$product = DB::table('product')->select(DB::raw('count(id) as count'))->first();
		$damaged_product = DB::table('damaged_product')->select(DB::raw('sum(id) as count'))->first();
		$customer = DB::table('customer')->select(DB::raw('count(id) as count'))->first();
		$user = DB::table('users')->select(DB::raw('count(id) as count'))->first();
		$supplier = DB::table('supplier')->select(DB::raw('count(id) as count'))->first();
		$category = DB::table('category')->select(DB::raw('count(id) as count'))->first();
		
		return response()->json(['status'=>200,'product'=>$product,'damaged_product'=>$damaged_product,'customer'=>$customer,'user'=>$user,'supplier'=>$supplier,'category'=>$category]);
	}
	
}