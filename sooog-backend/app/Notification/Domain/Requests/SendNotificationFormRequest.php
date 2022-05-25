<?php

namespace App\Notification\Domain\Requests;

use App\Infrastructure\Http\Requests\API\CustomApiRequest;

class SendNotificationFormRequest extends CustomApiRequest
{
    public function rules()
    {
        return [
            'ar.title' => ['required', 'min:1', 'max:255', 'string'],
            'en.title' => ['required', 'min:1', 'max:255', 'string'],
            'ar.body' => ['required', 'string','min:1', 'max:1000'],
            'en.body' => ['required', 'string','min:1', 'max:1000'],
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
