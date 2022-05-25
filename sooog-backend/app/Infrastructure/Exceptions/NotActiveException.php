<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class NotActiveException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("ActiveFailedException",trans('trans-api.active_failed'),422);
    }
}
