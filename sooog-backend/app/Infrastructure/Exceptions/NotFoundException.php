<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("NotFoundException",trans('trans-api.item_not_found'),404);
    }
}
