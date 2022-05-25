<?php

namespace App\Product\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Product\Domain\Models\ProductView;
use DB;
use Symfony\Component\HttpFoundation\Response;
class ListMostSellingProductsService extends Service
{

    public function handle($data = []) 
    {
        $limit = isset($data['per_page']) ? $data['per_page'] : config('app.pagination_limit');

        $products = ProductView::active(1)
            ->whereHas('store',function ($q){
                $q->hasActivePackage();
            })
//        ->whereNotNull('products_view.price')->where('products_view.quantity', '>', 0)
//            ->where('products_view.quantity', '>', 0)
        	->leftJoin('order_items', 'product_id', '=', 'products_view.id')
		    ->select('products_view.*', DB::raw('COUNT(order_items.id) as sales_count'), DB::raw('SUM(order_items.quantity) as sales_quantity'))
		    ->groupBy('products_view.id')
		    ->orderBy('sales_count', 'desc')
		    ->paginate($limit);

        return new GenericPayload($products, Response::HTTP_ACCEPTED);
    }
}
