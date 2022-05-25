<?php

namespace App\RequestOfferQuantity\Actions\Api\Store;

use App\RequestOfferQuantity\Domain\Requests\Store\ListRequestOfferQuantityRequest;
use App\RequestOfferQuantity\Domain\Services\Store\ListRepliesForRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\ReplyRequestOfferQuantityResponder;

class ListRepliesForRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(ReplyRequestOfferQuantityResponder $responder, ListRepliesForRequestOfferQuantityService $service)
    {

        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ListRequestOfferQuantityRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
