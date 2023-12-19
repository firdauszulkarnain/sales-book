<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
   
    public function index()
    {
        $product = Product::latest()->get();
        return ProductResource::collection($product);
    }

   
    public function store(Request $request)
    {
        $validatedData =  $request->validate([
            'category_id' => 'required',
            'pd_name' => 'required',
            'pd_buyprice' => 'required|numeric',
            'pd_sellprice' => 'required|numeric',
            'pd_desc' => 'required',
        ]);

        $product = Product::create($validatedData);
        return response()->json([
            'message' => 'Product Successfully Created!',
            'data' => $product
        ]);
    }

   
    public function show($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
