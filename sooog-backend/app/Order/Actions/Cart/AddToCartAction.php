<?php

namespace App\Order\Actions\Cart;
use App\Order\Domain\Requests\CartFormRequest;
use App\Order\Domain\Services\Cart\AddToCartService;
use App\Order\Responders\CartResponder;

class AddToCartAction 
{
    public function __construct(CartResponder $responder, AddToCartService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(CartFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}