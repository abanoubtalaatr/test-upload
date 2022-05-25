<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("ModelNotFoundException",__('exceptions.ModelNotFoundException'),422);
    }
}
