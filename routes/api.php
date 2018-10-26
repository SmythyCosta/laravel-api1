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

// ====================== User ======================
Route::post('user-create', 'UserController@userCreate');
Route::post('user-login', 'UserController@login');
// route middleware jwt
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::post('get-user', 'UserController@getAuthUser');
});
Route::post('user-passwordUpdate', 'UserController@passwordUpdate');
Route::post('user-profileUpdate', 'UserController@profileUpdate');
Route::get('all-user', 'UserController@allUser'); 
Route::post('get-user-data', 'UserController@getUserData'); 
Route::post('user-update', 'UserController@userUpdate');
Route::post('user-delete', 'UserController@userDelete');
Route::get('user-list-pdf','UserController@exportpdf');
Route::get('user-list-excel','UserController@downloadExcel'); 
Route::post('user-assing-role-data','UserController@getUserAssingRoleData'); 
Route::get('user-role-data','UserController@getAllMenu'); 
Route::post('add-user-role','UserController@addUserRole');


// ====================== Dashboard ======================
Route::get('get-all-total-count','DashboardController@getAllTotalCount');
Route::get('get-all-dashboard-data','DashboardController@getAllDashboardData');
Route::get('get-chart-data','DashboardController@getChartData');
Route::get('get-latestOrder','DashboardController@latestOrder');
Route::get('get-latestProduct','DashboardController@latestProduct');


// ====================== Customer ======================
Route::post('customer-save','CustomerControllers@customerSave');
Route::get('all-customer', 'CustomerControllers@allCustomer');
Route::post('get-customer','CustomerControllers@getCustomer');
Route::post('customer-update','CustomerControllers@update');
Route::post('get-customer-by-discount','CustomerControllers@getCustomerByDiscount');
Route::post('get-customer-info','CustomerControllers@getCustomerInfo');
Route::get('customer-list-pdf','CustomerControllers@exportpdf');
Route::get('customer-list-excel','CustomerControllers@downloadExcel');
Route::get('all-customer-list', 'CustomerControllers@allCustomerList');



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
