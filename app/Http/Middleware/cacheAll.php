<?php

namespace App\Http\Middleware;

use Closure;

class CacheAll
{
    /**
     * Cache at the edge for 1 hour.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        $response->header('Cache-Control', 'max-age=3600');

        return $response;
    }
}
