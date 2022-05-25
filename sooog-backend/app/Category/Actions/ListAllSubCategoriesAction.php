<?php

namespace App\Category\Actions;

use App\Category\Domain\Services\ListSubCategoriesService;
use App\Category\Responders\CategoryResponder;
use Illuminate\Http\Request;
use App\Category\Domain\Requests\CategoryRequest;
class ListAllSubCategoriesAction 
{
    public function __construct(CategoryResponder $responder, ListSubCategoriesService $services) 
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