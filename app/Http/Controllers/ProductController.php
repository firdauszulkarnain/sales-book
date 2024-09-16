<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
   
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        if($keyword){
            $product = Product::where('lower(pd_name)', 'like' ,  '%'.$keyword.'%')->paginate(3);
        }else{
            $product = Product::latest()->paginate(3);
        }
        return ProductResource::collection($product);
    }

   
    public function store(Request $request)
    {
        $validatedData =  $this->validateData($request);
        $validatedData['pd_buyprice'] = str_replace('.', '', $validatedData['pd_buyprice']);
        $validatedData['pd_sellprice'] = str_replace('.', '', $validatedData['pd_sellprice']);
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
        $validatedData['pd_buyprice'] = str_replace('.', '', $validatedData['pd_buyprice']);
        $validatedData['pd_sellprice'] = str_replace('.', '', $validatedData['pd_sellprice']);
        $product = Product::where('id', $product->id)->update($validatedData);
        return response()->json([
            'message' => 'Product Successfully Updated!',
            'data' => $product
        ]);
    }

    
    public function destroy(Product $product)
    {
        Product::where('id', $product->id)->delete();
        return response()->json([
            'message' => 'Product Successfully Deleted!',
            'data' => $product
        ]);
    }

    protected function validateData(Request $request){
        $rules = [
            'category_id' => 'required',
            'pd_name' => 'required',
            'pd_buyprice' => 'required',
            'pd_sellprice' => 'required',
            'pd_desc' => 'required',
        ];

        $message = [
            'category_id.required' => 'Category field is required!',
            'pd_name.required' => 'Product Name field is required!',
            'pd_buyprice.required' => 'Product Buyprice field is required!',
            'pd_sellprice.required' => 'Product Sellprice field is required!',
            'pd_desc.required' => 'Product Description field is required!',
        ];

        return $request->validate($rules, $message);
    }
}
