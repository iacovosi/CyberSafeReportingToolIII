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

            // Creating namespace for Redis
            $id = Auth::user()->id;
            $browser = $request->server('HTTP_USER_AGENT');
            $namespace = 'users:'.$id.$browser;

            // Refreshing the expiration of logged user
            $expire = config('session.lifetime') * 60;
            Redis::EXPIRE($namespace,$expire);
        }
        return $next($request);
    }
}
