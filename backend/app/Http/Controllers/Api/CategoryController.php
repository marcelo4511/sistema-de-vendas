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
        $categories = $this->category->orderBy("id","ASC")->get(); 
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
