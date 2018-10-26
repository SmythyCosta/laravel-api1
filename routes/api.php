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

// ====================== UserController ======================
Route::post('user-create', 'UserController@userCreate');
Route::post('user-login', 'UserController@login');

// route middleware jwt
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('get-user', 'UserController@getAuthUser');
});

Route::post('user-passwordUpdate', 'UserController@passwordUpdate');
Route::post('user-profileUpdate', 'UserController@profileUpdate');
Route::get('all-user', 'UserController@allUser'); 


// ====================== Category ======================
Route::get('get-all-category','CategoryController@getAllCategory');
Route::post('category-save','CategoryController@categorySave');
Route::post('get-category','CategoryController@getCategory');
Route::post('category-update','CategoryController@categoryUpdate');
Route::post('category-delete','CategoryController@categoryDelete');
Route::get('get-all-category-by-grid','CategoryController@getAllCategoryByGrid');
Route::post('get-cat-by-subCategory','CategoryController@getCatBySubCategory');
Route::post('subCategory-save','CategoryController@subCategorySave');
Route::post('get-subCategory','CategoryController@getSubCategory');
Route::post('subCategory-update','CategoryController@subCategoryUpdate');
Route::post('subCategory-delete','CategoryController@subCategoryDelete');
Route::get('get-subCategoryGridData','CategoryController@subCategoryGridData');


// ====================== Product ======================
Route::post('product-save','ProductController@productSave');
Route::get('all-product','ProductController@allProduct');
Route::post('get-product-details','ProductController@getProduct');
Route::post('product-update','ProductController@productUpdate');
Route::post('get-product-info','ProductController@getProductInfo');
Route::get('product-list-pdf','ProductController@exportpdf');


// ====================== DamagedProduct ======================
Route::post('damaged-product-save','DamagedProductController@productSave');
Route::get('all-damaged-product','DamagedProductController@allDamagedProduct');
Route::post('get-all-product-by-damaged','DamagedProductController@allProduct');
Route::post('get-damaged-product','DamagedProductController@getDamagedProduct');
Route::post('damaged-product-update','DamagedProductController@productUpdate');
Route::get('damaged-product-list-pdf','DamagedProductController@exportpdf');
// ====================== end DamagedProduct ======================


// ====================== Passport ======================
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
