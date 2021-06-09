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
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
   
    public function index(Request $request) 
    {  
        try{
            $search = $request->get('search');
            $categories = $this->category->when($request->search,function($query) use($search) {
                $query->Where('name','LIKE',"$search%")
                ->orWhere('status','LIKE',"$search%");
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
            ->orderBy('name','asc')
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
        $category = $this->category->findOrFail($id);
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
            $category = $this->category->find($id);
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
