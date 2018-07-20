<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Category;
use App\SubCategory;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function productSave(Request $request)
    {
        $product = new Product;
        $product->serial_number = $request->input('serial_number');
        $product->category_id = $request->input('category');
        $product->sub_category_id = $request->input('subCategory');
        $product->name = $request->input('name');
        $product->purchase_price = $request->input('purchase_price');
        $product->selling_price = $request->input('selling_price');
        $product->note = $request->input('note');
        $product->status = $request->input('status');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $product->image = $contents;
        }
        $product->save();
        
        return response()->json(['status'=>200,'mesg'=>'Product Save Success']);
    }


    public function allProduct(Request $request)
    {
                                
        $product =  new Product;
        $all = $product->productAll();

        return response()->json(['status'=>200,'product'=>$all]);
    }


    public function getProduct(Request $request)
    {
        $id = $request->input('id');
        $single = DB::table('product')
                        ->leftJoin('category', 'product.category_id', '=', 'category.id')
                        ->leftJoin('sub_category', 'product.sub_category_id', '=', 'sub_category.id')
                        ->leftJoin('damaged_product', 'product.id', '=', 'damaged_product.product_id')
                        ->select('product.id','product.serial_number','product.name','product.category_id','product.sub_category_id','product.purchase_price','product.selling_price','product.stock_quantity','product.note','product.status','product.image','damaged_product.quantity as damagedQuantity','category.name as categoryName','sub_category.name as subCategoryName')
                        ->where('product.id',$id)
                        ->first();
        $data = [
            'id'  => $single->id,
            'serial_number'  => $single->serial_number,
            'name'  => $single->name,
            'category_id'  => $single->category_id,
            'categoryName'  => $single->categoryName,
            'sub_category_id'  => $single->sub_category_id,
            'subCategoryName'  => $single->subCategoryName,
            'purchase_price'  => $single->purchase_price,
            'selling_price'  => $single->selling_price,
            'note'  => $single->note,
            'status'  => $single->status,
            'stock_quantity'  => $single->stock_quantity-$single->damagedQuantity,
            'image'  => base64_encode($single->image),
        ];        
        
        return response()->json(['status'=>200,'product'=>$data]); 
    
    }


    public function productUpdate(Request $request)
    {
        $id = $request->input('id');
        $product = Product::find($id);
        $product->serial_number = $request->input('serial_number');
        $product->category_id = $request->input('category');
        $product->sub_category_id = $request->input('subCategory');
        $product->name = $request->input('name');
        $product->purchase_price = $request->input('purchase_price');
        $product->selling_price = $request->input('selling_price');
        $product->note = $request->input('note');
        $product->status = $request->input('status');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Get the contents of the file
            $contents = $file->openFile()->fread($file->getSize());
            $product->image = $contents;
        
        }
        
        $product->save();
        
        return response()->json(['status'=>200,'mesg'=>'Product Update Success']);
    }


    public function getProductInfo(Request $request)
    {
        $id = $request->input('id');
        $single= Product::select('id','serial_number','name','purchase_price','selling_price','stock_quantity')->where('id',$id)->first();         
    
        return response()->json(['status'=>200,'product'=>$single]); 
    
    }


}
