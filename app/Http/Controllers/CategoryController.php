<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{

    public function getAllCategory(Request $request)
    {
        $all = Category::where('status',1)->get();
        return response()->json(['status'=>200,'cat'=>$all]);
    }

    public function categorySave(Request $request)
    {

        $category = new Category;
        $category->name = $request->input('category');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->save();

        return response()->json(['status'=>200,'mesg'=>'Category Save Success']);
    }

    public function getCategory(Request $request)
    {
        $id = $request->input('id');
        $find = Category::where('id',$id)->first();           
        return response()->json(['status'=>200,'cat'=>$find]); 
    }

    public function categoryUpdate(Request $request)
    {
        $id = $request->input('id');
        $category = Category::find($id);
        $category->name = $request->input('category');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->save();
        
        return response()->json(['status'=>200,'mesg'=>'Category Update Success']);
    }

}
