<?php

namespace App\Category\Actions;
use App\Category\Domain\Requests\CategoryRequest;
use App\Category\Domain\Services\ListAllCategoriesService;
use App\Category\Responders\CategoryResponder;

class ListAllCategoriesAction 
{
    public function __construct(CategoryResponder $responder, ListAllCategoriesService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(CategoryRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request)
        )->respond();
    }
}