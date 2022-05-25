<?php

namespace App\Store\Actions;
use App\Store\Domain\Services\ShowStoreTempService;
use App\Store\Responders\StoreTempResponder;

class ShowStoreTempAction
{
    public function __construct(StoreTempResponder $responder, ShowStoreTempService $service)
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
