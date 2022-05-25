<?php

namespace App\Refund\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User\Domain\Resources\UserLiteResource;
use App\Order\Domain\Resources\OrderLiteResource;
use App\Order\Domain\Resources\OrderStatusResource;
use App\Order\Domain\Resources\OrderItemResource;
use App\Infrastructure\Domain\Resources\GenericNameResource;
class RefundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {
        $items = [];
        if($this->refund_type == 'order')
            $items = OrderItemResource::collection($this->order->orderItems);
        else
            $items = RefundItemResource::collection($this->refundItems);
        
        return [
            'id' => $this->id,
            'refund_type' => $this->refund_type,
            'order' => new OrderLiteResource($this->order),
            'refund_reason' => new GenericNameResource($this->refundReason),
            'status' => new GenericNameResource($this->status),
            'items' => $items,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            //'discount' => $this->discount,
            'promo_code_discount' => $this->promo_code_discount,
            //'total' => number_format((float)($this->subtotal - $this->coupon_discount), 2, '.', ''),
            'note' => $this->note,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
            //'created_by' => new UserLiteResource($this->creator),
            'statuses' => OrderStatusResource::collection($this->statuses),

        ];
    }
}