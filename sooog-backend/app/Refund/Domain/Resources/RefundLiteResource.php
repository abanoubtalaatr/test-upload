<?php

namespace App\Refund\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User\Domain\Resources\UserLiteResource;
use App\Order\Domain\Resources\OrderLiteResource;
use App\Order\Domain\Resources\OrderStatusResource;
use App\Order\Domain\Resources\OrderItemResource;
use App\Infrastructure\Domain\Resources\GenericNameResource;
class RefundLiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {
        return [
            'id' => $this->id,
            'refund_type' => $this->refund_type,
            'order' => new OrderLiteResource($this->order),
            'status' => new GenericNameResource($this->status),
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'promo_code_discount' => $this->promo_code_discount,
            'total' => round(($this->subtotal - $this->coupon_discount), 2),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),

        ];
    }
}