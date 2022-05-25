<?php

namespace App\AppContent\Domain\Services\Statistics;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;
use App\Category\Domain\Models\Category;
use App\Product\Domain\Models\Product;
use App\Property\Domain\Models\Property;
use App\Warranty\Domain\Models\Warranty;
use App\Brand\Domain\Models\Brand;
use App\Store\Domain\Models\Store;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;

class GetStatisticsService extends Service
{

    public function handle($data = []) 
    {
        $statistics = [];
        $store_id = auth()->user()->store_id;
        $statistics['products'] = Product::active(1)
            ->whereRelation('category', 'type', 'stores')
            ->when($store_id, function($collection) use ($store_id){
                return $collection->where('products.store_id', $store_id);
            })
            ->count();
        $statistics['not_active_products'] = Product::active(0)
            ->whereRelation('category', 'type', 'stores')
            ->when($store_id, function($collection) use ($store_id){
                return $collection->where('products.store_id', $store_id);
            })
            ->count();

        $statistics['services'] = Product::active(1)
            ->whereRelation('category', 'type', 'centers')
            ->when($store_id, function($collection) use ($store_id){
                return $collection->where('products.store_id', $store_id);
            })
            ->count();

        $statistics['categories'] = Category::active(1)->whereNull('parent_id')->whereType('stores')->count();
        $statistics['service_types'] = Category::active(1)->whereType('centers')->count();
        $statistics['stores'] = Store::active(1)->whereType('stores')->count();
        $statistics['centers'] = Store::active(1)->whereType('centers')->count();
        $statistics['warranties'] = Warranty::active(1)->when($store_id, function($collection) use ($store_id){
                return $collection->where('warranties.store_id', $store_id);
            })
        ->count();
        $statistics['users'] = User::where('is_active', 1)->count();
        if(auth()->guard('store')->check()){
            return new GenericPayload(Arr::only($statistics, ['categories', 'products', 'warranties']), Response::HTTP_RESET_CONTENT);
        } else if(auth()->guard('center')->check()) {
            return new GenericPayload(Arr::only($statistics, ['service_types', 'services']), Response::HTTP_RESET_CONTENT);
        }else  if(auth()->guard('admin')->check()){
            return new GenericPayload($statistics, Response::HTTP_RESET_CONTENT);
        } else {
            return new GenericPayload([], Response::HTTP_RESET_CONTENT);
        }
        
    }
}


