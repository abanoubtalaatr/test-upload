<?php

namespace App\Category\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Category\Domain\Models\Category;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class DeleteCategoryService extends Service
{
    public function handle($data = []) 
    {
        try {
            $category = Category::findOrFail($data['category_id']);
            if($category->parent_id != null || $category->type == 'centers'){
                if(count($category->products()->get()) > 0)
                    return new GenericPayload(
                         __('error.cannotDelete'), 422
                    ); 
            }else{
                if(count($category->childs()->get()) > 0)
                    return new GenericPayload(
                         __('error.cannotDelete'), 422
                    );
            }
            $category->delete();
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