<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsActiveAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //dd(auth()->user());
        if (auth()->check() && !auth()->user()->is_active ) {
            //dd(auth()->user()->is_active);
            //auth()->logout();
            return response()->json([
                  'error' => __('error.blockedUser'),
                  'is_blocked' => true
            ], 403);
        }
        return $next($request);
    }
}
