<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::latest()->get();
        return CategoryResource::collection($category);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Category Successfully Created!',
            'data' => $category
        ]);
    }


    public function show(Category $category)
    {
        //
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        Category::where('id', $category->id)->delete();
        return response()->json([
            'message' => 'Category Successfully Deleted!',
            'data' => $category
        ]);
    }
}
