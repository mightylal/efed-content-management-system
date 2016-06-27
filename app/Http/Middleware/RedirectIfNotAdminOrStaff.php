<?php

namespace Efed\Http\Middleware;

use Closure;
use Efed\Models\Staff;
use Auth;

class RedirectIfNotAdminOrStaff
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
        $staff = (new Staff)->is(Auth::id());
        if (!$staff && !Auth::user()->admin) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
