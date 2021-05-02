<?php

namespace App\Http\Controllers\Api;

use App\BillsToPay;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use Exception;
use Illuminate\Support\Facades\Auth;

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

    public function show($id) 
    {
        $client = BillsToPay::find($id);
        return response()->json($client);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['situacao_id'] = 1;
        if(isset($data['valor'])) {
            $data['valor'] = str_replace(',', '.',$data['valor']);
            $data['valor'] = preg_replace('/[^\d\.]/', '', $data['valor']);
        }
        $client = BillsToPay::create($data);
        return response()->json($client);
    }

    public function update(Request $request,$id) 
    {
        $data = $request->all();
        $client = BillsToPay::find($id);
        $client->update($data);
        return response()->json($client);
    }

    public function destroy($id)
    {
        BillsToPay::where('id', $id)->delete();
        return response()->json(['data' => ['msg' => 'Categoria removida com sucesso']]);
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
