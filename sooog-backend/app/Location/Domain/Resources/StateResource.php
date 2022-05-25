<?php

namespace App\Location\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use App\Location\Domain\Resources\CityResource;
use App\Location\Domain\Resources\CountryResource;
class StateResource extends JsonResource
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
            "id" => $this->id,
            'name' => $this->name,
            'ar' => optional($this->translate('ar'))->only('name'),
            'en' => optional($this->translate('en'))->only('name'),
            'country' => new CountryResource($this->country),
            'is_active' => $this->is_active,
            //'cities' => CityResource::collection($this->cities),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ];
    }
}