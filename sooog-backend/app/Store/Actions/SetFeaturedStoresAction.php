<?php

namespace App\Store\Actions;

use App\Store\Domain\Requests\SetFeaturedStoresRequest;
use App\Store\Domain\Services\SetFeaturedStoresService;
use App\Store\Responders\StoreResponder;

class SetFeaturedStoresAction
{
    public function __construct(StoreResponder $responder, SetFeaturedStoresService $service)
    {
        $this->responder = $responder;
        $this->service = $service;
    }
    public function __invoke(SetFeaturedStoresRequest $request)
    {
        return $this->responder->withResponse(
            $this->service->handle($request->validated())
        )->respond();
    }
}
