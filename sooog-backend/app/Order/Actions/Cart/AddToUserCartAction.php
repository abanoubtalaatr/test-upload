<?php

namespace App\Order\Actions\Cart;
use App\Order\Domain\Requests\AddToUserCartFormRequest;
use App\Order\Domain\Services\Cart\AddToUserCartService;
use App\Order\Responders\CartResponder;

class AddToUserCartAction 
{
    public function __construct(CartResponder $responder, AddToUserCartService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(AddToUserCartFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}