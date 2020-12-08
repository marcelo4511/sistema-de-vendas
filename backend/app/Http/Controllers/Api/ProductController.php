<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private $product;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index() 
    {
        $products = Product::with('categories')->get();
        return response()->json($products);
    }

    public function show($id) 
    {
        $product = $this->product->find($id);
        return response()->json($product);
    }

    public function save(Request $request)
    {
       
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->amount = $request->input('amount');
        $product->subtotal = $request->input('subtotal');
        $product->imagem = $request->input('imagem');
        $product->category_id = $request->input('category_id');
        $product->status = $request->input('status');
        $product->save();
        return response()->json($product);
    }

    public function update(Request $request,$id) 
    {
        $data = $request->all();
        $product = $this->product->findOrFail($id);
        $product->update($data);
        return response()->json($product);
    }

    public function delete($id)
    {
        $product = $this->product->find($id);
        $product->delete();

        return response()->json(['data' => ['msg' => 'Produto removido com sucesso']]);
    }
}
