<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class QueryException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("QueryException",__('exceptions.QueryException'),422);
    }
}
