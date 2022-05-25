<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    use ExceptionTrait;
    public function render(){
    	return $this->renderException("UserNotFoundException",__('exceptions.UserNotFoundException'),404);
    }
}
