<?php

namespace App\Package\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $subscribed=false;
        if (auth()->guard('store')->check()) {
            if (auth()->user()->store()->activePackage) {
                $subscribed = auth()->user()->store()->activePackage->package_id==$this->id?true:false;
                }
        }
        $resource = [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'months' => $this->months,
            'product_number' => $this->product_number,
            'order_number' => $this->order_number,
            'has_chat' => (bool)$this->has_chat,
            'is_free' => (bool)$this->is_free,
            'is_rfq' => (bool)$this->is_rfq,
            'ar' => optional($this->translate('ar'))->only('name'),
            'en' => optional($this->translate('en'))->only('name'),
            'is_active' => (bool)$this->is_active,
            'image' => $this->image,
            'subscribed' => $subscribed,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ];
        return $resource;
    }
}
