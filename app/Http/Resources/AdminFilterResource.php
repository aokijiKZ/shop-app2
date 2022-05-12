<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminFilterResource extends JsonResource
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
            'orderID' => $this->id,
            'orderStatus' => $this->status->statusName,
            'orderPrice' => $this->price,
            'orderAddress' => $this->address,
            'orderDetail' => OrderItemResource::collection($this->orderDetail),
            'dateCreate' => $this->created_at
        ];


    }
}
