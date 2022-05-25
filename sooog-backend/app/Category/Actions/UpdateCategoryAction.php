<?php

namespace App\Category\Actions;
use App\Category\Domain\Requests\CategoryRequest;
use App\Category\Domain\Services\UpdateCategoryService;
use App\Category\Responders\CategoryResponder;

class UpdateCategoryAction 
{
    public function __construct(CategoryResponder $responder, UpdateCategoryService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(CategoryRequest $request, $id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(array_merge($request->validated(), ["category_id" => $id]))
        )->respond();
    }
}