<?php

namespace App\Notification\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Notification\Domain\Notifications\GeneralNotification;
use App\User\Domain\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Notifications\Notification;
use Symfony\Component\HttpFoundation\Response;

class SendNotificationService extends Service
{
    public function handle($data = []) 
    {
        try {
            $locale = app()->getLocale();
            send_fcm_notification(
                null, 
                [
                    "title" => $data[$locale]['title'],
                    "body"  => $data[$locale]['body'], 
                    "type"  => 'dashboard'
                ]
            );
            $users = \App\User\Domain\Models\User::whereIsActive(1)->get();
            if(count($users) > 0){
                foreach ($users as $user) {
                    $user->notify(new GeneralNotification(
                        array_merge($data,[
                            "type"  => 'dashboard'
                        ])
                    ));
                }
            }
            
            return new GenericPayload(['message' => __('success.sentSuccessfully')], Response::HTTP_RESET_CONTENT);
        } catch (Exception $ex) {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }
    }
}