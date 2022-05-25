<?php

namespace App\Package\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Infrastructure\Domain\Filters\Filterable;

class Package extends Model
{
    use Translatable, HasFactory, Filterable;
    public $translatedAttributes = ['name'];
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean',
        'is_free' => 'boolean',
        'has_chat' => 'boolean',
        'is_rfq' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(StorePackage::class,'package_id');
    }

    public function scopeActive($query, $is_active)
    {
        if($is_active == 1){
            return $query->where('is_active', 1);
        }else{
            return $query->where('is_active', 0);
        }
    }

    public function scopeFree($query, $is_active)
    {
        if($is_active == 1){
            return $query->where('is_free', 1);
        }else{
            return $query->where('is_free', 0);
        }
    }

    public function scopeChat($query, $is_active)
    {
        if($is_active == 1){
            return $query->where('has_chat', 1);
        }else{
            return $query->where('has_chat', 0);
        }
    }

    public function scopeRfq($query, $is_active)
    {
        if($is_active == 1){
            return $query->where('is_rfq', 1);
        }else{
            return $query->where('is_rfq', 0);
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
            return \Storage::disk('public')->url('/packages/'.$image);
        else:
            return "";
        endif;
    }



}
