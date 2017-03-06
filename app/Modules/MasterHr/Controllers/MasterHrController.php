<?php namespace App\Modules\MasterHr\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\backend\Employee;
use App\Models\EmployeesLog;
use App\Models\LstDepartment;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;

class MasterHrController extends Controller {
   
    public function __construct()
    {
        $this->middleware('web');
    }
    
    public function index() { 
//        if(Auth::guard('admin')->check()){ 
//            echo Auth::guard('admin')->user()->first_name;            
//        }else {echo "not login";}
//        echo "<pre>";print_r(Auth::guard('admin')->user());exit;
        return view("MasterHr::index");
    }
    
    public function manageUsers() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageUsers = [];
        
        if(!empty($request['empId']) && $request['empId'] !== "0"){ // for edit
            $manageUsers = DB::select('CALL proc_manage_users(1,'.$request["empId"].')');
        }else if($request['empId'] === ""){ // for index
        $manageUsers = DB::select('CALL proc_manage_users(0,0)');
//            $manageUsers = Employee::leftjoin('new_builder_master.lst_departments as dept', 'employees.department_id', '=', 'dept.id')
//            ->leftjoin(DB::raw('(SELECT login_date_time,employee_id FROM employees_login_logs ORDER BY id DESC limit 1) AS employees_login_logs'), 'employees.id', '=', 'employees_login_logs.employee_id')
//            ->select('employees.*', 'dept.department_name', 'employees_login_logs.login_date_time')
//            ->orderBy('employees.id','asc')
//            ->get();
            
            foreach($manageUsers as $user){
                
                $getDeptName = array();
                $dept = LstDepartment::select('department_name')->whereRaw("id IN($user->department_id)")->get();
                for($i=0;$i<count($dept);$i++)
                {
                    $getDeptName[] = $dept[$i]->department_name;
                }
                $implodeDept = implode(",", $getDeptName);
                $user->department_id = $implodeDept;
                $user->login_date_time = !empty($user->login_date_time) ? date('Y-m-d', strtotime($user->login_date_time)) : ''; 
            }
        }
        if ($manageUsers) {            
            $result = ['success' => true, "records" => ["data" => $manageUsers, "total" => count($manageUsers), 'per_page' => count($manageUsers), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageUsers)]];
            echo json_encode($result);
        } 
    }
    
    public function changePassword() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if(!empty($request['empId'])){
            //send mail code
            //send email code
            $strRandomNo = str_random(6);
            $changedPassword = \Hash::make($strRandomNo);
            echo $strRandomNo;
            DB::table('employees')
            ->where('id', $request['empId'])
            ->update(['password' => $changedPassword]);
            
            $result = ['success' => true, "successMsg" => "Password has been changed as well as Mail and sms has been sent to selected user."];
            echo json_encode($result);
        }else{
            $result = ['success' => false, 'errorMsg' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
        }
    }
   
    public function create() {
        return view("MasterHr::create")->with("empId", '0');
    }

    public function store(Request $request) {
        $validationMessages = Employee::validationMessages();
        $validationRules = Employee::validationRules();
        
        $postdata = file_get_contents("php://input");
        $input  = json_decode($postdata, true);
        
        if(empty($input)){
            $input = Input::all();
        }
        echo "<pre>";print_r($input);exit;
        if(!empty($input['userData'])){
            $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                echo json_encode($result,true);
                exit;
            }
            /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
            $imgRules = array(
                'emp_photo_url' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
            );
            $validateEmpPhotoUrl = Validator::make($input, $imgRules);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                echo json_encode($result);
                exit;
            }
            else{
                $fileName = time().'.'.$input['emp_photo_url']->getClientOriginalExtension();
                $input['emp_photo_url']->move(base_path()."/common/employee_photo/", $fileName);
            }
            /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
            
            $input['userData']['emp_photo_url'] = $fileName;
            $input['userData']['password'] = \Hash::make($input['userData']['password']);
            $input['userData']['remember_token'] = str_random(10);
            $create = CommonFunctions::insertMainTableRecords();
            $input['userData'] = array_merge($input['userData'],$create);
            $input = Employee::doAction($input);            
            $employee = Employee::create($input['userData']); //insert data into employees table
            
            $input['userData']['main_record_id'] = Auth::guard('admin')->user()->id;
            $input['userData']['record_type'] = 1;
            $input['userData']['record_restore_status'] = 1;
            EmployeesLog::create($input['userData']);   //insert data into employees_logs table

            if ($employee) {
                $result = ['success' => true, 'message' => 'Employee registeration successfully'];
                echo json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
                echo json_encode($result);
            }
        }
        exit;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        return view("MasterHr::create")->with("empId", $id);
    }
    
    public function editDepartments() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $getDepartmentsFromEmployee = Employee::select('department_id')->where('id', $request['data'])->get();
        $explodeDepartment = explode(",", $getDepartmentsFromEmployee[0]->department_id);
        $getDepartments = LstDepartment::whereNotIn('id', $explodeDepartment)->get();
        if (!empty($getDepartments)) {
            $result = ['success' => true, 'records' => $getDepartments];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getDepartmentsToEdit() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $deptId = $request['data']['deptId'];
        $arr = explode(",", $deptId);
        $getdepts = LstDepartment::whereIn('id', $arr)->get();
        if (!empty($getdepts)) {
            $result = ['success' => true, 'records' => $getdepts];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $originalValues = Employee::where('id', $id)->get();
        $validationMessages = Employee::validationMessages();
        $validationRules = Employee::validationRules();
        $validationRules['email'] = 'required|email|unique:employees,email,' . $id . '';    
        $validationRules['password'] = '';
        $input = Input::all();
        $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
        $input = Employee::doAction($input);
        $input['userData']['updated_date'] = date('Y-m-d');
        $input['userData']['updated_by'] = Auth::guard('admin')->user()->id;
        $input['userData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
        $input['userData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $input['userData']['updated_mac_id'] = CommonFunctions::getMacAddress();
        unset($input['userData']['password_confirmation']);
        unset($input['userData']['passwordOld']);
        unset($input['userData']['password']);      
        
        /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
        $originalName = $input['emp_photo_url']->getClientOriginalName();
        if ($originalName !== 'fileNotSelected') {
            $imgRules = array(
                'emp_photo_url' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
            );
            $validateEmpPhotoUrl = Validator::make($input, $imgRules);
            if ($validateEmpPhotoUrl->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                echo json_encode($result);
                exit;
            } else {
                $fileName = time() . '.' . $input['emp_photo_url']->getClientOriginalExtension();
                $input['emp_photo_url']->move(base_path() . "/common/employee_photo/", $fileName);
            }
            $input['userData']['emp_photo_url'] = $fileName;
        }        
        /*************************** EMPLOYEE PHOTO UPLOAD **********************************/

        $employeeUpdate = Employee::where('id',$id)->update($input['userData']);
        $getResult = array_diff_assoc($originalValues[0]['attributes'], $input['userData']);
        $pwdData=$originalValues[0]['attributes']['password'];
        unset($getResult['password']);
        $implodeArr =  implode(",",array_keys($getResult));
        
        if ($employeeUpdate == 1) {
            $input['userData']['password'] = $pwdData;
            $input['userData']['main_record_id'] = Auth::guard('admin')->user()->id;
            $input['userData']['record_type'] = 2;
            $input['userData']['column_names'] = $implodeArr;
            $input['userData']['record_restore_status'] = 1;
            EmployeesLog::create($input['userData']);   
        }
        
        $result = ['success' => true, 'message' => 'Employee Updated Succesfully'];
        echo json_encode($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
