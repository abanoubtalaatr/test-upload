<?php

namespace App\Package\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PackageLiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {
        $subscribed=false;
        if (auth()->guard('store')->check()) {
            if (auth('store')->user()->store->activePackage) {
                $subscribed = auth('store')->user()->store->activePackage->package_id==$this->id?true:false;
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'months' => $this->months,
            'product_number' => $this->product_number,
            'order_number' => $this->order_number,
            'has_chat' => $this->has_chat,
            'is_free' => $this->is_free,
            'is_rfq' => $this->is_rfq,
            'image' => $this->image,
            'is_active' => $this->is_active,
            'subscribed' => $subscribed,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ];
    }
}
