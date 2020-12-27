<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\User;
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


    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::namespace('Api')->group(function(){
        Route::post('/login', 'UserController@login');
        Route::post('/register', 'UserController@register');
        Route::get('/typeuser','UserController@listar');
    });

    Route::namespace('Api')->middleware('auth:sanctum')->group(function(){

        Route::middleware('isAdmin')->group(function() {
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
            
            Route::resource('clients','ClientController');
            Route::get('/users','UserController@index');
            Route::get('/list','UserController@show');
            Route::put('/users','UserController@update');
        
            Route::resource('sales','SaleController');
            Route::delete('/detalhesdelete/{id}','SaleController@deleteDetalhe');
            Route::get('relatorioexcel','SaleController@relatorioexcel');
            Route::get('relatoriopdf','SaleController@relatoriopdf');
            Route::get('relatoriopdfdetalhes/{id}','SaleController@relatoriopdfDetails');
            Route::post('aprovar/{id}','SaleController@aprovacao');
            Route::get('filtrar','SaleController@filter');
            Route::get('graficomensal','SaleController@graficoMensal');
            Route::get('graficoanual','SaleController@graficoAnual');
        });

        Route::middleware(['isCheckout'])->group(function() {
            Route::resource('clients','ClientController');
            Route::resource('sales','SaleController');
            Route::get('filtrar','SaleController@filter');
            Route::get('aprovadas','SaleController@aprovadas');
            Route::get('relatorioexcel','SaleController@relatorioexcel');
            Route::get('relatoriopdf','SaleController@relatoriopdf');
            Route::get('relatoriopdfdetalhes/{id}','SaleController@relatoriopdfDetails');
        });

        Route::middleware(['isSale'])->group(function() {
            Route::get('/products','ProductController@index');
            
            Route::get('/categories','CategoryController@index');

            Route::resource('clients','ClientController');
            Route::resource('sales','SaleController');
            Route::delete('/detalhesdelete/{id}','SaleController@deleteDetalhe');
            Route::get('relatorioexcel','SaleController@relatorioexcel');
            Route::get('relatoriopdf','SaleController@relatoriopdf');
            Route::get('relatoriopdfdetalhes/{id}','SaleController@relatoriopdfDetails');
           
        });
    });
