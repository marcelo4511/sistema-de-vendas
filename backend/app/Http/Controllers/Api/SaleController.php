<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sale;
use App\Detail;
use App\FormaPagamento;
use App\Http\Requests\SaleRequest;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PDF;

class SaleController extends Controller
{
    
    public function index()
    {
        $sales = Sale::select('id','dataVenda','total','user_id','client_id','situacao_id')
                        ->with('clients','details_sales','situacao','user.tipo_usuario','user')
                        ->with(['user'=> function($query) {
                            $query->orderBy('id','asc');
                        }])
                        ->with(['situacao'=> function($query) {
                            $query->orderBy('id','desc');
                        }])
                    ->get();
        return response()->json($sales,200);
    }

    public function filter(){
        try{
            $sales = Sale::with('details_sales','clients','details_sales.products','user')
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

    public function store(SaleRequest $request)
    {
        
        try{
            $data = $request->all();
            $data['situacao_id'] = 1;
            $data['user_id'] = Auth::user()->id;
            $venda = Sale::create($data);

            foreach($data['details_sales'] as $detalhes) {
                Detail::create([
                    'sale_id' => $venda->id,
                    'product_id' => $detalhes['product_id'],
                    'subtotal' => $detalhes['subtotal'],
                    'price' => $detalhes['price'],
                    'estoque' => $detalhes['estoque'],
                    'quantidade' => $detalhes['quantidade'],
                ]);
                if(!empty($detalhes['estoque'])){
                    $produto = Product::select('id','estoque')->find($detalhes['product_id']);
                    $produto->update([
                        'estoque' => $detalhes['estoque'],
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

         //   $this->sendMail($venda->id);
            Log::info('Usuário: '. Auth::user()->name . ' | ' . __METHOD__ . ' | ' . json_encode($request->all()) . $request->ip());
            return response()->json(['success' => 'OK','resultado' => $data],200);
        }catch(Exception $exception){
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }           
    }

    public function show($id)
    {
        try{
            $venda = Sale::with('details_sales.products','formaPagamento','situacao','clients')->find($id);
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
            $data['user_id'] = Auth::user()->id;
            $venda->update($data);
            $venda->details_sales()->delete();
                foreach($data['details_sales'] as $detalhes){
                    Detail::create([
                        'sale_id' => $venda->id,
                        'product_id' => $detalhes['product_id'],
                        'subtotal' => $detalhes['subtotal'],
                        'quantidade' => $detalhes['quantidade'],
                        'price' => $detalhes['price'],
                    ]);
                        
                if(!empty($detalhes['products']['estoque'])){
                    $produto = Product::select('id','estoque')->find($detalhes['product_id']);
                    $produto->update([
                        'estoque' => $detalhes['products']['estoque'],
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
           // $this->sendMail($venda->id);
            Log::info('Usuário: '. Auth::user()->name . ' | ' . __METHOD__ . ' | ' . json_encode($request->except('imagem')) . $request->ip());
            return response()->json(['success' => 'OK','resultado' => $data],200);
        }catch(Exception $exception){
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
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

    public function sendMail($id){
        $venda = Sale::with('clients','details_sales','details_sales.products')->find($id);
        $assunto = Carbon::parse($venda['dataVenda'])->format('d/m/Y');
        $total = number_format($venda['total'],2,',','.');
        $emails = [];
        array_push($emails,'marcelowert@gmail.com');
        $pdf = $this->relatoriopdfDetails($id);
        try {
            Mail::send('teste.clientMail', $venda->toArray(),function ($message) use($total,$assunto,$emails,$pdf) {
                $message->to($emails)->subject('Compra concluida! ' . ' Data da compra ' .$assunto .' total  R$'.$total);
                $message->attachData($pdf, $assunto . '.pdf'); 
            });
            return response()->download(['status' => 'sucesso']);
            Log::info('Usuário: '. Auth::user()->name . ' | ' . __METHOD__ . ' | ' . json_encode($id->all()));
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in email sale " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function relatorioexcel() {
        header('Acess-Control-Allow-Origin:*');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="vendas.xls"');

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
            $venda = Sale::with('clients','details_sales','situacao')
                            ->whereHas('situacao',function($query) {
                                $query->whereSituacaoId(2);
                            })
                            ->get();
            return response()->json($venda,200);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }

    public function statusOne(){
        try{
            $venda = Sale::with('clients','details_sales','situacao','user.tipo_usuario:id,descricao')
                            ->whereHas('situacao',function($query) {
                                $query->whereSituacaoId(1);
                            })
                            ->when(Auth::user()->type_user_id,function($user) {
                                $user->whereHas('user',function($query) {
                                $query->whereUserId(Auth::user()->id);
                                });
                            })
                            ->get();
            return response()->json($venda,200);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }

    public function statusTwo(){
        try{
            $venda = Sale::with('clients','details_sales','situacao','user.tipo_usuario:id,descricao')
                            ->whereHas('situacao',function($query) {
                                $query->whereSituacaoId(2);
                            })
                            ->when(Auth::user()->type_user_id != 1,function($user) {
                                $user->whereHas('user',function($query) {
                                $query->whereUserId(Auth::user()->id);
                                });
                            })
                            ->get();
            return response()->json($venda,200);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }

    public function saleusuario(){
        try{
            $venda = Sale::with('user')
            ->when(Auth::user()->type_user_id,function($user) {
                $user->whereHas('user',function($query) {
                $query->whereUserId(Auth::user()->id);
                });
            })
            ->get();
            return response()->json($venda,200);
        }catch(Exception $e) {
            return response()->json($e->getMessage(),400);
        }
    }

    public function product($id)
    {
        return Product::select('id', 'name','description','price','estoque','status','category_id')
                    ->whereId($id)->with('categories')->get();
    }

    public function deleteDetalhe($id)
    {
        try{
            $produto = Detail::find($id); 
            $produto->delete();
            return response()->json(['data' => ['msg' => 'Venda removida com sucesso'],'status' => 200]);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()],400);
        }
    }
}
