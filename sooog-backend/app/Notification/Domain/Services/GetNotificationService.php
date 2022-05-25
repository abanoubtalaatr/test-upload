<?php

namespace App\Notification\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Notification\Domain\Models\Notification;
use Symfony\Component\HttpFoundation\Response;

class GetNotificationService extends Service
{
    public function handle($data = []) 
    {
        try{
            $notification = Notification::findOrFail($data['notification_id']);
            return new GenericPayload($notification, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }
    }
}