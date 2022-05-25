<?php

namespace App\Product\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User\Domain\Resources\UserLiteResource;
class ProductUnitsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) 
    {
        $tax_value=setting('added_tax');
        $price_including_tax=$this->price+($this->price*$tax_value/100);
        $discount = 0.000;
        $free_product = null;
        $offer = $this->product->offer->first();
        if ($offer && $this->product->category->type == 'stores'){
            if ($offer->type == 'percentage'){
                $discount = $price_including_tax * $offer->value / 100;
            }else{
                $discount = $offer->value;
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'ar' => $this->translate('ar') ? $this->translate('ar')->only(['name']) : null,
            'en' => $this->translate('en') ? $this->translate('en')->only(['name']) :null,
            'price_including_tax' => number_format((float)$price_including_tax, 2, '.', ''),
            'price_after_discount' => number_format((float)($price_including_tax - $discount), 2, '.', ''),
            'discount' => $discount > 0 ?number_format((float)($discount/$price_including_tax)*100, 2, '.', '') : 0.00,
        ];
    }
}
