<?php

namespace App\Http\Controllers\Api;

use App\BillsToReceive;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use Exception;
use Illuminate\Support\Facades\Auth;

class BillsToReceiveController extends Controller
{
    public function index() 
    {
        $clients = BillsToReceive::select('id','dt_vencimento','comprovante','valor','descricao','situacao_id','user_id')
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
        $client = BillsToReceive::findOrFail($id);
        return response()->json($client);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['situacao_id'] = 1;
            if(isset($data['valor'])) {
                $data['valor'] = str_replace(',', '.',$data['valor']);
                $data['valor'] = preg_replace('/[^\d\.]/', '', $data['valor']);
            }
            $receber = BillsToReceive::create($data);
            return response()->json(['receber' => $receber, 'status' => true]);
        }catch(Exception $e) {
            return response()->json(['error' => $e->getMessage(),'status' => false]);
        }
    }

    public function update(Request $request,$id) 
    {
        $data = $request->all();
        $receber = BillsToReceive::find($id);
        $receber->update($data);
        return response()->json($receber);
    }

    public function destroy($id)
    {
        BillsToReceive::where('id', $id)->delete();
        return response()->json(['data' => ['msg' => 'Categoria removida com sucesso']]);
    }

    public function aprovacao($id)
    {
        try{
            $venda = BillsToReceive::select('id','situacao_id')->find($id);
            $venda['situacao_id'] = 2;
            $venda->update();
            return response()->json($venda,200);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }
}
