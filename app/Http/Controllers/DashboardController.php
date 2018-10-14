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

	public function getAllDashboardData(Request $request)
	{
		$endDate = date("Y-m-31").' 00:00:00';
		$startDate = date('Y-m-01').' 00:00:00';
	
		$invoice = DB::table('invoice')->select(DB::raw('sum(grand_total) as total'))->whereBetween(DB::raw('date(created_at)'), [$startDate, $endDate])->first();
		$payment = DB::table('payment')->select(DB::raw('sum(amount) as total'))->where('type','income')->whereBetween(DB::raw('date(created_at)'), [$startDate, $endDate])->first();
		$expense = DB::table('payment')->select(DB::raw('sum(amount) as total'))->where('type','expense')->whereBetween(DB::raw('date(created_at)'), [$startDate, $endDate])->first();

		return response()->json(['status'=>200,'sales'=>$invoice,'payment'=>$payment,'expense'=>$expense]);
	}

}