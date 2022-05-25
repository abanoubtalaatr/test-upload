<?php

namespace App\Banner\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use  HasFactory;
    protected $fillable=['image','is_active'];
    protected $casts = [
        'is_active' => 'boolean'
    ];
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

            return \Storage::disk('public')->url('/banners/'.$image);
        else:
            return "";
        endif;
    }
}
