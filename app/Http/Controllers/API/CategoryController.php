<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $categories = Auth::user()->categories; 
        return CategoryResource::collection($categories);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->user_id = Auth::id(); 
        $category->save();

        return new CategoryResource($category);
    }

   
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category); 

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->name = $request->name;
        $category->save();

        return new CategoryResource($category);
    }

    
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category); 

        $category->delete();
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
