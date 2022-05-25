<?php

namespace App\Chat\Domain\Services;

use App\Admin\Domain\Models\Admin;
use App\Chat\Domain\Models\Chat;
use App\Chat\Domain\Resources\ChatMessageResource;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Notification\Domain\Notifications\ChatNotification;
use App\Notification\Domain\Notifications\GeneralNotification;
use App\User\Domain\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\HttpFoundation\Response;

class SendMessageService extends Service
{
    public function handle($data = [])
    {
        try {
            if (auth('api')->check()) {
                DB::beginTransaction();
                if (isset($data['store_id'])) {
                    if(!Chat::where(['store_id'=>$data['store_id'],'user_id'=>auth()->id()])->first()){
                        $chat=Chat::create(['store_id'=>$data['store_id'],'user_id'=>auth()->id()]);
                        $members[]=[
                            'user_id'=>auth()->id(),
                            'user_type'=>'user',
                        ];
                        foreach (Admin::where('store_id',$data['store_id'])->where('is_active',1)->get() as $admin){
                            array_push($members,['user_id'=>$admin->id,'user_type'=>'store']);
                        }
                        $chat->members()->createMany($members);
                    }else{
                        $chat=Chat::where(['store_id'=>$data['store_id'],'user_id'=>auth()->id()])->first();
                    }
                }else{
                    $chat=Chat::findOrFail($data['chat_id']);
                }
                $message=$chat->messages()->create([
                    'sender_id'=>auth()->id(),
                    'sender_type'=>'user',
                    'message'=>$data['message'],
                    'type'=>$data['type']??null,
                ]);
                DB::commit();
                $notifyMemberId=$chat->members()->where('user_id','!=',auth()->id())->where('user_type','store')->get()->pluck('user_id')->toArray();
                $notifyMember=Admin::where('is_active',1)->whereIn('id',$notifyMemberId)->get();
                $notifyArr=[
                    'ar' => [ 'title'=>auth()->user()->name, 'body'=>$data['message']],
                    'en' => [ 'title'=>auth()->user()->name, 'body'=>$data['message']],
                    'title'=>auth()->user()->name,
                    'body'=>$data['message'],
                    'message_type'=>$data['type'],
                    'message'=>new ChatMessageResource($message),
                    'image'=>auth()->user()->avatar,
                    'model_id' => $message->id,
                    'chat_id' => $chat->id,
                    'type' => 'chat',
                ];
                send_fcm_notification(null,$notifyArr,true,$notifyMemberId);

            }elseif (auth('store')->check()){
                DB::beginTransaction();
                $chat=Chat::findOrFail($data['chat_id']);
                $message=$chat->messages()->create([
                    'sender_id'=>auth('store')->id(),
                    'sender_type'=>'store',
                    'message'=>$data['message'],
                    'type'=>$data['type']??null,
                ]);
                DB::commit();
                $notifyMemberId=$chat->members()->where('user_id','!=',auth('store')->id())->where('user_type','user')->get()->pluck('user_id')->toArray();
                $notifyMember=$chat->members()->where('user_id','!=',auth('store')->id())->where('user_type','user')->first()->user;
                $notifyArr=[
                    'ar' => [ 'title'=>auth('store')->user()->store->name, 'body'=>$data['message']],
                    'en' => [ 'title'=>auth('store')->user()->store->name, 'body'=>$data['message']],
                    'title'=>auth('store')->user()->store->name,
                    'body'=>$data['message'],
                    'message_type'=>$data['type'],
                    'message'=>new ChatMessageResource($message),
                    'image'=>auth('store')->user()->image,
                    'model_id' => $message->id,
                    'chat_id' => $chat->id,
                    'type' => 'chat',
                ];
                send_fcm_notification($notifyMember,$notifyArr);
//                Notification::send($notifyMember,new ChatNotification($notifyArr));
            }
            Notification::send($notifyMember,new ChatNotification($notifyArr));
            return new GenericPayload(['message' => __('success.sentSuccessfully')], Response::HTTP_RESET_CONTENT);
        } catch (Exception $ex) {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }
    }
}
