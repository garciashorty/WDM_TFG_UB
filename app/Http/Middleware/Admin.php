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
        if (! optional(auth()->user())->admin) {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); //error 403
        }
        return $next($request);
    }
}
