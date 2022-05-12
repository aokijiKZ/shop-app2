<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
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
            'productID' => $this->productID,
            'productName' => $this->product->productName,
            'gender' => $this->gender->genderName,
            'size' => $this->size->sizeName,
            'price' => $this->price
        ];

    }
}
