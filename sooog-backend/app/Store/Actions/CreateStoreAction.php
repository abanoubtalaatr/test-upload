<?php

namespace App\Store\Actions;

use App\Store\Domain\Requests\StoreFormRequest;
use App\Store\Domain\Services\CreateStoreService;
use App\Store\Responders\StoreResponder;

class CreateStoreAction
{
    public function __construct(StoreResponder $responder, CreateStoreService $service)
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
