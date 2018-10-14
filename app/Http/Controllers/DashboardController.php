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

	public function getChartData(Request $request)
    {
        $sales = DB::select( DB::raw("SELECT sum(amount) as amount,DATE_FORMAT(created_at,'%Y') as date  FROM payment where type ='income' and customer_id IS  not null group by DATE_FORMAT(created_at,'%Y')") );
        $purchase = DB::select( DB::raw("SELECT sum(amount) as amount,DATE_FORMAT(created_at,'%Y') as date  FROM payment where type ='expense' and supplier_id  IS not null group by DATE_FORMAT(created_at,'%Y')") );
        return response()->json(['status'=>200,'purchase'=>$purchase,'sales'=>$sales]);
    }

	public function latestProduct(Request $request)
	{
		$product = DB::select('SELECT p.id,p.name,p.stock_quantity,p.purchase_price,d.quantity as damagedQuantity from product p left join damaged_product d on p.id=d.product_id where p.status=1 order by p.id desc limit 5');
		return response()->json(['status'=>200,'product'=>$product]);
	}

}