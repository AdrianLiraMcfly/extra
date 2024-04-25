<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Tema;

class temasIsactive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tema = Tema::find($request->tema);
        if($tema->is_active == 0) {
            return redirect()->route('canales.index')->with('message', 'Tema no encontrado.');
        }
        return $next($request);
    }
}
