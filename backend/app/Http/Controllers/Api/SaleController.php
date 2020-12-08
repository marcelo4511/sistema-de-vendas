<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sale;
use App\Detail;
use App\FormaPagamento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use PDF;

class SaleController extends Controller
{
    
    public function index()
    {
        $sales = DB::table('sales')
            ->join('clients', 'clients.id', '=', 'sales.client_id')
            ->select('sales.dataVenda','sales.total','sales.client_id', 'clients.name')
            ->get();
        return response()->json($sales);
    }

    public function store(Request $request)
    {
        
        try{
            $data = $request->all();
            $venda = Sale::create($data);
            
           if(!empty($data['details_sales']) && $data['details_sales'] > 0){

               foreach($data['details_sales'] as $detalhes) {
                    Detail::create([
                       'sale_id' => $venda->id,
                       'product_id' => $detalhes['product_id'],
                       'subtotal' => $detalhes['subtotal'],
                       'descount' => $detalhes['descount'],
                       'price' => $detalhes['price'],
                    ]);
                }
            }

            if($data['formapagamento']) {
                FormaPagamento::create([
                    'sale_id' => $venda->id,
                    'tipo_forma_pagamento' => $data['formapagamento']['tipo_forma_pagamento'],
                    'parcelas' => $data['formapagamento']['parcelas'],
                    'entrada' => $data['formapagamento']['entrada']
                ]);
            }

            $validate = Validator::make($request->all(),[
                'details_sales.*.sale_id' => 'required',
                'details_sales.*.product_id' => 'required',
                'details_sales.*.subtotal' => 'required',
                'details_sales.*.descount' => 'required',
                'details_sales.*.price' => 'required',
                ]);
    
                if($validate->fails()){
                    response()->json(['errors' => $validate->errors()]);
                }
                
                $this->sendMail($venda->id);
                return response()->json(['success' => 200]);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage(), 'status' => true]);
        }           
    }

    public function show($id)
    {
        try{
            $venda = Sale::with('details_sales','formaPagamento')->find($id);
            return response()->json($venda,200);

        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            
            $data = $request->all();
            $venda = Sale::findOrFail($id);
            $venda->update($data);
            
            if($data['details_sales'] > 0){
                foreach($request->details_sales as $detalhes){
                    $abertaClausulaProposta = Detail::find($detalhes['id']);
                    $abertaClausulaProposta->update([
                        'sale_id' => $venda->id,
                        'product_id' => $detalhes['product_id'],
                        'subtotal' => $detalhes['subtotal'],
                        'descount' => $detalhes['descount'],
                        'price' => $detalhes['price'],
                    ]);
                }
            }

            //if($data['formapagamento'] == 0) {
                //$forma = FormaPagamento::find('id');
             //   FormaPagamento::create([
             //       'sale_id' => $venda->id,
             //       'tipo_forma_pagamento' => $data['tipo_forma_pagamento'],
             //       'parcelas' => $data['parcelas'],
             //       'entrada' => $data['entrada']
             //   ]);
           // }
            
           $this->sendMail($request->id);
           return response()->json(['success' => 200, 'status' => 'OK']);
        }catch(Exception $e) {
            return response()->json(['err' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try{
            Sale::whereId('id', $id)->delete();  
            return response()->json(['data' => ['msg' => 'Venda removida com sucesso'],'status' => 200]);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()],400);
        }
    }

    public function deleteDetalhe($id)
    {
        try{
            Detail::find($id)->delete();  
            return response()->json(['data' => ['msg' => 'Venda removida com sucesso'],'status' => 200]);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()],400);
        }
    }

    public function sendMail($id){
        $venda = Sale::with('clients','details_sales','details_sales.products')->find($id);
        $assunto = Carbon::parse($venda['dataVenda'])->format('d/m/Y');
        $total = number_format($venda['total'],2,',','.') ;
        $emails = [];
        array_push($emails,'marcelowert@gmail.com','brunacristinadozzo@hotmail.com');
        try {
            Mail::send('teste.clientMail', $venda->toArray(),function ($message) use($total,$venda,$assunto,$emails) {
                $message->to($emails)->subject('Compra concluida! ' . ' Data da compra ' .$assunto .' total  R$'.$total);
            });
            return response()->json(['status' => 'sucesso']);
        }catch(Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function relatorioexcel() {
        header('Acess-Control-Allow-Origin:*');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="file.xls"');

        $vendas = Sale::select('dataVenda','client_id','total')
                        ->with('clients',
                                'details_sales',
                                'details_sales.products')
                        ->get();
        return view('excel.relatoriovendas', compact('vendas'))->render();
    }

    public function relatoriopdf()
    {   
        $vendas = Sale::all();
        $pdf = PDF::loadView('vendas.pdf.orcamento', compact('vendas'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream("venda.pdf");
    }
}
