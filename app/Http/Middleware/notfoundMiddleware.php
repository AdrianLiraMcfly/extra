<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class notfoundMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            Route::getRoutes()->match($request);
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return redirect()->route('canales.index');
        } catch (\Exception $e) {
            return redirect()->route('canales.index');
        }

        return $next($request);
    }
}
