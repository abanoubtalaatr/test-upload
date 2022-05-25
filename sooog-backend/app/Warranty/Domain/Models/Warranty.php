<?php

namespace App\Warranty\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Infrastructure\Domain\Filters\Filterable;

class Warranty extends Model
{
    use Translatable, HasFactory, Filterable;
    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['image', 'is_active', 'price', 'store_id'];
    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function products()
    {
        return $this->hasMany('App\Product\Domain\Models\Product', 'warranty_id', 'id');
    }

    protected function setImageAttribute($value)
    {
        $image = explode("/", $value);
        $this->attributes['image'] = end($image);
    }
    protected function getImageAttribute($image)
    {
        if (isset($image)):
            return \Storage::disk('public')->url('/warranties/'.$image);
        else:
            return "";
        endif;
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
        return $this->hasMany('App\Order\Domain\Models\OrderItem', 'warranty_id', 'id');
    }

    public function Store() {
        return $this->belongsTo('App\Store\Domain\Models\Store');  
    }
}
