<?php

namespace App\Infrastructure\Http\Middleware;

use App\Infrastructure\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreMiddleware
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

        if (Auth::guard('store')->check() && Auth::guard('store')->user()->store_id == null)
            return response()->json([
                  'error' => __('error.unauthorized')
            ], 403);
        if (Auth::guard('store')->user()->store->type != 'stores')
            return response()->json([
                  'error' => __('error.unauthorized')
            ], 403);

        return $next($request);
    }
}
