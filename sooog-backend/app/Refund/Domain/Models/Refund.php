<?php

namespace App\Refund\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Infrastructure\Domain\Filters\Filterable;
//use OwenIt\Auditing\Contracts\Auditable;

//class Refund extends Model implements Auditable
class Refund extends Model
{
    use HasFactory, Filterable;
    //use \OwenIt\Auditing\Auditable;
    protected $guarded = ['id'];

    public function refundItems()
    {
        return $this->hasMany('App\Refund\Domain\Models\RefundItem');
    }
    
    public function status()
    {
        return $this->belongsTo('App\Order\Domain\Models\Status');
    }

    public function refundReason()
    {
        return $this->belongsTo('App\Refund\Domain\Models\RefundReason');
    }

    public function order()
    {
        return $this->belongsTo('App\Order\Domain\Models\Order');
    }

    public function creator()
    {
        return $this->belongsTo('App\User\Domain\Models\User', 'created_by');
    }

    public function statuses()
    {
        return $this->hasMany('App\Order\Domain\Models\OrderStatus', 'order_id')->where('type', 'refund');
    }

    // scope to return only requests of certain store
    public function scopeOfStore($query, $store)
    {
        return $query->whereRelation('order', 'orders.store_id', $store);;

    }
}
