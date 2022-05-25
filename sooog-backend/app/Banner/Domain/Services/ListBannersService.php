<?php

namespace App\Banner\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Banner\Domain\Models\Banner;
use Symfony\Component\HttpFoundation\Response;

class ListBannersService extends Service
{
    protected $banner;

    public function __construct(Banner $banner)
    {
        $this->Banner = $banner;
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

        $banners = $this->Banner
        ->when(isset($data['active']), function($collection) use ($active){
            return $collection->active($active);
        })
        ->when($order != 'name', function($collection) use ($order, $order_type){
            return $collection->orderBy($order, $order_type);
        });
        
        if( !isset($data['is_detailed'])):
            $banners = $banners->active(1);
            if( isset($data['is_paginated']) && $data['is_paginated'] == 1 )
                return new GenericPayload($banners->paginate($limit), Response::HTTP_ACCEPTED);
            return new GenericPayload($banners->get(), Response::HTTP_OK);
        else:
            $banners = $banners->paginate($limit);
            return new GenericPayload($banners, Response::HTTP_ACCEPTED);
        endif;
    }
}
