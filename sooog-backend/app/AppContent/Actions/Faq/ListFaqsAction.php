<?php

namespace App\AppContent\Actions\API;

use App\AppContent\Domain\Services\API\ListFaqsService;
use App\AppContent\Responders\API\ListFaqsResponder;

class ListFaqsAction 
{
    public function __construct(ListFaqsResponder $responder, ListFaqsService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke() 
    {
        return $this->responder->withResponse(
            $this->services->handle()
        )->respond();
    }
}