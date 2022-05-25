<?php

namespace App\RequestOfferQuantity\Actions\Api\User;

use App\RequestOfferQuantity\Domain\Services\User\DetailsRequestOfferQuantityService;
use App\RequestOfferQuantity\Responders\RequestOfferQuantityResponder;

class DetailsRequestOfferQuantityAction
{
    protected $responder = '';
    protected $service = '';

    public function __construct(RequestOfferQuantityResponder $responder, DetailsRequestOfferQuantityService $service)
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
