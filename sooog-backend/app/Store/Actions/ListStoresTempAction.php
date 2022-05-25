<?php

namespace App\Store\Actions;
use App\Store\Domain\Requests\StoreFormRequest;
use App\Store\Domain\Services\ListStoresService;
use App\Store\Domain\Services\ListStoresTempService;
use App\Store\Responders\StoreResponder;
use App\Store\Responders\StoreTempResponder;

class ListStoresTempAction
{
    public function __construct(StoreTempResponder $responder, ListStoresTempService $service)
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
