<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
   
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category_name' => $this->category->name,
            'name' => $this->pd_name,
            'buyprice' => number_format($this->pd_buyprice, 0, ',', '.'),
            'sellprice' =>  number_format($this->pd_sellprice, 0, ',', '.'),
            'desc' => $this->pd_desc,
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
