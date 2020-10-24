<?php

namespace App\Http\Middleware;

use Closure;

class AssistantMiddleware
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
        if(auth()->check() && auth()->user()->isAssitant())
        {

            return $next($request);
        }

        return Redirect::back()->withErrors(['No tienes permitido esta área es para asistentes']);
    }
}
