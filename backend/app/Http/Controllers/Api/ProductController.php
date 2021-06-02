<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function save(ProductRequest $request)
    {
        try{
            $product = $request->all();
            if(empty($product['estoque'])) {
                $product['estoque'] = $product['estoque'];
            }
            if($request->hasFile($product['imagem'])) {
                $base64_image = $product['imagem'];
                $base = base64_decode($base64_image);  
                $base64 = time().'.' . explode('/', explode(':', substr($base64_image, 0, strpos($base64_image, ';')))[1])[1];
                $destinationPath = public_path() . "/" . $base64;             
                file_put_contents($destinationPath, $base);
                Storage::disk('public')->put($base64, base64_decode($destinationPath));
            }
            Product::create($product);
            Log::info('Usuário: '. Auth::user()->name . ' | ' . __METHOD__ . ' | ' . json_encode($request->except('imagem')) . $request->ip());
            return response()->json(['success'=>$product],200);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    } 

    public function update(ProductRequest $request,$id) 
    {
        try{
            $data = $request->all();
            $product = $this->product->find($id);
            if($request->hasFile($product['imagem'])) {
                $base64_image = $product['imagem']; 
                $base = base64_decode($base64_image);  
                $base64 = time().'.' . explode('/', explode(':', substr($base64_image, 0, strpos($base64_image, ';')))[1])[1];
                $destinationPath = public_path() . "/" . $base64;             
                file_put_contents($destinationPath, $base);
                Storage::disk('public')->put($base64, base64_decode($destinationPath));
            }
            $product->update($data);
            Log::info('Usuário: '. Auth::user()->name . ' | ' . __METHOD__ . ' | ' . json_encode($request->all()) . $request->ip());
            return response()->json(['sucess'=>$product,'url'=> $request->imagem],200);
        }catch(Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function delete($id)
    {
        try{
            $product = $this->product->find($id);
            $product->delete();
            return response()->json(['data' => ['msg' => 'Produto removido com sucesso']]);
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
}
