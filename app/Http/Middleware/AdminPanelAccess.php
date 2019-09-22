<?php

namespace App\Http\Middleware;

use Closure;

class AdminPanelAccess
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (auth()->user() && auth()->user()->isAdmin()) {
            return $next($request);
        }
        return redirect('/');
    }
}
