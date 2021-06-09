<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

class LogLastUserActivity
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
        // Checking if http request is coming from logged in user
        if(Auth::check()){

            $id = Auth::user()->id;

            Redis::set('user:'.$id, 1); // set user as online
            Redis::expire('user:'.$id, 120); // expire every 2 minutes

        }
        return $next($request);
    }
}
