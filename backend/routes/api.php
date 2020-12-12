<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Products Route
Route::namespace('Api')->group(function(){
    Route::get('/products','ProductController@index');
    Route::get('/products/{id}','ProductController@show');
    Route::post('/products','ProductController@save');
    Route::put('/products/{id}','ProductController@update');
    Route::delete('/products/{id}','ProductController@delete');

    Route::get('/categories','CategoryController@index');
    Route::get('/categories/{id}','CategoryController@show');
    Route::post('/categories','CategoryController@save');
    Route::put('/categories/{id}','CategoryController@update');
    Route::delete('/categories/{id}','CategoryController@delete');

    Route::resource('users','UserController');

    Route::resource('clients','ClientController');

    Route::resource('sales','SaleController');
    Route::delete('/detalhesdelete/{id}','SaleController@deleteDetalhe');
    Route::get('relatorioexcel','SaleController@relatorioexcel');
    Route::get('relatoriopdf','SaleController@relatoriopdf');
    Route::get('relatoriopdfdetalhes/{id}','SaleController@relatoriopdfDetails');
    Route::post('aprovar/{id}','SaleController@aprovacao');
    Route::get('filtrar','SaleController@filter');
});
