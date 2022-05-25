<?php

namespace App\Refund\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Infrastructure\Domain\Filters\Filterable;

class RefundReason extends Model
{
    use Translatable, HasFactory, Filterable;
    public $translatedAttributes = ['name'];
    public $translationForeignKey = 'refund_reason_id';
    protected $guarded = ['id'];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query, $is_active)
    {
        if($is_active == 1){
            return $query->where('is_active', 1);
        }else{
            return $query->where('is_active', 0);
        }
    }

    public function refunds() {
        return $this->hasMany('App\Refund\Domain\Models\Refund');
    }
}
