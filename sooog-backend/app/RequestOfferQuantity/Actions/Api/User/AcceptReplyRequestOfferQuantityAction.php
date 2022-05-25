<?php

namespace App\RequestOfferQuantity\Actions\Api\User;

use App\RequestOfferQuantity\Domain\Requests\User\AcceptReplyRequestOfferQuantityRequest;
use App\RequestOfferQuantity\Domain\Services\User\AcceptReplyRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\ReplyRequestOfferQuantityResponder;

class AcceptReplyRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(ReplyRequestOfferQuantityResponder $responder, AcceptReplyRequestOfferQuantityService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(AcceptReplyRequestOfferQuantityRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
