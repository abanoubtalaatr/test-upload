<?php

namespace App\RequestOfferQuantity\Actions\Api\User;

use App\RequestOfferQuantity\Domain\Requests\User\ListRepliesRequestOfferQuantityRequest;
use App\RequestOfferQuantity\Domain\Services\User\ListRepliesRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\ReplyRequestOfferQuantityResponder;

class ListRepliesRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(ReplyRequestOfferQuantityResponder $responder, ListRepliesRequestOfferQuantityService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(ListRepliesRequestOfferQuantityRequest $request, $id)
    {
        $data = $request->validated();
        $data['id'] = $id;

        return $this->responder->withResponse(
            $this->service->handle($data)
        )->respond();
    }
}

