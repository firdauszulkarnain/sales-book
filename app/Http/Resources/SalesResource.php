<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product->id,
            'product_name' => $this->product->pd_name,
            'category_name' => $this->product->category->name,
            'buyprice' => $this->sl_buyprice,
            'sellprice' => $this->sl_sellprice,
            'qty' => $this->sl_qty,
            'subtotal' =>  $this->sl_total,
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
