<?php

namespace App\Http\Controllers\backend\Auth;

//use App\Model\backend\Admin;
use App\Models\backend\Employee;
use Illuminate\Http\Request;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }

    public function getRegisterForm()
    {
        return view('backend/auth/register');
    }	
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  request  $request
     * @return User
     */
    protected function saveRegisterForm(Request $request)
    {
        $messages = array(
            'name.required' => 'Please enter name',
            'email.required' => 'Please enter email',
            'email.unique' => 'This email is already taken. Please input a another email',
            'password.required' => 'Please enter password',
        );

        $rules = array(
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:employees',//
            'password' => 'required|min:6|confirmed',
        );
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata,true);
        $validator = Validator::make($request['data'], $rules, $messages);
        
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }       
        $admin = Employee::registeruser($request['data']);    // Admin     
        
        if($admin->id){
            $result = ['success' => true, 'message' => 'Admin register successfully'];
            echo json_encode($result);
        }else{
            $result = ['success' => false, 'message' => 'Admin not register. Please try again'];
            echo json_encode($result);
        }
        
    }
}
