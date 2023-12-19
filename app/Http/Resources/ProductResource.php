<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
   
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category->id,
            'category_name' => $this->category->name,
            'name' => $this->pd_name,
            'buyprice' => $this->pd_buyprice,
            'sellprice' =>  $this->pd_sellprice,
            'desc' => $this->pd_desc,
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
