<?php
namespace App\Infrastructure\Exceptions;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait ExceptionTrait{

        /**
        * Render exception as HTTP response json object
        * @param  \Illuminate\Http\Request  $request
        * @param  \Exception  $exception
        * @return \Illuminate\Http\Response
        */

	public function apiException($request,Exception $exception){

        /** Handle ModelNotFoundException */
	if($exception instanceof ModelNotFoundException){
		return $this->renderException('ModelNotFoundException',$exception->getMessage(),Response::HTTP_NOT_FOUND);
        }

        /** Handle NotFoundHttpException */
        if ($exception instanceof NotFoundHttpException) {
        	return $this->renderException('NotFoundHttpException',"Route Found",Response::HTTP_NOT_FOUND);
        }

        /** Handle AuthenticationException */
        if($exception instanceof AuthenticationException) {
        	return $this->renderException('AuthenticationException','Unauthorized Action',Response::HTTP_UNAUTHORIZED);
        }

        /** Handle UnauthorizedException */
        // if($exception instanceof UnauthorizedException) {
        //         return $this->renderException('UnauthorizedException',$exception->getMessage(),$exception->getStatusCode());
        // }

        /** Handle QueryException */
        if($exception instanceof QueryException){
                return $this->renderException('QueryException',$exception->getMessage(),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /** Handle MethodNotAllowedHttpException */
        if($exception instanceof MethodNotAllowedHttpException){
                return $this->renderException('MethodNotAllowedHttpException',"Method Not Allowed Http",Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        /** Handle ValidationException */
        if($exception instanceof  ValidationException){

        	/** Start convert validation errors array to string. */
        	$errors = [];
        	if(count($exception->errors())){
        		foreach ($exception->errors() as $field => $err) {
        			if(count($err)){
        				foreach ($err as $key => $value) {
        					$errors[] = $value;
        				}
        			}
        		}
        	}
        	$errorsString = implode('', $errors);
        	/** End*/

        	return $this->renderException(' ValidationException',$errorsString,Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($exception instanceof \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException) {
            return $this->renderException('MaintenanceModeException',"Maintenance Mode", 503);
        }

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
        return response()->json([
                'responseMessage' => 'You do not have the required authorization.',
                'responseStatus'  => 403,
            ], 403);
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
        return response()->json([
                'responseMessage' => 'You do not have the required authorization.',
                'responseStatus'  => 403,
            ], 403);
        }

        return parent::render($request, $exception);
	}

	/**
	* Render Exception as json object
	* @param $exceptionName,$exceptionMessage,$statusCode
	* @return \Illuminate\Http\Response
	*/
	public function renderException($exceptionName,$exceptionMessage,$statusCode)
	{
		// $exceptionJson['statusCode'] = $statusCode;
		// $exceptionJson['errors']['name'] = $exceptionName;
        // $exceptionJson['errors']['message'] = $exceptionMessage;

        if($exceptionName == 'ActiveFailedException')

            $exceptionJson['is_active'] = false;

        $exceptionJson['error'] = $exceptionMessage;

		return response()->json($exceptionJson,$statusCode);
	}
}
