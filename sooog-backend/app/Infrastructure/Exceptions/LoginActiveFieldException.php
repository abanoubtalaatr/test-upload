<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class LoginActiveFieldException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("LoginActiveFieldException",trans('trans-api.login_inactive_failed'),422);
    }
}
