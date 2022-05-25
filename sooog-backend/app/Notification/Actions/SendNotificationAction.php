<?php

namespace App\Notification\Actions;
use App\Notification\Domain\Requests\SendNotificationFormRequest;
use App\Notification\Domain\Services\SendNotificationService;
use App\Notification\Responders\NotificationResponder;

class SendNotificationAction 
{
    public function __construct(NotificationResponder $responder, SendNotificationService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(SendNotificationFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}