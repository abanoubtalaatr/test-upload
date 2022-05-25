<?php

namespace App\Notification\Domain\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User\Domain\Resources\UserLiteResource;
use Illuminate\Support\Arr;
use Illuminate\Notifications\Notification;
class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //$order_type = explode("\\", $this->type);
        $user_type = explode("\\", $this->notifiable_type);
        $content = $this->data;
        $locale = app()->getLocale();
        $title = isset($content["{$locale}"]) ? $content["{$locale}"]["title"] : null ;
        $body = isset($content["{$locale}"]) ? $content["{$locale}"]["body"] : null ;
        return [
            'id' => $this->id,
            'target' => end($user_type),
            'data' => array_merge(Arr::except($this->data, ['title', 'body']), [
                'title' => $title,
                'body' => $body
            ]),
            'user' => new UserLiteResource($this->notifiable),
            //'data' => Arr::except($this->data, ['title', 'body']),
            //'notif_type' => end($order_type),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
        ];
    }
}
