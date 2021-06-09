<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Category;
use App\Client;
use App\Product;
use Illuminate\Http\Request;

class getController extends Controller
{
    public function categories()
    {
        return Category::select('id','name','status')->get();
    }

    public function products()
    {
        return Product::select('id','name','description','price','estoque','imagem','status','category_id')
                        ->with('categories:id,name')
                        ->get();
    }

    public function clients()
    {
        return Client::select('id','name','cpf','email','date_nasc','cep','street','number','complement','city',
                        'state','heigthboard','fone','celular','status' )
                        ->get();
    }
}
