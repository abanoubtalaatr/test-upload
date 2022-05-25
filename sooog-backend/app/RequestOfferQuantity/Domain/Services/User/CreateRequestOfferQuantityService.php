<?php

namespace App\RequestOfferQuantity\Domain\Services\User;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Helpers\Traits\UploaderHelper;
use App\Product\Domain\Models\Product;
use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class CreateRequestOfferQuantityService extends Service
{
    use UploaderHelper;

    public function handle($data = []): GenericPayload
    {
        try {
            $data = Arr::add($data, 'user_id', auth()->id());
            $data = Arr::add($data, 'image', $this->handleUploadImg($data['image'], 'request/offer'));

            $requestOffer = RequestOfferQuantity::create($data);

            return new GenericPayload($requestOffer, Response::HTTP_CREATED);
        } catch (\PDOException $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
    }
}
