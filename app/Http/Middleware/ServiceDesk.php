<?php

namespace App\Http\Middleware;

use Closure;

class ServiceDesk
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
        if(!auth()->user()->isAdmin())
        {
            return redirect(route('home'))->withErrors(['badRequest' => 'Du har inte tillräckliga rättigheter för sidan som försökte nås']);
        }

        return $next($request);
    }
}
