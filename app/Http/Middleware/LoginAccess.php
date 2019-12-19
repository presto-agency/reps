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
        $user = User::where('email', $request->email)->value('ban');

        if ($user == 1) {
            \Session::flash('showModal', 'ban');
            return back();
        }
        if (auth()->check() && auth()->user()->ban == 1){
            auth()->logout();
            \Session::flash('showModal', 'ban');
            return back();
        }

        return $next($request);
    }

}
