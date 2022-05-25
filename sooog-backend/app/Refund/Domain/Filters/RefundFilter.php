<?php
namespace App\Refund\Domain\Filters;

use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use App\Infrastructure\Domain\Filters\QueryFilter;
class RefundFilter extends QueryFilter
{

    public function status($status)
    {
        $this->builder->whereHas('status', function($q) use ($status) {
           // $q->where('key', 'like', '%' . $status . '%');
            $q->where('key', $status)->where('type', 'refund');
        });
    }

    public function address($address)
    {
        $this->builder->whereHas('order.userAddress', function ($query) use($address){
            $query->where('address', 'like', '%'.$address.'%');
        });
    }

    public function city($city)
    {
        $this->builder->whereHas('order.userAddress', function ($query) use($city){
            $query->where('city_id', $city);
        });
    }

    public function state($state)
    {
        $this->builder->whereHas('order.userAddress', function ($query) use($state){
            $query->where('state_id', $state);
        });
    }

    public function country($country)
    {
        $this->builder->whereHas('order.userAddress', function ($query)  use($country){
            $query->where('country_id', $country);
        });
    }

    public function paymentMethod($payment_method)
    {
        $this->builder->whereHas('order', function ($query) use($payment_method){
            $query->where('payment_method_id', $payment_method);
        });
    }

    public function store($store_id)
    {
        $this->builder->whereHas('order', function ($query) use($store_id){
            $query->where('store_id', $store_id);
        });
    }

    public function type($type)
    {
        $this->builder->whereHas('order', function ($query) use($type){
            $query->where('type', $type);
        });
    }

    public function customer($customer_id)
    {
        $this->builder->whereHas('order', function ($query) use($customer_id){
            $query->where('user_id', $customer_id);
        });
    }

    public function startDate($start_date)
    {
        $date = Carbon::parse($start_date)->toDateString();
        //$date = Carbon::parse($value)->format('Y-m-d');
        $this->builder->whereDate('created_at', '>=', $date);
    }

    public function endDate($end_date)
    {
        $date = Carbon::parse($end_date)->toDateString();
        $this->builder->whereDate('created_at', '<=', $date);
    }

    public function costFrom($from)
    {
        $this->builder->where('subtotal', '>=', $from);
    }

    public function costTo($to)
    {
        $this->builder->where('subtotal', '<=', $to);
    }

    public function statusId($status_id)
    {
        $this->builder->where('status_id', $status_id);
    }

    public function publicSearch($search)
    {
        $this->builder->whereHas('order.userAddress', function ($query) use($search){
            $query->where('address', 'like', '%'.$search.'%')
            ->orWhereHas('city', function($q) use ($search){
                $q->whereRelation('translations', 'name', 'like', '%' . $search . '%');
            });
        })
        ->orWhereHas('refundItems.orderItem.product', function($q) use ($search){
            $q->where('barcode','like', '%'.$search.'%');
        })
        ->orWhereHas('order.orderItems.product', function($q) use ($search){
            $q->where('barcode','like', '%'.$search.'%');
        })
        ->orWhereHas('order.user', function($q) use ($search){
            $q->where('phone','like', '%'.$search.'%')
            ->orWhere('email','like', '%'.$search.'%')
            ->orWhere('name','like', '%'.$search.'%');
        })
        ->orWhere('id', $search)
        ->orWhere('total', $search)
        ->orWhereHas('status', function ($query)  use($search){
            $query->whereRelation('translations', 'name', 'like', '%' . $search . '%');
        })
        ->orWhereHas('order.paymentMethod', function ($query)  use($search){
            $query->whereRelation('translations', 'name', 'like', '%' . $search . '%');
        });
    }

    public function orderBy($orderBy)
    {
        $this->builder->orderBy($orderBy, request()->orderType ?? 'DESC');
    }

}
