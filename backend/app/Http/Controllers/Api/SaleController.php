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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\User;
use PDF;

class SaleController extends Controller
{
    
    public function index()
    {
        $sales = DB::table('sales')
            ->join('clients', 'clients.id', '=', 'sales.client_id')
            ->join('situacao', 'situacao.id', '=', 'sales.situacao_id')
            ->select('sales.id','sales.dataVenda','sales.total','sales.client_id','clients.name','situacao.descricao','sales.situacao_id')
            ->get();
        return response()->json($sales);
    }

    public function filter(){
        try{
            $sales = Sale::with('details_sales','clients','details_sales.products')
            ->whereHas('situacao',function($query) {
                $query->whereSituacaoId(2);
            })
            ->whereMonth('dataVenda', Carbon::now()->month)
            ->whereHas('details_sales',function($query) {
                $query->where('subtotal','>=',100);
            })
            ->with(['details_sales'],function($query) {
                $query->orderBy('subtotal','desc');
            })
            ->orderBy('created_at','desc')
            ->get();
            return response()->json($sales,200);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()],400);
        }
    }

    public function graficoMensal()
    {
        DB::statement("SET lc_time_names = 'pt_PT'");
        
        $sales = Sale::whereHas('situacao',function($query) {
                            $query->whereSituacaoId(2);
                        })
                        ->selectRaw('SUM(total) as teste,monthname (dataVenda) as mes')
                        ->groupBy('mes')
                        ->get();
        return response()->json($sales,200);
    }

    public function graficoAnual()
    {
        $sales = Sale::whereHas('situacao',function($query) {
                            $query->whereSituacaoId(2);
                        })
                        ->selectRaw('SUM(total) as total,year (dataVenda) as ano')
                        ->groupBy('ano')
                        ->get();
        return response()->json( $sales,200);
    }

    public function store(Request $request)
    {
        
        try{
            $data = $request->all();
            //$data['dataVenda'] = Carbon::parse($data['dataVenda'])->format('d/m/Y');
            $data['situacao_id'] = 1;
            //$data['user_id'] = Auth::check() && Auth::user()->id;
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
                
                //$this->sendMail($venda->id);
                return response()->json(['success' => 200]);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage(), 'status' => true]);
        }           
    }

    public function show($id)
    {
        try{
            $venda = Sale::with('details_sales','formaPagamento','situacao','clients')->find($id);
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
            $data['situacao_id'] = 1;
           // $data['dataVenda'] = Carbon::parse($data['dataVenda'])->format('d/m/Y');
            $venda->update($data);
            
            if($data['details_sales'] > 0){
                foreach($request->details_sales as $detalhes){
                    $detalhesupdate = Detail::find($detalhes['id']);
                    $detalhesupdate->update([
                        'sale_id' => $venda->id,
                        'product_id' => $detalhes['product_id'],
                        'subtotal' => $detalhes['subtotal'],
                        'descount' => $detalhes['descount'],
                        'price' => $detalhes['price'],
                    ]);
                }
            }

            if($data['forma_pagamento']) {
                $forma = FormaPagamento::find($data['forma_pagamento']['id']);
                $forma->update([
                    'sale_id' => $venda->id,
                    'tipo_forma_pagamento' => $data['forma_pagamento']['tipo_forma_pagamento'],
                    'parcelas' => $data['forma_pagamento']['parcelas'],
                    'entrada' => $data['forma_pagamento']['entrada']
                ]);
            }
            
           //$this->sendMail($request->id);
           return response()->json(['success' => 200, 'status' => 'OK']);
        }catch(Exception $e) {
            return response()->json(['err' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try{
            Sale::find($id)->delete();  
            return response()->json(['data' => ['msg' => 'delhe da venda removido com sucesso'],'status' => 200]);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()],400);
        }
    }

    public function deleteDetalhe($id)
    {
        try{
            Detail::with('sale')->find($id)->delete();  
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
        array_push($emails,'marcelowert@gmail.com');
        $pdf = $this->relatorioexcel();
        try {
            Mail::send('teste.clientMail', $venda->toArray(),function ($message) use($total,$assunto,$emails,$pdf) {
                $message->to($emails)->subject('Compra concluida! ' . ' Data da compra ' .$assunto .' total  R$'.$total);
                $message->attachData($pdf, $assunto . '.pdf');
            });
            return response()->download(['status' => 'sucesso']);
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

    public function relatoriopdfDetails($id)
    {   
        $vendas = Sale::with('details_sales','details_sales.products','clients')->find($id);
        $pdf = PDF::loadView('vendas.pdf.detalhesprodutos', compact('vendas'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream("detalhesprodutos.pdf");
    }

    public function aprovacao($id)
    {
        try{
            $venda = Sale::select('id','situacao_id')->find($id);
            $venda['situacao_id'] = 2;
            $venda->update();
            return response()->json($venda,200);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }

    public function aprovadas()
    {
        try{
            $venda = Sale::with('clients','details_sales')->get()
                            ->whereHas('situacao',function($query) {
                                $query->whereSituacaoId(2);
                            })
                            ->get();
            return response()->json($venda,200);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }
}
