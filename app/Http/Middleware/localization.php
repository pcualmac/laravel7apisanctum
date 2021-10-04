<?php

namespace App\Http\Middleware;

use Closure;

class localization
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $local = ($request->hasHeader('x-xsfr-token')) ? $request->header('x-xsfr-token') : 'en-gb';
        app()->setLocale($local);

        return $next($request);
    }
}
