<?php

namespace App\Category\Actions;
use App\Category\Domain\Requests\CategoryRequest;
use App\Category\Domain\Services\CreateCategoryService;
use App\Category\Responders\CategoryResponder;

class CreateCategoryAction 
{
    public function __construct(CategoryResponder $responder, CreateCategoryService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(CategoryRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}