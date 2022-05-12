<?php

namespace App\Http\Resources;

use App\Models\ProductDetail;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'categoryID' => $this->category->id,
            'categoryName' => $this->category->categoryName,
            'productName' => $this->productName,
            'productDesc'  =>  $this->productDesc,  
            'productDetail' => ProductDetailResource::collection($this->productDetail)
        ];
    }
}
