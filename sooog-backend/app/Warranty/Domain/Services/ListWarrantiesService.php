<?php

namespace App\Warranty\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Warranty\Domain\Models\Warranty;
use App\Warranty\Domain\Filters\WarrantyFilter;
use Symfony\Component\HttpFoundation\Response;

class ListWarrantiesService extends Service
{
    protected $warranty, $filter;

    public function __construct(Warranty $warranty, WarrantyFilter $filter)
    {
        $this->warranty = $warranty;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        $store_id = null;
        if(auth()->guard('store')->check() || auth()->guard('center')->check())
            $store_id = auth()->user()->store_id;
        $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active = isset($data['active']) ? $data['active'] : 1;

        $warranties = $this->warranty->filter($this->filter);
        if( !isset($data['is_paginated']) || $data['is_paginated'] == 0 ):
            $cart = null;
            if(auth()->check())
                $cart = auth()->user()->cart()->orderBy('id', 'desc')->first();
            $warranties = $warranties->active(1)
            ->when($cart, function($collection) use ($cart){
                return $collection->where('warranties.store_id', $cart->store_id);
            })
            ->orderBy($order, $order_type)->get();
            return new GenericPayload($warranties, Response::HTTP_OK);
        else:
            $warranties = $warranties
                ->when($store_id, function($collection) use ($store_id){
                    return $collection->where('warranties.store_id', $store_id);
                })
                ->when(isset($data['active']), function($collection) use ($active){
                    return $collection->active($active);
                })
                ->when($order == 'name', function($collection) use ($order_type){
                    return $collection->join('warranty_translations', function ($join) {
                        $join->on('warranties.id', '=', 'warranty_translations.warranty_id')
                            ->where('warranty_translations.locale', '=', app()->getLocale());
                    }) 
                    ->groupBy('warranties.id')
                    ->orderBy('warranty_translations.name', $order_type)
                    ->select('warranties.*', 'warranty_translations.id as warranty_translation_id');
                })
                ->when($order != 'name', function($collection) use ($order, $order_type){
                    return $collection->orderBy($order, $order_type);
                })
                ->paginate($limit);
            return new GenericPayload($warranties, Response::HTTP_ACCEPTED);
        endif;
    }

}