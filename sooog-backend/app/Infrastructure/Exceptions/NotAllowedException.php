<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class NotAllowedException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("NotAllowedException",trans('trans-api.not_allowed_exception'),422);
    }
}
