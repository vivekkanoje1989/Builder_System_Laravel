<?php

namespace App\Http\Controllers\backend\Auth;
//use App\Model\backend\Admin;
use App\Model\backend\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Http\UploadedFile;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function getSession()
    {
        if(Auth::guard('admin')->check()){ 
            $authUser = Auth()->guard('admin')->user();
            $result = ['success' => true,'id' => $authUser->id, 'name' => $authUser->name, 'email' => $authUser->email];
            return $result;
        }
        else 
        {
            $result = ['success' => false];
            return $result;
        }
    }

    public function getLoginForm()
    {
        if(Auth::guard('admin')->check()){   
            $id = Auth()->guard('admin')->user()->id;
            return view('layouts.backend.dashboard')->with('id', $id);
        }else{
            return view('backend.auth.login');
        }  
    }	
    
    public function authenticate(Request $request)
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata,true);
        $mobile = $request['data']['mobile'];
        $password = $request['data']['password'];
        $token = $request['data']['csrfToken'];
        if(Session::token() == $token)
        {
            if (auth()->guard('admin')->attempt(['username' => $mobile, 'password' => $password ])) //username => mobile
            {
                $result = ['success' => true, 'message' => 'Successfully logged in'];
                echo json_encode($result);
            }
            else
            {
                $result = ['success' => false, 'message' => 'Invalid Login Credentials !'];
                echo json_encode($result);
            }
        }

    }
        
    public function getLogout() 
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata,true);
        $token = $request['data']['csrfToken'];
        if(Session::token() == $token)
        {
            auth()->guard('admin')->logout();
            $result = ['success' => true, 'message' => 'Successfully logged out'];
            echo json_encode($result);
        }
        else
        {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            echo json_encode($result);
        }
    }
}
