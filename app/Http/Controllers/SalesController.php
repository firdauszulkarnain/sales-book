<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\SalesResource;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sales::latest()->get();
        return SalesResource::collection($sales);
    }

    public function store(Request $request)
    {
        $validatedData =  $this->validateData($request);
        $product = Product::where('id', $request->product_id)->first();
        $sales = Sales::create([
            'product_id' => $request->product_id,
            'sl_buyprice' => $product->pd_buyprice,
            'sl_sellprice' => $product->pd_sellprice,
            'sl_qty' => $request->sl_qty,
            'sl_total' => (int)$product->pd_sellprice * $request->sl_qty
        ]);

        $product->pd_stock = $product->pd_stock - $request->sl_qty;
        $product->save();
        $sales = ['status' => 'ok'];
        return response()->json([
            'message' => 'Sales Successfully Added!',
            'data' => $sales
        ]);
    }

    public function show(Sales $sales)
    {
        //
    }

    public function update(Request $request, Sales $sales)
    {
        //
    }

    public function destroy(Sales $sales)
    {
        //
    }

    protected function validateData(Request $request){
        $rules = [
            'product_id' => 'required',
            'sl_qty' => 'required',
        ];

        $message = [
            'product_id.required' => 'Product Field is Required!',
            'sl_qty.required' => 'Qty Field is Required!',
        ];

        return $request->validate($rules, $message);
    }
}
