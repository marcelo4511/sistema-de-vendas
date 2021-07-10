<?php

namespace App\Http\Controllers\Api;

use App\Compra;
use App\Http\Controllers\Controller;
use App\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompraController extends Controller
{
    
    public function index()
    {
        try{
            $compras = Compra::select('id','data_compra','total','fornecedor_id','situacao_id','user_id')
                                ->with('fornecedor:id,name')
                                ->with('user:id,type_user_id')
                                ->with('user.tipo_usuario:id,descricao')
                                ->with('situacao:id,descricao')
                                ->get();
            return response()->json($compras,200);
        }catch(Exception $exception) {
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function store(Request $request)
    {
        try{
            $data = $request->all();
            $data['situacao_id'] = 1;
            $data['total'] = 1;
            $data['user_id'] = Auth::user()->id;
            $compra = Compra::create($data);
            
            if(isset($data['products']) && count($data['products'])){
                $compra_id = Compra::find($compra->id);
                
                foreach($data['products'] as $produto){
                    Product::updateOrCreate(
                        ['id' =>  $produto['id']],
                        [
                        'price' => $produto['price'],
                        'estoque' => $produto['estoque']
                        ]
                    );
                    $produto_id = $produto['id'];
                    $compra_id->produtos()->attach([$produto_id],['subtotal' => $produto['pivot']['subtotal']]);
                }
            }
            Log::info('Usuário: '. Auth::user()->name . ' | ' . __METHOD__ . ' | ' . json_encode($request->all()) . $request->ip());
            return response()->json(['success' => 'OK','resultado' => $data],200);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function show($id)
    {
    
        $compra = Compra::select('id','data_compra','total','fornecedor_id','situacao_id','user_id')
                        ->with('fornecedor:id,name')
                        ->with('user:id,type_user_id')
                        ->with('user.tipo_usuario:id,descricao')
                        ->with('situacao:id,descricao')
                        ->with('produtos:id,price,estoque,name')
                        ->findOrFail($id);

        return response()->json($compra,200);
    }

    public function update(Request $request, $id)
    {
        try{
            $data = $request->all();
            $compra = Compra::find($id);
            $data['situacao_id'] = 1;
            $data['user_id'] = Auth::user()->id;
            $compra->update($data);
            
            if(isset($data['produtos']) && count($data['produtos'])){
                $sync = [];
                foreach($data['produtos'] as $produto){
                    Product::updateOrCreate(
                        ['id' =>  $produto['id']],
                        [
                        'price' => $produto['price'],
                        'estoque' => $produto['estoque']
                        ]
                    );
                    $produto_id = $produto['id'];
                    $subtotal = $produto['pivot']['subtotal'];
                    array_push($sync,['product_id' => $produto_id,'subtotal' => $subtotal]);    
                }
                $compra->produtos()->sync($sync);
            }
            Log::info('Usuário: '. Auth::user()->name . ' | ' . __METHOD__ . ' | ' . json_encode($request->all()) . $request->ip());
            return response()->json(['success' => 'OK','resultado' => $data],200);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }
    public function destroy($id)
    {
        try{
            Compra::find($id)->delete();  
            return response()->json(['data' => ['msg' => 'Compra removida com sucesso'],'status' => 200]);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function deleteProduct(Request $request)
    {
        try{
            Compra::find($request->compra_id)->produtos()->detach($request->id);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }
}
