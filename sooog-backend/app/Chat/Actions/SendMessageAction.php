<?php

namespace App\Chat\Actions;
use App\Chat\Domain\Requests\SendMessageFormRequest;
use App\Chat\Domain\Services\SendMessageService;
use App\Chat\Responders\ChatResponder;

class SendMessageAction
{
    public function __construct(ChatResponder $responder, SendMessageService $services)
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(SendMessageFormRequest $request)
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}
