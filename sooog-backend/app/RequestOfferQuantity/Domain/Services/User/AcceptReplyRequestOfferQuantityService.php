<?php

namespace App\RequestOfferQuantity\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Notification\Domain\Notifications\RequestOfferQuantityStoreNotification;
use App\RequestOfferQuantity\Domain\Models\ReplyRequestOfferQuantity;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use App\Store\Domain\Models\Store;
use Symfony\Component\HttpFoundation\Response;

class AcceptReplyRequestOfferQuantityService extends Service
{

    public function handle($data = []): GenericPayload
    {
        $reply = ReplyRequestOfferQuantity::find($data['reply_request_offer_quantity_id']);

        $reply->update(
            [
                'status' => 'Accepted',
                'notes' => $data['notes']
            ]);

        $requestOfferQuantity = RequestOfferQuantity::findOrFail($reply->request_offer_quantity_id);

        $requestOfferQuantity->update([
            'status' => 'Finished',
        ]);

        Store::findOrFail($reply->store_id)
            ->admins
            ->map(function ($admin) use ($requestOfferQuantity) {

                $notif_data = array(
                    'ar' => ['title' => 'طلب التسعير الخاص بك تم قبوله', 'body' => 'تم الموافقه علي هذا العرض ' . $requestOfferQuantity->id],
                    'en' => ['title' => 'Your Request offer is accepted', 'body' => 'Request No.' . $requestOfferQuantity->id . 'has been accepted'],
                );

                $admin->notify(new RequestOfferQuantityStoreNotification($requestOfferQuantity, $notif_data));

                send_fcm_notification(
                    $admin,
                    [
                        "title" => __('general.request_offer_quantity.accepted'),
                        "body" => __('general.request_offer_quantity.accepted'),
                        "type" => 'request_offer_quantity',
                        "model_id" => $requestOfferQuantity->id
                    ],
                    true
                );
            });

        return new GenericPayload($reply, Response::HTTP_PARTIAL_CONTENT);
    }
}
