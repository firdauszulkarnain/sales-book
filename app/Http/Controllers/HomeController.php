<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function update_stock(Product $product, Request $request){
        $validatedData = $request->validate([
            'stock' => 'required',
        ]);

        $product = Product::where('id', $product->id)->update([
            'pd_stock' => $validatedData['stock'],
        ]);

        return response()->json([
            'message' => 'Stock Product Successfully Updated!',
            'data' => $product
        ]);
    }
}
