<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;

class LastUserActivity
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $expiresAt = Carbon::now()->addMinutes(2);
            \Cache::put('user-us-online-'.auth()->id(), '', $expiresAt);
        }
        return $next($request);
    }

}
