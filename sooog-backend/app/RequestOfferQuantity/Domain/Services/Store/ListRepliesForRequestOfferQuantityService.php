<?php

namespace App\RequestOfferQuantity\Domain\Services\Store;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use Symfony\Component\HttpFoundation\Response;
use function config;

class ListRepliesForRequestOfferQuantityService extends Service
{
    public function handle($data = []): GenericPayload
    {
        $order = $data['orderBy'] ?? 'request_offer_quantity_id';
        $order_type = $data['orderType'] ?? 'DESC';

        $filter = $data['filter'] ?? 'Replied';
        $limit = $data['per_page'] ?? config('app.pagination_limit');


        if (isset($data['is_paginated']) && $data['is_paginated'] == 1) {

            $replies = ReplyRequestOfferQuantity::where('store_id', auth()->guard('store')->user()->store->id)
                ->when($filter=='finished' || $filter =='Finished', function ($q){
                    $q->whereHas('requestOfferQuantity', function ($query){
                        $query->where('status', 'Finished');
                    });
                })
                ->when($filter != 'finished' || $filter !='Finished', function ($q) use($filter){
                    $q->where('status', $filter);
                })
                ->orderBy($order, $order_type)
                ->paginate($limit);

            return new GenericPayload($replies, Response::HTTP_ACCEPTED);
        }

        $replies = ReplyRequestOfferQuantity::where('store_id', auth()->guard('store')->user()->store->id)
            ->when($filter=='finished' || $filter =='Finished', function ($q){
                $q->whereHas('requestOfferQuantity', function ($query){
                    $query->where('status', 'Finished');
                });
            })
            ->when($filter != 'finished' || $filter !='Finished', function ($q) use($filter){
                $q->where('status', $filter);
            })->
            get();

        return new GenericPayload($replies, Response::HTTP_OK);
    }
}
