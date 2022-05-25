<?php

namespace App\Order\Domain\Resources;

use App\Product\Domain\Resources\ProductUnitsResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\User\Domain\Resources\UserLiteResource;
use App\Product\Domain\Resources\ProductLiteResource;
use App\Warranty\Domain\Resources\WarrantyLiteResource;
class CartResource extends JsonResource
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
            'product' => new ProductLiteResource($this->product),
            'warranty' => new WarrantyLiteResource($this->warranty),
            'unit' => new ProductUnitsResource($this->unit),
            'quantity' => $this->quantity,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
            //'user' => new UserLiteResource($this->user),
        ];
    }
}
