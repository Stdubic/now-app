<?php

namespace App\Http\Middleware;

use Closure;

class CheckRolePermissions
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
		$user = getUser();

		if(!$user || !$user->active || !$user->canViewRoute($request->path(), $request->method())) return abort(403);

        return $next($request);
    }
}
