<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sale;
use App\Detail;
use DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = DB::table('sales')
            ->join('clients', 'clients.id', '=', 'sales.client_id')
            //->join('details_sales','details_sales.id', '=','sales.id')
            ->select('sales.dataVenda','sales.total','sales.client_id', 'clients.name')
            ->get();
        return response()->json($sales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $product = new Sale();
        $product->id = $request->input('id');
        $product->dataVenda = date('d/m/Y',strtotime($request->input('dataVenda')));
        $product->client_id = $request->input('client_id');
        $product->total = $request->input('total');
        $product->save();
        //$product->detailsales()->attach($request->detailsales);
        
        
             
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($total)
    {
        Sale::where('total', $total)->delete();

        return response()->json(['data' => ['msg' => 'Categoria removida com sucesso']]);
    }
}
