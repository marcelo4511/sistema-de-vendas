<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
            //produtos
            Route::get('/products','ProductController@index');
            Route::get('/products/{id}','ProductController@show');
            Route::post('/products','ProductController@save');
            Route::put('/products/{id}','ProductController@update');
            Route::delete('/products/{id}','ProductController@delete');
            Route::delete('/productdeletefoto/{id}','ProductController@deleteFoto');
            Route::post('/filtro', 'ProductController@filtro');
            
            //categories
            Route::get('/categories','CategoryController@index');
            Route::get('/categories/{id}','CategoryController@show');
            Route::post('/categories','CategoryController@save');
            Route::put('/categories/{id}','CategoryController@update');
            Route::delete('/categories/{id}','CategoryController@delete');
            
            //clientes
            Route::resource('clients','ClientController');
            Route::get('/users','UserController@index');
            Route::get('/list','UserController@show');
            Route::put('/users','UserController@update');
            Route::get('/search','UserController@search');
            
            //fornecedores
            Route::resource('fornecedores','FornecedorController');

            Route::resource('billstopay','BillsToPayController');
            Route::post('billstopay/aprovar/{id}','BillsToPayController@aprovacao');
            Route::get('delay','BillsToPayController@delay');
            Route::get('today','BillsToPayController@today');

            Route::resource('billstoreceive','BillsToReceiveController');
            Route::post('billstoreceive/aprovar/{id}','BillsToReceiveController@aprovacao');

            //movimentacoes
            Route::post('movimentacao','MovimentacaoController@store');
            Route::get('tipo','MovimentacaoController@tipo');
            Route::post('filtromovi','MovimentacaoController@filter');
            Route::get('movimentacao/lista','MovimentacaoController@index');
            
            //vendas
            Route::resource('sales','SaleController');
            Route::get('relatorioexcel','SaleController@relatorioexcel');
            Route::get('detalhesdelete/{id}','SaleController@deleteDetalhe');
            Route::get('relatoriopdf','SaleController@relatoriopdf');
            Route::get('relatoriopdfdetalhes/{id}','SaleController@relatoriopdfDetails');
            Route::post('aprovar/{id}','SaleController@aprovacao');
            Route::get('filtrar','SaleController@filter');
            Route::get('product/{id}','SaleController@product');

            //compras
            Route::get('/compras','CompraController@index');
            Route::post('/compras','CompraController@store');
            Route::get('/compras/{id}','CompraController@show');
            Route::put('/compras/{id}','CompraController@update');
            Route::delete('/compras/{id}','CompraController@destroy');
            Route::post('/comprasprodutos','CompraController@deleteProduct');
            
            //gráficos
            Route::post('bi/grafico/mensal','DashboardController@graficoMensal');
            Route::post('bi/grafico/anual','DashboardController@graficoAnual');
            Route::post('bi/grafico/comissao/vendedor','DashboardController@graficoComissaoVendedores');
            Route::post('bi/grafico/quantidade/total','DashboardController@GraficoQuantidadeTotalVendedor');
            Route::post('bi/grafico/clientes/compra','DashboardController@GraficoClienteCompra');   
            Route::post('bi/grafico/quantidade/produtos/vendidos','DashboardController@GraficoQuantidadeProdutoVendido');

            //getters
            Route::get('get/categories','getController@categories');
            Route::get('get/products','getController@products');
            Route::get('get/clients','getController@clients');
        });

        //caixa
        Route::middleware(['isCheckout'])->group(function() {
            Route::resource('clients','ClientController');
            Route::resource('sales','SaleController');
            Route::get('filtrar','SaleController@filter');
            Route::get('aprovadas','SaleController@aprovadas');
            Route::get('relatorioexcel','SaleController@relatorioexcel');
            Route::get('relatoriopdf','SaleController@relatoriopdf');
            Route::get('relatoriopdfdetalhes/{id}','SaleController@relatoriopdfDetails');
        });

        //vendedor
        Route::middleware(['isSale'])->group(function() {
            Route::get('saleaprovadas','SaleController@statusTwo');
            Route::get('saleusuario','SaleController@saleusuario');
            Route::get('/usuario','UserController@show');
            Route::get('/products','ProductController@index');
            Route::get('/products/{id}','ProductController@show');
            Route::post('/products','ProductController@save');
            Route::put('/products/{id}','ProductController@update');
            Route::delete('/products/{id}','ProductController@delete');
            Route::get('product/{id}','SaleController@product');
            Route::post('/filtro', 'ProductController@filtro');
            Route::get('/categories','CategoryController@index');
            Route::resource('clients','ClientController');
            Route::resource('sales','SaleController');
            Route::get('salesemandamento','SaleController@statusOne');
            Route::delete('/detalhesdelete/{id}','SaleController@deleteDetalhe');
            Route::get('relatorioexcel','SaleController@relatorioexcel');
            Route::get('relatoriopdf','SaleController@relatoriopdf');
            Route::get('relatoriopdfdetalhes/{id}','SaleController@relatoriopdfDetails');
        });
    });

