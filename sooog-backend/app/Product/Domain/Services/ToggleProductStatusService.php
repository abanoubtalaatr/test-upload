<?php

namespace App\Product\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Product\Domain\Models\Product;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use DB;

class ToggleProductStatusService extends Service
{
    public function handle($data = []) 
    {
        try {
            $product = Product::findOrFail($data['product_id']);
            if($product->is_active == 1){
                if($product->category->type == 'stores' && count($product->orders()->get()) > 0)
                    return new GenericPayload(
                         __('error.cannotDeactivate'), 422
                    );

                if($product->category->type == 'centers' && count($product->serviceOrders()->get()) > 0)
                    return new GenericPayload(
                         __('error.cannotDeactivate'), 422
                    );

                // if(isset($data['deactivation_start_date']) && isset($data['deactivation_end_date'])){
                //     $product->update([
                //         'deactivation_start_date' => $data['deactivation_start_date'],
                //         'deactivation_end_date' => $data['deactivation_end_date'],
                //     ]);
                //     return new GenericPayload($product);
                // }else if($product->deactivation_start_date!==null && $product->deactivation_end_date!== null && $product->deactivation_start_date <= date('Y-m-d') && $product->deactivation_end_date >= date('Y-m-d')){
                //         $product->update([
                //             'is_active' => 1,
                //             'deactivation_start_date' => null,
                //             'deactivation_end_date' => null,
                //         ]);
                //         return new GenericPayload($product, Response::HTTP_CREATED);
                // }

                DB::table('carts')->where('product_id', $data['product_id'])->delete(); 

            }

            $product->update([
                'is_active' => !$product->is_active,
                'deactivation_start_date' => null,
                'deactivation_end_date' => null,
            ]);
            return new GenericPayload($product, Response::HTTP_CREATED);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                ['message' => __('error.someThingWrong')], 422
            );
        }
        

    }
}