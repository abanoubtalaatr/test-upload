<?php

namespace App\Product\Actions\Favourite;

use App\Product\Domain\Requests\FavouriteFormRequest;
use App\Product\Domain\Services\Favourite\AddProductToFavouriteService;
use App\Product\Responders\ProductResponder;

class AddProductToFavouriteAction 
{
    public function __construct(ProductResponder $responder, AddProductToFavouriteService $services) 
    {
        $this->responder = $responder;
        $this->services = $services;
    }

    public function __invoke(FavouriteFormRequest $request) 
    {
        return $this->responder->withResponse(
            $this->services->handle($request->validated())
        )->respond();
    }
}