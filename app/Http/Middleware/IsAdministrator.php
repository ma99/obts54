<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Closure;



class IsAdministrator
{
    
    public function handle($request, Closure $next)
    {
        //if (! $this->auth->user()->isAdministrator()) {
        if (! auth()->user()->isAdministrator()) {            
            return redirect('/forbidden');
        }

        return $next($request);
        
    }
}
