<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function index(Request $request) 
    {  
        try{
            $search = $request->get('search');
            $categories = Category::when($request->search,function($q) use($search) {
                $q->where($search,function($query) use($search) {
                    $query->where('name','LIKE',"$search%")
                    ->orWhere('status','LIKE',"$search%");
                });
            })
            ->when($request->name,function($query) use ($request) {
                $query->where('name','LIKE', '%'. $request->name . '%');
            })
            ->when($request->status,function($query) use ($request) {
                $query->where('status','LIKE',"%$request->status%");
            })
            ->when($request->column,function($query) use($request) {
                $query->orderBy($request->column, $request->order);
            })
            ->paginate(10); 
            return response()->json($categories,200);
        }catch(Exception $exception){
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        } 
    }

    public function show($id) 
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function save(CategoryRequest $request)
    {
        try {
            $category = new Category();
            $category->name = $request->input('name');
            $category->status = $request->input('status');
            $category->save();
            Log::info('Usuário: '. Auth::user()->name . ' | ' . __METHOD__ . ' | ' . json_encode($request->all()));
            return response()->json($category,200);
        
        }catch(\Exception $exception) {
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function update(CategoryRequest $request,$id) 
    {
        try{
            $data = $request->all();
            $category = Category::find($id);
            $category->update($data);
            return response()->json($category,200);
        }catch(Exception $exception){
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => true]);
        }
    }

    public function delete($id)
    {
        try{
            Category::where('id', $id)->delete();
            return response()->json(['data' => ['msg' => 'Categoria removida com sucesso'],'status' => true],200);
        }catch(Exception $exception){
            $exception_message = !empty($exception->getMessage()) ? trim($exception->getMessage()) : 'App Error Exception';
            Log::error($exception_message. " in file " .$exception->getFile(). " on line " .$exception->getLine());
            return response()->json(['err' => $exception->getMessage(), 'status' => false]);
        }
    }
}
