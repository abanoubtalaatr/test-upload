<?php

namespace App\Warranty\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class WarrantyResource extends JsonResource
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
            'name' => $this->name,
            'ar' => optional($this->translate('ar'))->only('name', 'description'),
            'en' => optional($this->translate('en'))->only('name', 'description'),
            'is_active' => (bool) $this->is_active,
            'price' => $this->price,
            //'image' => $this->image,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ];
        return $resource;
    }
}