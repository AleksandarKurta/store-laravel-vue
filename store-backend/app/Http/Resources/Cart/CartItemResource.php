<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'product_id' => $this->product_id,
            'title' => $this->product->title,
            'price' => $this->product->price,
            'image' => $this->product->image,
            'quantity' => $this->quantity,
        ];
    }
}
