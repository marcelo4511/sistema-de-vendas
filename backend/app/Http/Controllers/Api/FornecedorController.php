<?php
namespace App\Http\Controllers\Api;

use App\Fornecedor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    public function index() 
    {
        $fornecedores = Fornecedor::all();
        return response()->json($fornecedores);
    }

    public function show($id) 
    {
        $forcededor = Fornecedor::find($id);
        return response()->json($forcededor);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $forcededor = Fornecedor::create($data);
        return response()->json($forcededor);
    }

    public function update(Request $request,$id) 
    {
        $data = $request->all();
        $forcededor = Fornecedor::find($id);
        $forcededor->update($data);
        return response()->json($forcededor);
    }

    public function destroy($id)
    {

        Fornecedor::where('id', $id)->delete();

        return response()->json(['data' => ['msg' => 'Categoria removida com sucesso']]);
   
    }
}
