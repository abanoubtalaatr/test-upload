<?php

namespace App\Refund\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Product\Domain\Resources\ProductLiteResource;
class RefundItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {
       $total = (optional($this->orderItem)->product_price + optional($this->orderItem)->warranty_price - optional($this->orderItem)->discount) * $this->quantity;
        //$price = optional($this->orderItem)->product_price - optional($this->orderItem)->discount;
        return [
            'id' => optional($this->orderItem)->id,
            'quantity' => $this->quantity,
            'price_including_tax' => optional($this->orderItem)->product_price,
            'warranty_price' => optional($this->orderItem)->warranty_price,
            'discount' => optional($this->orderItem)->offer_discount,
            'total' => number_format((float)$total, 3, '.', ''),
            'product' => new ProductLiteResource(optional($this->orderItem)->product),
            'free_product' => new ProductLiteResource(optional($this->orderItem)->freeProduct)
        ];
    }
}