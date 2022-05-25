<?php

namespace App\Order\Domain\Services\Cart;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Order\Domain\Models\Cart;
use Symfony\Component\HttpFoundation\Response;
class DeleteFromCartService extends Service
{
    public function handle($data = []) 
    {
        try {
            if(auth()->check()){
                $cart = auth()->user()->cart->where('id', $data['id'])->first();
            }else{
                $cart = Cart::whereId($data['id'])->whereDeviceId($data['device_id'])->first();
            }
            if(!$cart)
                return new GenericPayload(
                __('error.notFound'), 422
            );
            $cart->delete();
            return new GenericPayload(['message' =>  __('success.deletedSuccessfuly')], Response::HTTP_NO_CONTENT);
            
        } catch (\PDOException $ex){
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