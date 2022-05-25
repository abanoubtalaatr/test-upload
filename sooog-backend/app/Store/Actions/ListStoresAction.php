<?php

namespace App\Store\Actions;
use App\Store\Domain\Requests\StoreFormRequest;
use App\Store\Domain\Services\ListStoresService;
use App\Store\Responders\StoreResponder;

class ListStoresAction 
{
    public function __construct(StoreResponder $responder, ListStoresService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(StoreFormRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}