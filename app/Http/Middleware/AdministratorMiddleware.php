<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;

class AdministratorMiddleware
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
        if(auth()->check() && auth()->user()->isAdministrator())
        {

            return $next($request);
        }

        return Redirect::back()->withErrors(['No tienes permitido esta área es para administradores']);
        
    }
}
