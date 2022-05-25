<?php

namespace App\Ad\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Category\Domain\Resources\CategoryLiteResource;

class AdLiteResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'is_active' => $this->is_active,
            //'ad_url' => $this->ad_url,
            // 'category' => new CategoryLiteResource($this->category),
            // 'ad_link' => url('api/products').'?category='.$this->category_id,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
        ];
    }
}