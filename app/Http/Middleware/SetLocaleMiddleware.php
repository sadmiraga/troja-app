<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the session has 'locale' and set the app locale
        if (session()->has('locale')) {
            app()->setLocale(session()->get('locale'));
        }
        // Otherwise, check the cookie
        elseif ($request->cookie('locale')) {
            app()->setLocale($request->cookie('locale'));
        }

        return $next($request);
    }
}
