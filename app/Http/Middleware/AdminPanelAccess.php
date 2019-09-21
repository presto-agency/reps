<?php

namespace App\Http\Middleware;

use App\Models\Role;
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
        $authRoleId = auth()->user();
        $roleSA = Role::query()->where('name', 'super-admin')->first();
        $roleA = Role::query()->where('name', 'admin')->first();

        if (auth()->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }


        if (($authRoleId->role_id === $roleSA->id) || ($authRoleId->role_id === $roleA->id)) {
            return $next($request);
        }
        return redirect('/');
    }
}
