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
        $validatedData =  $this->validateData($request);
        $product = Product::create($validatedData);
        return response()->json([
            'message' => 'Product Successfully Created!',
            'data' => $product
        ]);
    }

   
    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    
    public function update(Product $product, Request $request)
    {
        $validatedData = $this->validateData($request);
        $product = Product::where('id', $product->id)->update($validatedData);
        return response()->json([
            'message' => 'Product Successfully Updated!',
            'data' => $product
        ]);
    }

    
    public function destroy($id)
    {
        //
    }

    protected function validateData(Request $request){
        $rules = [
            'category_id' => 'required',
            'pd_name' => 'required',
            'pd_buyprice' => 'required|numeric',
            'pd_sellprice' => 'required|numeric',
            'pd_desc' => 'required',
        ];

        $message = [
            'category_id.required' => 'Category field is required!',
            'pd_name.required' => 'Product Name field is required!',
            'pd_buyprice.required' => 'Product Buyprice field is required!',
            'pd_sellprice.required' => 'Product Sellprice field is required!',
            'pd_desc.required' => 'Product Description field is required!',
            'pd_buyprice.numeric' => 'Product Buyprice must be a number!',
            'pd_sellprice.numeric' => 'Product Sellprice must be a number!',
        ];

        return $request->validate($rules, $message);
    }
}
