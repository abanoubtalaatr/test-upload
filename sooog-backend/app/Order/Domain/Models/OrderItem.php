<?php

namespace App\Order\Domain\Models;

use App\Product\Domain\Models\ProductUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo('App\Product\Domain\Models\ProductView');
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class,'unit_id');
    }

    public function offer()
    {
        return $this->belongsTo('App\Offer\Domain\Models\Offer', 'offer_id', 'id');
    }


    public function freeProduct()
    {
        return $this->belongsTo('App\Product\Domain\Models\Product', 'free_product_id', 'id');
    }

    public function warranty()
    {
        return $this->belongsTo('App\Warranty\Domain\Models\Warranty', 'warranty_id', 'id');
    }
}
