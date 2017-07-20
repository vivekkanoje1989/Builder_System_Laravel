<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\DB;

class CheckAdmin
{
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }
    public function handle($request, Closure $next, ...$guards)
    {
        if(!empty(Auth()->guard('admin')->id()))
        {
            $data = DB::table('employees')//admins
                    ->select('employees.id')
                    ->where('employees.id',auth()->guard('admin')->id())
                    ->get();
            
//            if (!$data[0]->id  && $data[0]->usertype != 'admin')
            if (!$data[0]->id)
            {
                return redirect()->intended('office/login/')->with('status', 'You do not have access to admin side');
            }
            return $next($request);
        }
        else 
        {
            return redirect()->intended('office/login/')->with('status', 'Please Login to access admin area');
        }         
    }  
}
