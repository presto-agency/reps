<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class LoginAccess
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
        $user = null;
        if ($request->email) {
            $user = User::where('email', $request->email)->first();
        }

        if ($user && $user->ban) {
            \Session::flash('showModal', 'ban');
            return back();
        }
        if ($user && is_null($user->email_verified_at)) {
            \Session::flash('showModal', 'no_email_confirm');
            return back();
        }
        if (auth()->check() && auth()->user()->ban) {
            auth()->logout();
            \Session::flash('showModal', 'ban');
            return back();
        }

        return $next($request);
    }

}
