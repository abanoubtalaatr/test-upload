<?php

namespace App\Notification\Actions;
use App\Notification\Domain\Services\GetNotificationService;
use App\Notification\Responders\NotificationResponder;

class GetNotificationAction 
{
    public function __construct(NotificationResponder $responder, GetNotificationService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(['notification_id' => $id])
        )->respond();
    }
}