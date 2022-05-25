<?php

namespace App\Product\Actions\Favourite;
use App\Product\Domain\Requests\FavouriteFormRequest;
use App\Product\Domain\Services\Favourite\ListUserFavouritesService;
use App\Product\Responders\ProductResponder;

class ListUserFavouritesAction 
{
    public function __construct(ProductResponder $responder, ListUserFavouritesService $services) 
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