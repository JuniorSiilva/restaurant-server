<?php

namespace App\Http\Middleware;

use Closure;
use App\Facades\Tenant;
use Illuminate\Http\Request;

class InitializeTenancyByHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Tenant::set($request->header('Tenant'));

        return $next($request);
    }
}
