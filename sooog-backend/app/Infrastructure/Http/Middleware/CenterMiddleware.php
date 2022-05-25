<?php

namespace App\Infrastructure\Http\Middleware;

use App\Infrastructure\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CenterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (Auth::guard('center')->check() && Auth::guard('center')->user()->store_id == null)
            return response()->json([
                  'error' => __('error.unauthorized')
            ], 403);
        if (Auth::guard('center')->user()->store->type != 'centers')
            return response()->json([
                  'error' => __('error.unauthorized')
            ], 403);

        return $next($request);
    }
}
