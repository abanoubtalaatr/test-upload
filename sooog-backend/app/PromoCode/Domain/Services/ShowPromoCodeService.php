<?php

namespace App\PromoCode\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\PromoCode\Domain\Models\PromoCode;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ShowPromoCodeService extends Service
{
    public function handle($data = []) 
    {
        try {
            $promo_code = PromoCode::findOrFail($data['promo_code_id']);
            return new GenericPayload($promo_code, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        

    }
}