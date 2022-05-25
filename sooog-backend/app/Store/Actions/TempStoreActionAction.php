<?php

namespace App\Store\Actions;
use App\Store\Domain\Requests\TemStoreActionRequest;
use App\Store\Domain\Services\TempStoreActionService;
use App\Store\Responders\StoreResponder;

class TempStoreActionAction
{
    public function __construct(StoreResponder $responder, TempStoreActionService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(TemStoreActionRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
