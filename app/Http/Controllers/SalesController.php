<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Product;
use App\Purchase; 
use App\Invoice;
use App\Setting; 
use App\LibPDF\SalesPDF;

//libs
use Excel;

class SalesController extends Controller
{

	public function getCategoryByProduct(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('cat');
        $where = '';
        if ($type==1) {
            $where = " p.category_id={$id}";
        }else{
            $where = " p.sub_category_id={$id}";
        }
        $product = DB::select('SELECT p.id,p.name,p.stock_quantity,d.quantity as damagedQuantity FROM product p left join damaged_product d On p.id=d.product_id where p.status=1 and  '.$where);

        return response()->json(['status'=>200,'product'=>$product]);
    } 

    public function createNewSales(Request $request)
    {
        $product = $request->input('products');
        $sales['invoice_code'] = $request->input('invoiceCode');
        $sales['discount_percentage'] = $request->input('discount');
        $sales['vat_percentage'] = $request->input('vat');
        $sales['sub_total'] = $request->input('subTotal');
        $sales['grand_total'] = $request->input('grandTotal');
        $sales['due'] = $request->input('due');
        $sales['customer_id'] = $request->input('customer');
        $sales['created_at'] = $request->input('date');

        for ($i=0; $i <count($product) ; $i++) {
            $products[] = [
                'id' => $product[$i]['id'],
                'quantity' => $product[$i]['quantity'],
                'selling_price' => $product[$i]['selling_price'],
            ];
            $quantity = Product::find($product[$i]['id']);
            $quantity->stock_quantity = $quantity->stock_quantity - $product[$i]['quantity'];
            $quantity->save();

        }
        
        $sales['invoice_entries']   =   json_encode($products);
        $insert_id = DB::table('invoice')->insertGetId($sales);
        $payment['invoice_id'] = $insert_id;
        $payment['amount'] = $request->input('receivedAmount');
        $payment['type']   =   'income';
        $payment['customer_id'] = $request->input('customer');
        $payment['payment_type'] = $request->input('paymentType');
        $payment['created_at'] = $request->input('date');
        DB::table('payment')->insert($payment);

        return response()->json(['status'=>200,'sales_id'=>$insert_id]);
    }

}