<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(){
        $data = [
            'totCat' => Category::count(),
            'totProduct' =>  Product::count(),
            'totStock' => Product::sum('pd_stock'),
        ];

        return response()->json([
            'data' => $data
        ]);
    }
    public function update_stock(Product $product, Request $request){
        $validatedData = $request->validate([
            'stock' => 'required',
        ]);

        $product = Product::where('id', $product->id)->update([
            'pd_stock' => $product->pd_stock + $validatedData['stock'],
        ]);

        return response()->json([
            'message' => 'Stock Product Successfully Updated!',
            'data' => $product
        ]);
    }
}
