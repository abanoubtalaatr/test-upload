<?php

namespace App\Package\Domain\Resources;

use App\Infrastructure\Domain\Resources\GenericNameResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class StorePackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {
        $resource =  [
            'id' => $this->id,
            'store_id' => $this->store_id,
            'package_id' => $this->package_id,
            'package' => new PackageLiteResource($this->package),
            'store'=>new GenericNameResource($this->store),
            'from' => $this->from,
            'expire_at' => $this->expire_at,
            'price' => $this->price,
            'days' => $this->days,
            'product_number' => $this->product_number,
            'order_number' => $this->order_number,
            'has_chat' => (bool) $this->has_chat,
            'is_free' => (bool) $this->is_free,
            'is_rfq' => (bool) $this->is_rfq,
            'is_active' => (bool) $this->is_active,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ];
        return $resource;
    }
}
