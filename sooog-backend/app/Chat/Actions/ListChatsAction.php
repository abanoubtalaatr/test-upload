<?php

namespace App\Chat\Actions;
use App\Chat\Domain\Services\ListChatsService;
use App\Chat\Responders\ChatResponder;

class ListChatsAction
{
    public function __construct(ChatResponder $responder, ListChatsService $services)
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
