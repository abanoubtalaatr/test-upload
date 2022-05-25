<?php

namespace App\BankAccount\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountLiteResource extends JsonResource
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
            'account_number' => $this->account_number,
            'iban_number' => $this->iban_number,
            'name' => $this->name,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y')
        ];
    }
}