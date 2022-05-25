<?php

namespace App\Chat\Actions;
use App\Chat\Domain\Services\GetChatService;
use App\Chat\Responders\ChatResponder;

class GetChatAction
{
    public function __construct(ChatResponder $responder, GetChatService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(['chat_id' => $id])
        )->respond();
    }
}
