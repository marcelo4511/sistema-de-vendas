<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Sale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function graficoMensal()
    {
        try{

            DB::statement("SET lc_time_names = 'pt_PT'");
            
            $sales = Sale::whereHas('situacao',function($query) {
                $query->whereSituacaoId(2);
            })
            
            ->selectRaw('SUM(total) as teste,monthname (dataVenda) as mes')
            ->groupBy('mes')
            ->get();

            $arr['categories'] = array();
            $arr['series'] = [];

            foreach($sales as $value){
                array_push($arr['categories'],$value->mes);
                array_push($arr['series'],$value->teste);
            }
            return response()->json($arr,200);
        }catch(Exception $e) {
            return response()->json($e->getMessage(),400);
        }
    }

    public function graficoComissaoVendedores()
    {
        $sales = Sale::join('users', 'users.id', '=', 'sales.user_id')
                        ->selectRaw('Sum(round(total * 5/100)) as comissao,users.name as name')
                        ->groupBy('name')
                        ->get();

                        $arr['categories'] = array();
                        $arr['series'] = [];

                        foreach($sales as $sale) {
                            array_push($arr['categories'], $sale->name);
                            array_push($arr['series'],$sale->comissao);
                        }
                        
                        return $arr;
        return response()->json( $sales,200);
    }

    public function GraficoQuantidadeTotalVendedor()
    {
        $sales = Sale::join('users', 'users.id', '=', 'sales.user_id')
                        ->selectRaw('count(total) as qtd ,SUM(total) as total,users.name as name')
                        ->groupBy('name')
                        ->get();

                        $arr['categories'] = array();
                        $arr['series'] = [];
                        $arr['seriesx'] = [];

                        foreach($sales as $value){
                            array_push($arr['categories'],$value->name);
                            array_push($arr['series'], $value->total);
                            array_push($arr['seriesx'], $value->qtd);
                        }
        return response()->json( $arr,200);
    }

    public function GraficoClienteCompra()
    {
        $compras = Sale::join('clients as clients', 'clients.id', '=', 'sales.client_id')
                        ->selectRaw('SUM(total) as total,clients.name as name')
                        ->groupby('name')
                        ->get();

        $arr['categories'] = [];
        $arr['series'] = [];

        foreach($compras as $value) {
            array_push($arr['categories'],$value->name);
            array_push($arr['series'],$value->total);
        }

        return $arr;
    }
    public function GraficoQuantidadeProdutoVendido() 
    {
        $sales = Sale::join('details_sales', 'details_sales.id', '=', 'details_sales.sale_id')
                        ->join('details_sales as detalhe', 'detalhe.product_id', '=', 'detalhe.product_id')
                        ->join('products','products.id','=','detalhe.product_id')
                        ->selectRaw('SUM(round(details_sales.quantidade)) as venda,products.name as name')
                        ->groupBy('name')
                        ->get();

                        $arr['categories'] = array();
                        $arr['series'] = [];

                        foreach($sales as $sale) {
                            array_push($arr['categories'], $sale->name);
                            array_push($arr['series'],$sale->venda);
                        }
                       return $arr;
    }
    public function graficoAnual()
    {
        $sales = Sale::whereHas('situacao',function($query) {
                            $query->whereSituacaoId(2);
                        })
                        ->selectRaw('SUM(total) as total,year (dataVenda) as ano')
                        ->groupBy('ano')
                        ->get();

                        $arr['categories'] = array();
                        $arr['series'] = [];

                        foreach($sales as $value){
                            array_push($arr['categories'],$value->ano);
                            array_push($arr['series'],$value->total);
                        }

                      return $arr;
    }
}