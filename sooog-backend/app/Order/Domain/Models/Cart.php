<?php

namespace App\Order\Domain\Models;

use App\Product\Domain\Models\ProductUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo('App\User\Domain\Models\User');
    }

    public function unit()
    {
        return $this->belongsTo(ProductUnit::class,'unit_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product\Domain\Models\ProductView');
    }

    public function store()
    {
        return $this->belongsTo('App\Store\Domain\Models\Store');
    }

    public function warranty()
    {
        return $this->belongsTo('App\Warranty\Domain\Models\Warranty');
    }

}
