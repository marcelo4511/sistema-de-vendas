<?php

namespace App\Http\Controllers\Api;

use App\BillsToPay;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BillsToPayController extends Controller
{
    public function index() 
    {
        $clients = BillsToPay::select('id','dt_vencimento','comprovante','valor','descricao','situacao_id','user_id')
                                    ->with(['user'=> function($query) {
                                        $query->orderBy('id','asc');
                                    }])
                                    ->with(['situacao'=> function($query) {
                                        $query->orderBy('id','desc');
                                    }])
                                    ->get();
        return response()->json($clients);
    }

    public function today() 
    {
        $clients = BillsToPay::select('id','dt_vencimento','comprovante','valor','descricao','situacao_id','user_id')
                                    ->with(['user'=> function($query) {
                                        $query->orderBy('id','asc');
                                    }])
                                    ->with(['situacao'=> function($query) {
                                        $query->orderBy('id','desc');
                                    }])
                                    ->whereRaw('Date(dt_vencimento) = CURDATE()')
                                    ->get();
        return response()->json($clients);
    }

    public function delay() 
    {
        $clients = BillsToPay::select('id','dt_vencimento','comprovante','valor','descricao','situacao_id','user_id')
                                ->with(['user'=> function($query) {
                                    $query->orderBy('id','asc');
                                }])
                                ->with(['situacao'=> function($query) {
                                    //$query->where('id','=', 1);
                                    $query->orderBy('id','desc');
                                }])
                                ->whereRaw('Date(dt_vencimento) < CURDATE()')
                                ->get();
        return response()->json($clients);
    }

    public function show($id) 
    {
        $client = BillsToPay::find($id);
        return response()->json($client);
    }

    public function store(Request $request)
    {
        try{

            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['situacao_id'] = 1;
            
            if($request->hasFile($data['comprovante'])) {
                $base64_image = $data['comprovante'];
                $base = base64_decode($base64_image);  
                $base64 = time().'.' . explode('/', explode(':', substr($base64_image, 0, strpos($base64_image, ';')))[1])[1];
                $destinationPath = public_path() . "/" . $base64;             
                file_put_contents($destinationPath, $base);
                Storage::disk('public')->put($base64, base64_decode($destinationPath));
            }
            $billstopay = BillsToPay::create($data);
            return response()->json($billstopay);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function update(Request $request,$id) 
    {
       try{
           $data = $request->all();
           $billstopay = BillsToPay::find($id);
           if($request->hasFile($data['comprovante'])) {
               $base64_image = $data['comprovante'];
               $base = base64_decode($base64_image);  
               $base64 = time().'.' . explode('/', explode(':', substr($base64_image, 0, strpos($base64_image, ';')))[1])[1];
               $destinationPath = public_path() . "/" . $base64;             
               file_put_contents($destinationPath, $base);
               Storage::disk('public')->put($base64, base64_decode($destinationPath));
            }
            $billstopay->update($data);
            return response()->json($billstopay);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function destroy($id)
    {
        try{
            BillsToPay::where('id', $id)->delete();
            return response()->json(['data' => ['msg' => 'Categoria removida com sucesso']]);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function deleteFoto($id)
    {
        try{
            $product = $this->product->find($id);
            if($product['imagem'] != null) {
                $base64_image = $product['imagem']; 
                $base64 = time().'.' . explode('/', explode(':', substr($base64_image, 0, strpos($base64_image, ';')))[1])[1];  
                $destinationPath = public_path() . "/" . $base64;    
                Storage::disk('public')->delete($base64, base64_decode($destinationPath));
            }
            $product->imagem = null;
            $product->save();
            return response()->json(['success' => true],200);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function aprovacao($id)
    {
        try{
            $venda = BillsToPay::select('id','situacao_id')->find($id);
            $venda['situacao_id'] = 2;
            $venda->update();
            return response()->json($venda,200);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }
}
