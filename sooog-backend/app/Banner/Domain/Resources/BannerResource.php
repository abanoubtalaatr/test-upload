<?php

namespace App\Banner\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Category\Domain\Resources\CategoryLiteResource;

class BannerResource extends JsonResource
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
            'image' => $this->image,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
        ];
    }
}
