<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Client;

class ClientController extends Controller
{
    public function index() 
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    public function show($id) 
    {
        $client = Client::find($id);
        return response()->json($client);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $client = Client::create($data);
        return response()->json($client);
    }

    public function update(Request $request,$id) 
    {
        $data = $request->all();
        $client = Client::find($id);
        $client->update($data);
        return response()->json($client);
    }

    public function destroy($id)
    {

        Client::where('id', $id)->delete();

        return response()->json(['data' => ['msg' => 'Categoria removida com sucesso']]);
   
    }
}
