<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class Admin
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
        // TODO Cambiar doctor por admin cuando sea preciso
        if (! auth()->user()->doctor) {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); //error 403
        }
        return $next($request);
    }
}
