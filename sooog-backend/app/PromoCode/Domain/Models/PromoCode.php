<?php

namespace App\PromoCode\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Infrastructure\Domain\Filters\Filterable;

class PromoCode extends Model
{
    use Translatable, HasFactory, Filterable;
    public $translatedAttributes = ['name', 'description'];
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    /**
     * The stores that belong to the promo code.
     */
    public function stores()
    {
        return $this->belongsToMany('App\Store\Domain\Models\Store');
    }

    public function user()
    {
        return $this->belongsTo('App\User\Domain\Models\User');
    }

    public function scopeActive($query, $is_active)
    {
        if($is_active == 1){
            return $query->where('is_active', 1);
        }else{
            return $query->where('is_active', 0);
        }
    }

    public function orders()
    {
        return $this->hasMany('App\Order\Domain\Models\Order');
    }

}
