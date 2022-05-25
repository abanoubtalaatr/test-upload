<?php

namespace App\RequestOfferQuantity\Actions\Api\Store;

use App\RequestOfferQuantity\Domain\Services\Store\DetailsReplyRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\ReplyRequestOfferQuantityResponder;

class DetailsReplyRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(ReplyRequestOfferQuantityResponder $responder, DetailsReplyRequestOfferQuantityService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id)
    {
        $data['id'] = $id;
        return $this->responder->withResponse(
            $this->service->handle($data)
        )->respond();
    }
}
