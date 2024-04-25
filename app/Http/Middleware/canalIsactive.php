<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Canal;

class canalIsactive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $canalid=$request->route('canal');
        $canal = Canal::find($canalid);
        if($canal->is_active == 0) {
            return redirect()->route('canales.index')->with('message', 'Canal no encontrado.');
        }
        return $next($request);
    }
}
