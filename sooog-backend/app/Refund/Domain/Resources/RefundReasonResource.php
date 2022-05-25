<?php

namespace App\Refund\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RefundReasonResource extends JsonResource
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
            'type' => $this->type,
            'name' => $this->name,
            'ar' => optional($this->translate('ar'))->only('name'),
            'en' => optional($this->translate('en'))->only('name'),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
        ];
    }
}