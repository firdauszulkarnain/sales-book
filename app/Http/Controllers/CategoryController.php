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
        $validatedData =  $request->validate([
            'name' => 'required|alpha'
        ]);

        $category = Category::create($validatedData);

        return response()->json([
            'message' => 'Category Successfully Created!',
            'data' => $category
        ]);
    }


    public function show(Category $category)
    {
        return CategoryResource::make($category);
    }

    public function update(Request $request, Category $category)
    {
        $validatedData =  $request->validate([
            'name' => 'required|alpha'
        ]);

        $category = Category::where('id', $request->id)->update($validatedData);
        return response()->json([
            'message' => 'Category Successfully Updated!',
            'data' => $category
        ]);
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
