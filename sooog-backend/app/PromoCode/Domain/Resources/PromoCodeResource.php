<?php

namespace App\PromoCode\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Infrastructure\Domain\Resources\GenericNameResource;
use App\User\Domain\Resources\UserLiteResource;

class PromoCodeResource extends JsonResource
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
            'is_active' => $this->is_active,
            'ar' => optional($this->translate('ar'))->only('name'),
            'en' => optional($this->translate('en'))->only('name'),
            'type' => $this->type,
            'value' => $this->value,
            'code' => $this->code,
            'applied_to' => $this->applied_to,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'max_use_number' => $this->max_use_number,
            'order_min_cost' => $this->order_min_cost,
            'stores' => GenericNameResource::collection($this->stores),
            'user' => new UserLiteResource($this->user),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
            'created_by' => $this->created_by
        ];
    }
}