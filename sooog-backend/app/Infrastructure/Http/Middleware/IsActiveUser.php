<?php

namespace App\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;

class IsActiveUser
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
        if (auth('api')->check() && !auth('api')->user()->is_active ) {
            //dd(auth()->user()->is_active);
           // auth("api")->logout();
            DB::table('device_tokens')->where('tokenable_type', 'App\User\Domain\Models\User')->where('tokenable_id', auth()->id())->delete(); 
            return response()->json([
                  'error' => __('error.blockedUser'),
                  'is_blocked' => true
            ], 403);
        }
        return $next($request);
    }
}
