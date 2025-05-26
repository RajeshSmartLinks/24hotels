<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class ApplicationCurrency
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
        //Set Currency
        
        // App::setLocale(session('currency') ? session('currency') : Config::get('app.currency'));
        // dd(session('currency'));
         $currency = session('currency') ? session('currency') : Config::get('app.currency');
        Config::set('app.currency' , $currency);

        return $next($request);
    }
}
