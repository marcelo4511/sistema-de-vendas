<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
   
    public function index(Request $request) 
    {  
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
       ->paginate(10); 
        return response()->json($categories);
    }

    public function show($id) 
    {
        $category = $this->category->find($id);
        return response()->json($category);
    }

    public function save( Request $request)
    {
        $category = new Category();
        $category->name = $request->input('name');
        $category->status = $request->input('status');
        
        try {
            $category->save();
            return response()->json($category,200);
        
        }catch(\Exception $e) {
            return response()->json(401);
        }
    }

    public function update(Request $request,$id) 
    {
        $data = $request->all();
        $category = $this->category->findOrFail($id);
        $category->update($data);
        return response()->json($category);
    }

    public function delete($id)
    {
        Category::where('id', $id)->delete();

        return response()->json(['data' => ['msg' => 'Categoria removida com sucesso']]);
    }
}
