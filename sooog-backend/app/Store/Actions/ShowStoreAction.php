<?php

namespace App\Store\Actions;
use App\Store\Domain\Services\ShowStoreService;
use App\Store\Responders\StoreResponder;

class ShowStoreAction 
{
    public function __construct(StoreResponder $responder, ShowStoreService $service) 
    {
        $this->responder = $responder;
        $this->service = $service;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->service->handle(["store_id" => $id])
        )->respond();
    }
}