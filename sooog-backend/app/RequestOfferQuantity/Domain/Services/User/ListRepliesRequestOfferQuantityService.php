<?php

namespace App\RequestOfferQuantity\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Symfony\Component\HttpFoundation\Response;

class ListRepliesRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        $order = $data['orderBy'] ?? 'request_offer_quantity_id';
        $order_type = $data['orderType'] ?? 'DESC';

        $limit = $data['per_page'] ?? config('app.pagination_limit');

        if (isset($data['is_paginated']) && $data['is_paginated'] == 1) {
            $requests = ReplyRequestOfferQuantity::where('request_offer_quantity_id', $data['id'])
                ->orderBy($order, $order_type)
                ->paginate($limit);

            return new GenericPayload($requests, Response::HTTP_ACCEPTED);
        }

        $requests = ReplyRequestOfferQuantity::where('request_offer_quantity_id', $data['id'])
            ->orderBy($order, $order_type)
            ->get();

        return new GenericPayload($requests, Response::HTTP_OK);
    }
}
