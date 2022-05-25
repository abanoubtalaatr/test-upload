<?php

namespace App\RequestOfferQuantity\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use App\User\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;

class ListRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        $order = $data['orderBy'] ?? 'category_id';
        $order_type = $data['orderType'] ?? 'DESC';
        $filter = $data['filter'] ?? 'null';
        $limit = $data['per_page'] ?? config('app.pagination_limit');

        if (isset($data['is_paginated']) && $data['is_paginated'] == 1) {
            $requests = RequestOfferQuantity::where('user_id', auth()->id())
                ->when($filter != 'null', function ($q) use ($filter) {
                    $q->where('status', $filter)
                        ->orWhere('product_name', $filter);
                })
                ->orderBy($order, $order_type)
                ->paginate($limit);


            return new GenericPayload($requests, Response::HTTP_ACCEPTED);
        }

        $requests = RequestOfferQuantity::where('user_id', auth()->id())
            ->when($filter != 'null', function ($q) use ($filter) {
                $q->where('status', $filter)
                    ->orWhere('product_name', $filter);
            })
            ->orderBy($order, $order_type)
            ->get();

        return new GenericPayload($requests, Response::HTTP_OK);
    }
}
