<?php

namespace App\RequestOfferQuantity\Domain\Services\Store;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Product\Domain\Models\Product;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Symfony\Component\HttpFoundation\Response;
use function config;

class NewRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        $order = $data['orderBy'] ?? 'category_id';
        $order_type = $data['orderType'] ?? 'DESC';
        $limit = $data['per_page'] ?? config('app.pagination_limit');

        $categories = Product::where('store_id', auth('store')->user()->store->id)
            ->pluck('category_id')
            ->toArray();

        if (isset($data['is_paginated']) && $data['is_paginated'] == 1) {

            $requests = RequestOfferQuantity::whereIn('category_id', $categories)
                ->where('status', 'Pending')
                ->orderBy($order, $order_type)
                ->paginate($limit);

            return new GenericPayload($requests, Response::HTTP_ACCEPTED);
        }

        $requests = RequestOfferQuantity::whereIn('category_id', $categories)
            ->where('status', 'Pending')
            ->orderBy($order, $order_type)
            ->get();


        return new GenericPayload($requests, Response::HTTP_OK);
    }
}
