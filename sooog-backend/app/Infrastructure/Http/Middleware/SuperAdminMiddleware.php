<?php

namespace App\Infrastructure\Http\Middleware;

use App\Infrastructure\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
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
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->store_id != null) {
            return response()->json([
                  'error' => __('error.unauthorized')
            ], 403);
        }
        return $next($request);
    }
}
