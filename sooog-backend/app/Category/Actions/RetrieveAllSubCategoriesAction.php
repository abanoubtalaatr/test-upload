<?php

namespace App\Category\Actions;

use App\Category\Domain\Services\ListAllSubCategoriesService;
use App\Category\Responders\CategoryResponder;
use Illuminate\Http\Request;
use App\Category\Domain\Requests\CategoryRequest;
class RetrieveAllSubCategoriesAction 
{
    public function __construct(CategoryResponder $responder, ListAllSubCategoriesService $services) 
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