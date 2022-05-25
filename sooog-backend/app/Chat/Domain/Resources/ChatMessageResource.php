<?php

namespace App\Chat\Domain\Resources;

use App\Infrastructure\Domain\Resources\GenericNameResource;
use App\Store\Domain\Resources\StoreLiteResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\User\Domain\Resources\UserLiteResource;
use Illuminate\Support\Arr;
use Illuminate\Notifications\Notification;
class ChatMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sender'=>$this->sender_type=='store'?new StoreLiteResource($this->sender):new UserLiteResource($this->sender),
            'sender_type'=>$this->sender_type,
            'message'=>$this->message,
            'message_type'=>$this->type,
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y g:i:s a'),
        ];
    }
}
