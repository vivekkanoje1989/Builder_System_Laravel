<?php

namespace App\Http\Middleware;

use Closure;
use View;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{    
    protected $permission;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
//        return $next($request);
//       $aa = \Illuminate\Support\Facades\Session::all();
//       echo "<pre>";print_r($aa);exit;
        $userPermission = json_decode(Auth()->guard('admin')->user()->employee_submenus, true);
        if (in_array($permission, $userPermission)) {
            return $next($request);
        }
        else{
            return response()->view('layouts.backend.error401');
        }
    }
}