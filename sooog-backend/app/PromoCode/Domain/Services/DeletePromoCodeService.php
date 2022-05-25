<?php

namespace App\PromoCode\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\PromoCode\Domain\Models\PromoCode;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeletePromoCodeService extends Service
{
    public function handle($data = []) 
    {
        try {
            $promo_code = PromoCode::findOrFail($data['promo_code_id']);
            if(count($promo_code->orders()->get()) > 0)
        		return new GenericPayload(
                    __('error.cannotDelete'), 422
                );
            //$promo_code->users()->delete();

            if(auth()->guard('store')->check() && $promo_code->created_by != 'store'){
                return new GenericPayload( __('error.cannotDelete'), 422);
            }
            $promo_code->delete();
            return new GenericPayload(['message' => __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);

            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        
    }
}