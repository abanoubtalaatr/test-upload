<?php

namespace App\BankAccount\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResource extends JsonResource
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
            'image' => $this->image,
            'account_number' => $this->account_number,
            'iban_number' => $this->iban_number,
            'ar' => optional($this->translate('ar'))->only('name'),
            'en' => optional($this->translate('en'))->only('name'),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
            
        ];
    }
}