<?php

namespace App\Product\Domain\Models;

use App\Order\Domain\Models\Cart;
use App\Order\Domain\Models\Order;
use App\Order\Domain\Models\OrderItem;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory,Translatable;
    public $translatedAttributes = ['name'];
    public $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class,'unit_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class,'unit_id');
    }
}
