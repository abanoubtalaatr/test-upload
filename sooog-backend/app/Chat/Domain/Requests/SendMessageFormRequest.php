<?php

namespace App\Chat\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class SendMessageFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'message' => ['required', 'min:1', 'string'],
            'store_id' => ['required_without:chat_id', 'exists:stores,id'],
            'chat_id' => ['required_without:store_id', 'exists:chats,id'],
            'type' => ['nullable', 'in:text,pdf,image,video'],
        ];
    }

    public function attributes()
    {
        return [
            'ar.title' => __('general.notifications.ar_title'),
            'en.title' => __('general.notifications.en_title'),
            'ar.body'  => __('general.notifications.ar_body'),
            'en.body'  => __('general.notifications.en_body'),
        ];
    }
}
