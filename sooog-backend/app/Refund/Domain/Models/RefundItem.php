<?php

namespace App\Refund\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function orderItem()
    {
        return $this->belongsTo('App\Order\Domain\Models\OrderItem');
    }

    public function refund()
    {
        return $this->belongsTo('App\Refund\Domain\Models\Refund');
    }
}
