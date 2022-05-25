<?php

namespace App\Notification\Actions;
use App\Notification\Domain\Services\ListNotificationsService;
use App\Notification\Responders\NotificationResponder;

class ListNotificationsAction 
{
    public function __construct(NotificationResponder $responder, ListNotificationsService $services) 
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
