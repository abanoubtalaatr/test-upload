<?php

namespace App\RequestOfferQuantity\Actions\Api\Store;

use App\RequestOfferQuantity\Domain\Requests\Store\UpdateReplyRequestOfferQuantityRequest;
use App\RequestOfferQuantity\Domain\Services\Store\UpdateReplyRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\ReplyRequestOfferQuantityResponder;

class UpdateReplyRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(ReplyRequestOfferQuantityResponder $responder, UpdateReplyRequestOfferQuantityService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(UpdateReplyRequestOfferQuantityRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
