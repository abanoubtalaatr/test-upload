<?php

namespace App\Order\Actions\Cart;
use App\Order\Domain\Requests\CartFormRequest;
use App\Order\Domain\Services\Cart\UpdateCartService;
use App\Order\Responders\CartResponder;

class UpdateCartAction 
{
    public function __construct(CartResponder $responder, UpdateCartService $service) 
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