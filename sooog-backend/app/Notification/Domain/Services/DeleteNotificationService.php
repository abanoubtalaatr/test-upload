<?php

namespace App\Notification\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Notification\Domain\Models\Notification;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DeleteNotificationService extends Service
{
    public function handle($data = []) 
    {
        try{
            if($notification = Notification::findOrFail($data['notification_id'])){
                $title = isset($notification->data["en"]) ? $notification->data["en"]["title"] : null ;
                $body = isset($notification->data["en"]) ? $notification->data["en"]["body"] : null ;
                $notifications = Notification::where('type', $notification->type)
                ->where('data->en->title', $title)
                ->where('data->en->body', $body)
                ->get();
                
                foreach ($notifications as $notif) {
                    $notif->delete();
                }
                //$notification->delete();
//                $all = Notification::where(['type' => $notification->type, 'data' => $notification->data])->delete();
                return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }
    }
}
