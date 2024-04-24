<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActiveMiddleware
{
    /**
     * Handle an incoming HTTP request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()){
            if (auth()->user()->is_active == 0){
                auth()->logout();
                return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada');
            }
        }
        return $next($request);
    }
}
