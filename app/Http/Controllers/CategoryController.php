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

}
