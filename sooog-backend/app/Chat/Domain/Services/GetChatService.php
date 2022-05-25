<?php

namespace App\Chat\Domain\Services;

use App\Chat\Domain\Models\Chat;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Notification\Domain\Models\Notification;
use Symfony\Component\HttpFoundation\Response;

class GetChatService extends Service
{
    public function handle($data = []) 
    {
        try{
            $user=auth('api')->check()?auth('api')->id():null;
            $store=auth()->guard('store')->check()?auth('store')->user()->store_id:null;
            $chat = Chat::with('messages','user','store')
                ->when($user,function ($q) use ($user){
                    return $q->where('user_id',$user);
                })
                ->when($store,function ($qu) use ($store){
                    return $qu->where('store_id',$store);
                })
                ->findOrFail($data['chat_id']);
            return new GenericPayload($chat, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }
    }
}
