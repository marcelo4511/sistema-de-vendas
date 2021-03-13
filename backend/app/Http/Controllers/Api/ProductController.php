<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

    public function filtro(Request $request)
    {
        $products = Product::select('id','name','description','price','estoque','category_id','status')->with('categories:id,name')
        ->when($request['name'],function($query) use($request) {
            $query->whereName($request['name']);
        })
        ->when($request['category_id'], function ($query) use ($request) {
            $query->whereCategoryId($request['category_id']);
        })
        ->get();

        return $products;
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

      if($request->imagem) {
        $name = time().'.' . explode('/', explode(':', substr($request->imagem, 0, strpos($request->imagem, ';')))[1])[1];
        \Intervention\Image\Facades\Image::make($request->imagem)->save(public_path('/').$name);
      }
      Product::create($product);
      return response()->json(['sucess'=>$product,'url'=> $request->imagem],200);

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
