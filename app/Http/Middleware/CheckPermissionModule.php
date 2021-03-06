<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermissionModule
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
        
        
        //echo $request->route('type');exit;
        if (!Auth::guard('admin')->check()) {
            return view('backend.sessiontimeout');
        }
        $userPermission = json_decode(Auth()->guard('admin')->user()->employee_submenus, true);
        $explodeId = explode("|", $permission);
        
        if(!empty($explodeId)){
            foreach($explodeId as $val){
                if (in_array($val, $userPermission)) {
                    return $next($request);
                }
            }
            return view("layouts.backend.error401");
        }
    }
}