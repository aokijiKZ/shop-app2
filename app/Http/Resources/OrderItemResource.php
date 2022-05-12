<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'productName' => $this->productDetail->product->productName,
            'productGender' => $this->productDetail->gender->genderName,
            'productSize' => $this->productDetail->size->sizeName,
            'productAmount' => '( proDetailID ' .$this->productDetail->id.' ) '.$this->amount,
            'productPrice' => $this->productDetail->price,
            'totalPrice' => $this->order->price,
        ];

    }
}
