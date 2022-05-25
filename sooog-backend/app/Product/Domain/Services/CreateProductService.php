<?php

namespace App\Product\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Product\Domain\Models\Product;
use App\Property\Domain\Models\Property;
use App\Category\Domain\Models\Category;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Infrastructure\Exceptions\ModelNotFoundException;

class CreateProductService extends Service
{
    public function handle($data = []) 
    {
        try {
	        // Begin Transaction
	        DB::beginTransaction();
            $data['key'] = rand(111111,99999).time();
            $data['created_by'] = auth()->id();
            $data['store_id'] = auth()->user()->store_id ? : $data['store_id'];
            if(auth()->guard('store')->check()){
                $products_count=Product::where('store_id',auth('store')->id())->count();
                if($package=auth('store')->store()->activePackage){
                    if($products_count >= $package->product_number){
                        return new GenericPayload(__('error.reach_product_number'), 422);
                    }
                }
            }
            if(!isset($data['store_id']))
                return new GenericPayload(__('error.requiredStore'), 422);
            
            $category = Category::findOrFail($data['category_id']);
            if(!$category->parent && $category->type == 'stores')
                return new GenericPayload(__('error.requiredSubCategory'), 422);

            if($category->type == 'stores'){
                $properties = $category->parent->properties()->where('is_required', 1)->get();
                if(count($properties) > 0 && !isset($data['properties']))
                    return new GenericPayload(__('error.requiredProperties'), 422);
            }
	        $product = Product::create($data);
            $units=[];
            if(isset($data['units'])){
                foreach ($data['units'] as $key=>$unit){
                    array_push($units,$unit);
                }
                $product->units()->createMany($units);
            }

	        if(isset($data['attachments'])){
	        	//$product->attachments()->createMany($data['attachments']);
                $attachments = [];
                foreach ($data['attachments'] as $attachment) {
                    array_push($attachments, 
                        array_merge($attachment, 
                        [
                            'attachable_id' => $product->id,
                            'attachable_type' => 'App\Product\Domain\Models\Product'
                        ])
                    );
                }
                auth()->user()->attachments()->createMany($attachments);
            }

            if(isset($data['properties']))
                    $this->saveProperties($product, $data['properties']);

	        // Commit Transaction
	        DB::commit();
	        return new GenericPayload($product, Response::HTTP_CREATED);
	        
	    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            // Rollback Transaction
            DB::rollback();
            throw new ModelNotFoundException;
        } catch (\Illuminate\Database\QueryException $ex) {
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
               $ex->getMessage(), 422
            );
        } catch (\PDOException $ex){
            // Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        } catch (\Exception $ex) {
        	// Rollback Transaction
            DB::rollback();
            return new GenericPayload(
                $ex->getMessage(), 422
            );
        }

    }

    private function saveProperties($product, $properties){
        $properties_arr = [];
        foreach ($properties as $property) {
            if(isset($property['value']) && $property['value'] != ''){
                $prop = Property::whereId($property['property_id'])->firstOrFail();
                $property['property_option_id'] = null;
                if($prop->propertyType->has_options == 1){
                    $option = \App\Property\Domain\Models\PropertyOption::findOrFail($property['value']);
                    $property['property_option_id'] = $option->id;
                    $property['value'] = null;
                }
                array_push($properties_arr, [
                    'property_id' => $property['property_id'], 
                    'value' => $property['value'], 
                    'property_option_id' => $property['property_option_id']
                ]);
            }
        }
        //dd($properties_arr);
        $product->properties()->sync($properties_arr);
    }
}
