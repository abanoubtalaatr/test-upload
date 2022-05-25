<?php

namespace App\Brand\Actions;
use App\Brand\Domain\Services\DeleteBrandService;
use App\Brand\Responders\BrandResponder;

class DeleteBrandAction 
{
    public function __construct(BrandResponder $responder, DeleteBrandService $services) 
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