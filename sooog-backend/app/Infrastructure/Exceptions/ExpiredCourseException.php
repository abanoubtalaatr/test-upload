<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class ExpiredCourseException extends Exception
{
    use ExceptionTrait;

    public function render()
    {
    	return $this->renderException("ExpiredCourseException",trans('exceptions.ExpiredCourseException'),422);
    }
}
