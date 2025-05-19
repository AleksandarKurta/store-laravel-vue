<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'cart_token' => $this->cart_token,
            'total_quantity' => $this->items->sum('quantity'),
            'total_price' => $this->items->sum(fn($item) => $item->quantity * $item->product->price),
            'items' => CartItemResource::collection($this->items),
        ];
    }
}
