<?php

namespace App\Notification\Actions;
use App\Notification\Domain\Services\DeleteNotificationService;
use App\Notification\Responders\NotificationResponder;

class DeleteNotificationAction
{
    public function __construct(NotificationResponder $responder, DeleteNotificationService $services)
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
