<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class LoginFailedException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("LoginFailedException",trans('auth.failed'),422);
    }
}
