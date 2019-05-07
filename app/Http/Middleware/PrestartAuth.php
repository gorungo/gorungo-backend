<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class PrestartAuth
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

        if ($request->getRequestUri() == '/prestart'){
            session(['prestart'=>'prestart']);
        }

        if ($request->getRequestUri() !=='/' && !session()->has('prestart')) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
