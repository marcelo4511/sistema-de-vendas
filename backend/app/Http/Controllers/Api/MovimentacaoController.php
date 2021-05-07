<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;
use App\Movimentacao;
use App\TipoMovimentacao;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MovimentacaoController extends Controller
{
    public function index() 
    {
        $clients = Movimentacao::select('id','dt_vencimento','comprovante','valor','descricao','user_id','tipo_movimentacao_id')
                                ->with(['user'=> function($query) {
                                    $query->orderBy('id','asc');
                                }])
                                ->with(['tipo_movimentacao'=> function($query) {
                                    $query->orderBy('id','desc');
                                }])
                                ->whereRaw('Date(dt_vencimento) = CURDATE()')
                                ->get();
        return response()->json($clients);
    }

    public function filter(Request $request) 
    {
        $clients = Movimentacao::select('id','dt_vencimento','comprovante','valor','descricao','user_id','tipo_movimentacao_id')
                                ->with(['user'=> function($query) {
                                    $query->orderBy('id','asc');
                                }])
                                ->with(['tipo_movimentacao'=> function($query) {
                                    $query->orderBy('id','desc');
                                }])
                                //->whereDay ('dt_vencimento', '=', date('d'))
                                ->when($request['tipo_movimentacao_id'], function ($query) use ($request) {
                                    $query->whereTipoMovimentacaoId($request['tipo_movimentacao_id']);
                                })
                                ->when($request->de, function ($query) use ($request) {
                                    $query->whereDate('dt_vencimento', '>=', $request->de);
                                })
                                ->when($request->ate, function ($query) use ($request) {
                                    $query->whereDate('dt_vencimento', '<=', $request->ate);
                                })
                                ->when($request->mes, function ($query) use ($request) {
                                    $query->whereMonth('dt_vencimento',$request->mes);
                                })
                                ->orderBy('created_at','asc')
                                ->get();
        return response()->json($clients);
    }

    public function show($id) 
    {
        $client = Movimentacao::find($id);
        return response()->json($client);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if(isset($data['valor'])) {
            $data['valor'] = str_replace(',', '.',$data['valor']);
            $data['valor'] = preg_replace('/[^\d\.]/', '', $data['valor']);
        }
        $client = Movimentacao::create($data);
        return response()->json($client);
    }

    public function update(Request $request,$id) 
    {
        $data = $request->all();
        $client = Movimentacao::find($id);
        $client->update($data);
        return response()->json($client);
    }

    public function destroy($id)
    {
        Movimentacao::where('id', $id)->delete();
        return response()->json(['data' => ['msg' => 'Categoria removida com sucesso']]);
    }
    public function tipo() {
        $tipo = TipoMovimentacao::all();
        return response()->json($tipo);
    }
}
