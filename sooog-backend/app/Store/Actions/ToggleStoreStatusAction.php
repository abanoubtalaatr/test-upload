<?php

namespace App\Store\Actions;
use App\Store\Domain\Services\ToggleStoreStatusService;
use App\Store\Responders\StoreResponder;
use App\Store\Domain\Requests\StoreFormRequest;

class ToggleStoreStatusAction 
{
    public function __construct(StoreResponder $responder, ToggleStoreStatusService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke(StoreFormRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(array_merge($request->validated(), ["store_id" => $id]))
        )->respond();
    }
}