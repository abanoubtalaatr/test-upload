<?php

namespace App\Brand\Actions;
use App\Brand\Domain\Services\ShowBrandService;
use App\Brand\Responders\BrandResponder;

class ShowBrandAction 
{
    public function __construct(BrandResponder $responder, ShowBrandService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke($id) 
    {
        return $this->responder->withResponse(
            $this->services->handle(["brand_id" => $id])
        )->respond();
    }
}