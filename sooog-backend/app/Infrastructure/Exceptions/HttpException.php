<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class HttpException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("HttpException",__('exceptions.HttpException'),503);
    }
}
