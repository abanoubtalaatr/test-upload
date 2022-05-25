<?php

namespace App\Chat\Domain\Resources;

use App\Infrastructure\Domain\Resources\GenericNameResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\User\Domain\Resources\UserLiteResource;

class ChatResource extends JsonResource
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
            'store' => new GenericNameResource($this->store),
            'user' => new UserLiteResource($this->user),
            'messages' => ChatMessageResource::collection($this->messages),
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('d M Y'),
        ];
    }
}
