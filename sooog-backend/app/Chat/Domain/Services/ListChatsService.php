<?php

namespace App\Chat\Domain\Services;

use App\Chat\Domain\Models\Chat;
use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use Symfony\Component\HttpFoundation\Response;

class ListChatsService extends Service
{
    public function handle($data = [])
    {
        if (auth('store')->check()) {
            $user = auth('store')->user()->store_id;
            $query = Chat::with(['user', 'store', 'members', 'messages'=>function($q){
                $q->orderBy('id','desc');
            }])->where('store_id', $user)->latest();
        } elseif (auth()->check()) {
            $user = auth()->id();
            $query =Chat::with(['user', 'store', 'members', 'messages'=>function($q){
                $q->orderBy('id','desc');
            }])->where('user_id', $user)->latest();
        }

        $notifications = $query->paginate(10);

        return new GenericPayload($notifications, Response::HTTP_ACCEPTED);
    }
}
