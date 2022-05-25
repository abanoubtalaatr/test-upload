<?php

namespace App\Ad\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Category\Domain\Resources\CategoryLiteResource;

class AdResource extends JsonResource
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
            'is_active' => $this->is_active,
            'name' => $this->name,
            'description' => $this->description,
            'ar' => $this->translate('ar')->only('name', 'description'),
            'en' => $this->translate('en')->only('name', 'description'),
            'image' => $this->image,
            //'ad_url' => $this->ad_url,
            //'category' => new CategoryLiteResource($this->category),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
        ];
    }
}