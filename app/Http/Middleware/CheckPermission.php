<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $userPermission = json_decode(Auth()->guard('admin')->user()->employee_submenus, true);
        if (in_array($permission, $userPermission)) {
            return $next($request);
        }
        else{
            return response()->view('layouts.backend.error401');
        }
    }
}