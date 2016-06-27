<?php

namespace Efed\Http\Middleware;

use Closure;
use Auth;

class RedirectIfNotActivated
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
        if (!Auth::user()->activated) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
