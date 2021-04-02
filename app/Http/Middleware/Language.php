<?php

namespace App\Http\Middleware;

use Closure, Session, Auth;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $languages = ['en','gr'];
    public function handle($request, Closure $next)
    {
        if(!Session::has('locale'))
        {
            Session::put('locale', $request->getPreferredLanguage($this->languages));
        }

        app()->setLocale(Session::get('locale'));

        if(!Session::has('statut')) 
        {
            Session::put('statut', Auth::check() ?  Auth::user()->role->slug : 'visitor');
        }

        return $next($request);
    
    }
}
