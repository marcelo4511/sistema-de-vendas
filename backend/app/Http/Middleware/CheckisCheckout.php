<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckisCheckout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       

        if(Auth::check() && Auth::user()->type_user_id === 2 || Auth::check() && Auth::user()->type_user_id == 1 || Auth::check() && Auth::user()->type_user_id == 3) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Unauthorized'],403);
        }
    }
}
