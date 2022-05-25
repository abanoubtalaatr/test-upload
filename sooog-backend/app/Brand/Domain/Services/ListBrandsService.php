<?php

namespace App\Brand\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Brand\Domain\Models\Brand;
use App\Brand\Domain\Filters\BrandFilter;
use Symfony\Component\HttpFoundation\Response;

class ListBrandsService extends Service
{
    protected $brand, $filter;

    public function __construct(Brand $brand, BrandFilter $filter)
    {
        $this->brand = $brand;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active = isset($data['active']) ? $data['active'] : 1;

        $brands = $this->brand->filter($this->filter);
        if( !isset($data['is_paginated']) || $data['is_paginated'] == 0 ):
            $brands = $brands->active(1)
            ->when(!auth('admin')->check(), function($collection){
                return $collection->whereHas('products', function($q) {
                    $q->where('is_active', 1)->whereHas('units',function ($query){
                        $query->where('quantity', '>', 0);
                    });
                });
            })
            ->orderBy($order, $order_type)->get();
            return new GenericPayload($brands, Response::HTTP_OK);
        else:
            $brands = $brands
                ->when(isset($data['active']), function($collection) use ($active){
                    return $collection->active($active);
                })
                ->when($order == 'name', function($collection) use ($order_type){
                    return $collection->join('brand_translations', function ($join) {
                        $join->on('brands.id', '=', 'brand_translations.brand_id')
                            ->where('brand_translations.locale', '=', app()->getLocale());
                    }) 
                    ->groupBy('brands.id')
                    ->orderBy('brand_translations.name', $order_type)
                    ->select('brands.*', 'brand_translations.id as brand_translation_id');
                })
                ->when($order != 'name', function($collection) use ($order, $order_type){
                    return $collection->orderBy($order, $order_type);
                });
                if(!auth('admin')->check())
                    $brands = $brands->whereHas('products', function($q) {
                        $q->where('is_active', 1)->whereHas('units',function ($query){
                            $query->where('quantity', '>', 0);
                        });
                    });
                $brands = $brands->paginate($limit);
            return new GenericPayload($brands, Response::HTTP_ACCEPTED);
        endif;
    }

}
