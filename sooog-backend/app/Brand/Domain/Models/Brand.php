<?php

namespace App\Brand\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Infrastructure\Domain\Filters\Filterable;

class Brand extends Model
{
    use Translatable, HasFactory, Filterable;
    public $translatedAttributes = ['name', 'description'];
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean'
    ];
    public function products()
    {
        return $this->hasMany('App\Product\Domain\Models\Product', 'brand_id', 'id');
    }

    public function scopeActive($query, $is_active)
    {
        if($is_active == 1){
            return $query->where('is_active', 1);
        }else{
            return $query->where('is_active', 0);
        }
    }

    protected function setImageAttribute($value)
    {
        $image = explode("/", $value);
        $this->attributes['image'] = end($image);
    }
    protected function getImageAttribute($image)
    {
        if (isset($image)):
            return \Storage::disk('public')->url('/brands/'.$image);
        else:
            return "";
        endif;
    }



}
