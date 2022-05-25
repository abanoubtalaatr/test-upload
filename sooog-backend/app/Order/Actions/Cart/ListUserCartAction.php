<?php

namespace App\Order\Actions\Cart;
use App\Order\Domain\Requests\CartFormRequest;
use App\Order\Domain\Services\Cart\ListUserCartService;
use App\Order\Responders\CartResponder;

class ListUserCartAction 
{
    public function __construct(CartResponder $responder, ListUserCartService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(CartFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request)
        )->respond();
    }
}