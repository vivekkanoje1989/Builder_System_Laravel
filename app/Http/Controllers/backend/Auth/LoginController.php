<?php

namespace App\Http\Controllers\backend\Auth;

use App\Models\backend\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use View;
use App\classes\CommonFunctions;
use App\Models\backend\EmployeesDevice;
use Illuminate\Hashing\HashServiceProvider;
class LoginController extends Controller {
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
    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function checkUserCredentials(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $checkEmail = Employee::getRecords(["id","password","high_security_password"], ["username" => $request['data']['mobileData']]);//(select attributes, where conditions)
        if(empty($request['data']['passwordData'])){      
            if(!empty($checkEmail[0]->id)){
                $getMacAddress = CommonFunctions::getMacAddress();
                $checkDevice = EmployeesDevice::select('device_mac')->where(["employee_id" => $checkEmail[0]->id,"device_mac"=>$getMacAddress])->get();
                if(empty($checkDevice[0]->device_mac))
                {
                    $result = ['success' => false,'message' => 'You are not authorised to access the system on this machine'];
                }
                else{
                    $result = ['success' => true];
                }
            }
            else{
                $result = ['success' => false,'message' => 'Mobile does not exist!'];
            }
        }
        elseif(empty($request['data']['securityPasswordData'])){      
            if (\Hash::check($request['data']['passwordData'], $checkEmail[0]->password)) {
                $result = ['success' => true];                
            }else {
                $result = ['success' => false,'message' => 'Wrong Password!'];
            }
        }
        else{      
            if ($request['data']['securityPasswordData'] == $checkEmail[0]->high_security_password) {
                $result = ['success' => true];                
            }else {
                $result = ['success' => false,'message' => 'Wrong Password!'];
            }
        }
        return json_encode($result);
    }
    
    public function getSession(Request $request) {$data = \Location::get("175.100.138.136");            
        if (Auth::guard('admin')->check()) {
            
            $authUser = Auth()->guard('admin')->user();
            $result = ['success' => true, 'id' => $authUser->id, 'name' => $authUser->name, 'email' => $authUser->email];
            return $result;
        } else {
            $result = ['success' => false];
            return $result;
        }
    }

    public function getLoginForm() {
        if (Auth::guard('admin')->check()) {
            $id = Auth()->guard('admin')->user()->id;
            return view('layouts.backend.dashboard')->with('id', $id);
        } else {
            $getMacAddress = CommonFunctions::getMacAddress();
            $checkDevice = EmployeesDevice::getRecords(['device_mac'],["device_mac" => $getMacAddress]);
            if(!empty($checkDevice))
            {
                return view('backend.auth.login');
            }
            else
            {
                return View::make('layouts.backend.error500')->withSuccess('You are not authorised to access the system on this machine');
            }
        }
    }

    public function authenticate(Request $request) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $username = $request['data']['mobile'];
        $token = $request['data']['csrfToken'];
        
        if (Session::token() == $token) {
            $checkUsername = Employee::getRecords(["id","employee_status"], ["username" => $username]);//(select attributes, where conditions)
            $empId = $checkUsername[0]->id;
            $employee_status = $checkUsername[0]->employee_status;
            $getMacAddress = CommonFunctions::getMacAddress();
            $checkDevice = EmployeesDevice::select('device_mac')->where(["employee_id" => $empId,"device_mac"=>$getMacAddress])->get();
            if(empty($checkDevice[0]->device_mac))
            {
                CommonFunctions::insertLoginLog($username, "", $empId, 1, 3); //loginStatus = 1(login fail), loginFailureReason = 3(not authorised to access the system)
                $result = ['success' => false,'message' => 'You are not authorised to access the system on this machine'];
                return json_encode($result);
            }
            else
            {
                if(!empty($request['data']['password'])){      
                    $password = $request['data']['password'];
                    if ($employee_status == 1 && auth()->guard('admin')->attempt(['username' => $username, 'password' => $password])) { //username => mobile
                        CommonFunctions::insertLoginLog($username, $password, $empId, 2, 0); //loginStatus = 2(login), loginFailureReason = 0
                        $result = ['success' => true, 'message' => 'Successfully logged in'];
                        return json_encode($result);
                    } else {
                        if ($employee_status === 2) {
                            $loginFailureReason = 2;
                            $message = 'Your account has been temporarily suspended.';
                        } elseif ($employee_status == 3) {
                            $loginFailureReason = 3;
                            $message = 'Your account has been permanently suspended.';
                        } else {
                            $loginFailureReason = 1;
                            $message = 'Invalid Login Credentials!';
                        }
                        CommonFunctions::insertLoginLog($username, $password, $empId, 1, $loginFailureReason);//loginStatus = 1(login fail)
                        $result = ['success' => false, 'message' => $message];
                        return json_encode($result);
                    }
                }
            }
        }
        else{
            $result = ['success' => false,'message' => 'Token mismatch!'];
            return json_encode($result);
        }
    }

    public function getLogout() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $token = $request['data']['csrfToken'];
        if (Session::token() == $token) {
            $empId = Auth()->guard('admin')->user()->id;
            $username = Auth()->guard('admin')->user()->username;
            CommonFunctions::insertLoginLog($username, "-", $empId, 3, 0);//loginStatus = 3(logout)
            auth()->guard('admin')->logout();
            $result = ['success' => true, 'message' => 'Successfully logged out'];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            echo json_encode($result);
        }
    }

}
