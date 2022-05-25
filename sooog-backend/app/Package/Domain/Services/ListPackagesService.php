<?php

namespace App\Package\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Package\Domain\Filters\PackageFilter;
use App\Package\Domain\Models\Package;
use Symfony\Component\HttpFoundation\Response;

class ListPackagesService extends Service
{
    protected $package, $filter;

    public function __construct(Package $package, PackageFilter $filter)
    {
        $this->package = $package;
        $this->filter = $filter;
    }

    public function handle($data = []) 
    {
        $order = isset($data['orderBy']) ? $data['orderBy'] : 'id';
        $order_type = isset($data['orderType']) ? $data['orderType'] : 'DESC';
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');
        $active = isset($data['active']) ? $data['active'] : 1;

        $packages = $this->package->filter($this->filter);
        if( !isset($data['is_paginated']) || $data['is_paginated'] == 0 ):
            $packages = $packages->active(1)
            ->orderBy($order, $order_type)->get();
            return new GenericPayload($packages, Response::HTTP_OK);
        else:
            $packages = $packages
                ->when(isset($data['active']), function($collection) use ($active){
                    return $collection->active($active);
                })
                ->when($order == 'name', function($collection) use ($order_type){
                    return $collection->join('package_translations', function ($join) {
                        $join->on('packages.id', '=', 'package_translations.package_id')
                            ->where('package_translations.locale', '=', app()->getLocale());
                    }) 
                    ->groupBy('packages.id')
                    ->orderBy('package_translations.name', $order_type)
                    ->select('packages.*', 'package_translations.id as package_translation_id');
                })
                ->when($order != 'name', function($collection) use ($order, $order_type){
                    return $collection->orderBy($order, $order_type);
                });
                if(!auth('admin')->check())
                    $packages = $packages->active(1);
                $packages = $packages->paginate($limit);
            return new GenericPayload($packages, Response::HTTP_ACCEPTED);
        endif;
    }

}
