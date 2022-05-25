<?php

namespace App\RequestOfferQuantity\Actions\Api\User;

use App\RequestOfferQuantity\Domain\Requests\User\RejectReplyRequestOfferQuantityRequest;
use App\RequestOfferQuantity\Domain\Services\User\RejectRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\ReplyRequestOfferQuantityResponder;

class RejectReplyRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(ReplyRequestOfferQuantityResponder $responder, RejectRequestOfferQuantityService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(RejectReplyRequestOfferQuantityRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
