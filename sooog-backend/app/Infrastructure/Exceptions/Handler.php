<?php

namespace App\Infrastructure\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    use ExceptionTrait;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {

        $this->reportable(function (Throwable $e){

        });

        $this->renderable(function (Throwable $e, $request) {
            return $this->handleException($e, $request);
        });

        // $this->renderable(function (Throwable $e, $request) {
        //     return $this->handleException($e, $request);
        // });
        // $this->renderable(function(Exception $e, $request) {
        //     return $this->apiException($request, $e);
        // });

        // $this->renderable(function (\Illuminate\Foundation\Http\Exceptions\MaintenanceModeException $ex, $request) {
        //     if ($request->expectsJson()) {
        //        return response()->json([
        //                   'error' => 'unavailable service'
        //             ], 503);
        //     }
        // });

        // $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $ex, $request) {
        //     if ($request->expectsJson()) {
        //        return response()->json([
        //                   'error' => 'unauthorized'
        //             ], 403);
        //     }
        // });
    }


        /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (in_array('admin', $exception->guards())) {
            return $request->expectsJson()
                ? response()->json([
                      'error' => $exception->getMessage()
                ], 401)
                : redirect()->guest(route('admin.login'));
        }

        return $request->expectsJson()
            ? response()->json([
                  'error' => $exception->getMessage()
            ], 401)
            : redirect()->guest(route('login'));
    }

    public function handleException( Throwable $exception , $request){

        if ($exception instanceof \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException) {
            if ($request->expectsJson()) {
               return response()->json([
                          'error' => 'unavailable service'
                    ], 503);
            }
        } else if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            if ($request->expectsJson()) {
               return response()->json([
                          'error' => __('error.unauthorized')
                    ], 403);
            }
        }else if ($exception instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
            if ($request->expectsJson()) {
               return response()->json([
                          'error' => __('error.unauthorized')
                    ], 403);
            }

        } else if ($exception instanceof \Illuminate\Auth\AuthenticationException){
            if ($request->expectsJson()) {
               return response()->json([
                          'error' => __('error.unauthorized')
                    ], 403);
            }
        }else if ($exception instanceof \Intervention\Image\Exception\NotSupportedException){
            if ($request->expectsJson()) {
               return response()->json([
                          'error' => __('error.NotSupportedException')
                    ], 422);
            }
        }else {
            dd($exception);
            if (config('app.debug')){
                $msg = $exception->getMessage();
            }else{
                $msg = 'Try later';
            }

            if ($request->expectsJson()) {
               return response()->json([
                          'error' => $msg
                    ], 422);
            }
        }
}

}
