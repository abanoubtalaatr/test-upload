<?php

namespace App\Order\Actions\Cart;
use App\Order\Domain\Services\Cart\DeleteFromCartService;
use App\Order\Responders\CartResponder;
use App\Order\Domain\Requests\CartFormRequest;
class DeleteFromCartAction 
{
    public function __construct(CartResponder $responder, DeleteFromCartService $service) 
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