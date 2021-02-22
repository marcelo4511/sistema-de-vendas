<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Storage;
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
        $product = $request->all();
        if(empty($product['estoque'])) {
            $product['estoque'] = $product['estoque'];
        }
        if(isset($product['price'])) {

            $product['price'] = str_replace(',', '.',$product['price']);
            $product['price'] = preg_replace('/[^\d\.]/', '', $product['price']);
        }
        $teste = $request->file('imagem')->getClientOriginalName();
        $request->file('imagem')->move(public_path("/"),$teste);
        $photo = url('/'.$teste);
        Product::create($product);
        return response()->json(['sucess'=>$product,'url'=> $photo],200);
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
