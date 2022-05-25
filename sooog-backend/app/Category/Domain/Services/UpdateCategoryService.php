<?php

namespace App\Category\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Category\Domain\Models\Category;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class UpdateCategoryService extends Service
{
    public function handle($data = []) 
    {
        try {
            $category = Category::findOrFail($data['category_id']);
            // if($category->is_active == 1){
            //     if($category->parent_id != null){
            //         if(count($category->products()->get()) > 0)
            //             return new GenericPayload(
            //                  __('error.cannotDeactivate'), 422
            //             ); 
            //     }else{
            //         if(count($category->childs()->get()) > 0)
            //             return new GenericPayload(
            //                  __('error.cannotDeactivate'), 422
            //             );
            //     }
            // }
            $category->update($data);
            if(isset($data['tax_percentage'])){
                foreach($category->products()->get() as $product){
                    $tax = $product->price * $category->tax_percentage / 100;
                    $product->update([
                        'price_including_tax' => $product->price + $tax
                    ]);
                }
            }
            return new GenericPayload($category, Response::HTTP_CREATED);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            throw new ModelNotFoundException;
        } catch (Exception $ex) {
            return new GenericPayload(
                __('error.someThingWrong'), 422
            );
        }
        

    }
}