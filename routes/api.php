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


	Route::resources([
		'products' => 'ProductController',
		'users' => 'UsersController.php',
	]);

});
