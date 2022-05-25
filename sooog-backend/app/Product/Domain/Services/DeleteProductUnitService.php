<?php

namespace App\Product\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Product\Domain\Models\ProductUnit;
use Symfony\Component\HttpFoundation\Response;
use DB;

class DeleteProductUnitService extends Service
{
    public function handle($data = []) 
    {
        try {
            $product = ProductUnit::findOrFail($data['product_unit_id']);
             if(count($product->orderItems()->get()) > 0)
        		 return new GenericPayload(
                     __('error.cannotDelete'), 422
                 );
            $product->delete();
            DB::table('carts')->where('unit_id', $data['product_unit_id'])->delete();
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
