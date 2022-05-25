<?php

namespace App\Ad\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Ad\Domain\Models\Ad;
use App\Ad\Domain\Filters\AdFilter;
use Symfony\Component\HttpFoundation\Response;

class ListAdsService extends Service
{
    protected $ad, $filter;

    public function __construct(Ad $ad, AdFilter $filter)
    {
        $this->Ad = $ad;
        $this->filter = $filter;
    }

    public function handle($data = [])
    {
        $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active = isset($data['active']) ? $data['active'] : 1;
        $is_detailed = isset($data['is_detailed']) ? $data['is_detailed'] : 1;
        if($is_detailed == 'true')
            $is_detailed = 1;

        $ads = $this->Ad
        ->filter($this->filter)
        ->when(isset($data['active']), function($collection) use ($active){
            return $collection->active($active);
        })
        ->when($order == 'name', function($collection) use ($order_type){
            return $collection->join('ad_translations', function ($join) {
                $join->on('ads.id', '=', 'ad_translations.ad_id')
                    ->where('ad_translations.locale', '=', app()->getLocale());
            })
            ->groupBy('ads.id')
            ->orderBy('ad_translations.name', $order_type)
            ->select('ads.*', 'ad_translations.id as ad_translation_id');
        })
        ->when($order != 'name', function($collection) use ($order, $order_type){
            return $collection->orderBy($order, $order_type);
        });

        if( !isset($data['is_detailed'])):
            $ads = $ads->active(1);
            if( isset($data['is_paginated']) && $data['is_paginated'] == 1 )
                return new GenericPayload($ads->paginate($limit), Response::HTTP_ACCEPTED);
            return new GenericPayload($ads->get(), Response::HTTP_OK);
        else:
            $ads = $ads->paginate($limit);
            return new GenericPayload($ads, Response::HTTP_ACCEPTED);
        endif;
    }
}
