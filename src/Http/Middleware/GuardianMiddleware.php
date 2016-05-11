<?php

namespace EmilMoe\Guardian\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use EmilMoe\Guardian\Http\Guardian;
use Illuminate\Support\Facades\Auth;
use EmilMoe\Guardian\Http\PermissionParameter;

class GuardianMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param  Closure $next
     * @param  String $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $this->toCollection($permission);

        if (! $this->hasAccess($request, $permission))
            return Guardian::restricted();

        return $next($request);
    }

    /**
     * Convert input to an array
     *
     * @param $permission
     */
    private function toCollection(&$permission)
    {
        $permission = collect(strpos($permission, ':') !== false ? explode(':', $permission) : [$permission]);
        $permission = $permission->map(function($item) {
            return new PermissionParameter($item);
        });
    }

    /**
     * Check if has local or global access
     *
     * @param $request
     * @param $permission
     * @return bool
     */
    private function hasAccess($request, $permission)
    {
        if (! Auth::check())
            return false;

        if ($this->hasGlobalAccess($permission) || $this->hasLocalAccess($request, $permission))
            return true;

        return false;
    }

    /**
     * Check if user has set global access
     *
     * @param $permission
     * @return mixed
     */
    private function hasGlobalAccess($permission)
    {
        if (is_string($permission))
            return Auth::user()->hasAccess($permission);

        foreach ($permission as $perm)
            if ($this->hasGlobalAccess($perm->getName()))
                return true;

        return false;
    }

    /**
     * Check if user has set local access to the current ID
     *
     * @param $request
     * @param $permission
     * @param null $id
     * @return bool
     */
    private function hasLocalAccess($request, $permission, $id = null)
    {
        if (is_string($permission))
            return Auth::user()->hasAccess($permission, $id);

        foreach ($permission as $perm)
            if ($this->hasLocalAccess($request, $perm->getName(), $request->{$perm->getColumn()}))
                return true;

        return false;
    }
}