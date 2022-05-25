<?php

namespace App\Product\Domain\Models;

use App\Infrastructure\Domain\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory, Filterable;
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo('App\User\Domain\Models\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Product\Domain\Models\Product');
    }
}
