<?php

namespace App\Product\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Product\Domain\Models\ProductView;
use App\Product\Domain\Models\Product;
use App\Product\Domain\Filters\ProductFilter;
use DB;
use Symfony\Component\HttpFoundation\Response;
class ListProductsService extends Service
{
    protected $product, $filter;

    public function __construct(ProductView $product, ProductFilter $filter)
    {
        $this->product = $product;
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
        $is_detailed = isset($data['is_detailed']) ? $data['is_detailed'] : 1;
        if($is_detailed == 'true')
            $is_detailed = 1;
        $products = $this->product
            ->whereRelation('category', 'type', $data['type'])
            ->when($store_id, function($collection) use ($store_id){
                return $collection->where('products_view.store_id', $store_id);
            })
            ->when(!$store_id && !auth('admin')->check(),function ($q){
                $q->whereHas('store',function ($qu){
                    $qu->hasActivePackage();
                });
            })
            ->filter($this->filter)
            ->when($order == 'name', function($collection) use ($order_type){
                return $collection->join('product_translations', function ($join) {
                    $join->on('products_view.id', '=', 'product_translations.product_id')
                        ->where('product_translations.locale', '=', app()->getLocale());
                })
                ->groupBy('products_view.id')
                ->orderBy('product_translations.name', $order_type)
                ->select('products_view.*', 'product_translations.id as product_translation_id');
            })
            ->when($order == 'most_selling', function($collection) use ($order_type){
                return $collection->leftJoin('order_items', 'product_id', '=', 'products_view.id')
                    ->select('products_view.*', DB::raw('COUNT(order_items.id) as sales_count')
                        , DB::raw('SUM(order_items.quantity) as sales_quantity'))
                    ->groupBy('products_view.id')
                    ->orderBy('sales_count', $order_type);
            })
            ->when($order == 'most_rated', function($collection) use ($order_type){
                return $collection->leftJoin('ratings', 'product_id', '=', 'products_view.id')
                    ->select('products_view.*', DB::raw('avg(ratings.rate) as average'))
                    ->groupBy('products_view.id')
                    ->orderBy('average', $order_type);
            })
            ->when($order != 'name' && $order != 'most_selling' && $order != 'most_rated', function($collection) use ($order, $order_type){
                return $collection->orderBy($order, $order_type);
            });
        if( !isset($data['is_detailed'])):
            $products = $products->where('products_view.is_active', 1)
//                ->whereNotNull('products_view.price')
            ->when($data['type'] == 'stores', function($collection) {
                return $collection
//                    ->where('products_view.quantity', '>', 0)
                ->whereRelation('brand', 'is_active', 1);
            })
            ->whereRelation('category', 'is_active', 1)
            ->paginate($limit);
            return new GenericPayload($products, Response::HTTP_ACCEPTED);
        else:
            if(isset($data['has_pagination'])){
                $products = $products->where('products_view.is_active', $active)->get();
                return new GenericPayload($products, Response::HTTP_OK);
            }
            $products = $products->when(isset($data['active']), function($collection) use ($active){
                return $collection->where('products_view.is_active', $active);
            })
            ->paginate($limit);
            return new GenericPayload($products, Response::HTTP_ACCEPTED);
        endif;
    }
}
