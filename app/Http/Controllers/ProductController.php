<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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


}
