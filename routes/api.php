<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function (){


	//////////////////////////////////////
	//  | Exibindo todas as rotas
	//////////////////////////////////////
	//Route::get('/products', 'ProductController@index');
	//Route::post('/products', 'ProductController@store');
	//Route::put('/products/{product}', 'ProductController@update');
	//Route::get('/products/{product}', 'ProductController@show');
	//Route::delete('/products/{product}', 'ProductController@destroy');
	

	//////////////////////////////////////
	//  | Simplificando a todas as Rotas
	//  | com apenas uma linha.
	//////////////////////////////////////
	// Route::resources('products', 'ProductController');



    // ====================== Category ======================
    Route::get('get-all-category','CategoryController@getAllCategory');
    Route::post('category-save','CategoryController@categorySave');
    Route::post('get-category','CategoryController@getCategory');
    Route::post('category-update','CategoryController@categoryUpdate');
    Route::post('category-delete','CategoryController@categoryDelete');

    Route::post('get-cat-by-subCategory','CategoryController@getCatBySubCategory');
    Route::post('subCategory-save','CategoryController@subCategorySave');
    Route::post('get-subCategory','CategoryController@getSubCategory');
    Route::post('subCategory-update','CategoryController@subCategoryUpdate');
    Route::post('subCategory-delete','CategoryController@subCategoryDelete');
    Route::get('get-subCategoryGridData','CategoryController@subCategoryGridData');
    // ====================== end Category ======================


    // ====================== Product ======================
    Route::post('product-save','ProductController@productSave');
	Route::get('all-product','ProductController@allProduct');
	Route::post('get-product-details','ProductController@getProduct');
	Route::post('product-update','ProductController@productUpdate');
	Route::post('get-product-info','ProductController@getProductInfo');
	


    // ====================== end Product ======================




    Route::resources([
		//'products' => 'ProductController',
		'users' => 'UsersController',
	]);

});
