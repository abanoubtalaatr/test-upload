<?php

namespace App\Package\Domain\Models;

use App\Store\Domain\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StorePackage extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $casts = [
        'is_active' => 'boolean',
        'is_free' => 'boolean',
        'has_chat' => 'boolean',
        'is_rfq' => 'boolean',
        'is_paid' => 'boolean',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class,'store_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
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

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('is_paid', function (Builder $builder) {
            $builder->where('is_paid', '=', 1);
        });
    }
}
