<?php namespace App\Modules\MasterHr\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\backend\Employee;
use App\Models\EmployeesLog;
use App\Models\Department;
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
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
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
    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("MasterHr::create")->with("empId", '0');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        $validationMessages = Employee::validationMessages();
        $validationRules = Employee::validationRules();
        $input = Input::all();
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
            $input['userData']['department_id'] = implode(',', array_map(function($el){ return $el['id']; }, $input['userData']['department_id']));
            $input['userData']['remember_token'] = str_random(10);
            $input['userData']['date_of_birth'] = date('Y-m-d', strtotime($input['userData']['date_of_birth']));
            $input['userData']['joining_date'] = date('Y-m-d', strtotime($input['userData']['joining_date']));
            $input['userData']['created_date'] = date('Y-m-d');
            $input['userData']['client_id'] = !empty($input['client_id']) ? $input['userData']['client_id'] : "0";
            $input['userData']['client_role_id'] = "1";
            $input['userData']['high_security_password'] = !empty($input['userData']['high_security_password']) ? $input['userData']['high_security_password'] : "";
            $input['userData']['password_changed'] = !empty($input['userData']['password_changed']) ? $input['userData']['password_changed'] : "0";
            $input['userData']['remember_token'] = str_random(10);
            $input['userData']['usertype'] = "admin";
            $input['userData']['team_lead_id'] = !empty($input['userData']['team_lead_id']) ? $input['userData']['team_lead_id'] : "1"; 
            $input['userData']['middle_name'] = !empty($input['userData']['middle_name']) ? $input['userData']['middle_name'] : "";
            $input['userData']['marriage_date'] = !empty($input['userData']['marriage_date']) ? date('Y-m-d', strtotime($input['userData']['marriage_date'])) : "";        
            $input['userData']['physic_desc'] = !empty($input['userData']['physic_desc']) ? $input['userData']['physic_desc'] : "";

            $personalMobileNo1 = explode("-",$input['userData']['personal_mobile_no1']);
            $input['userData']['mobile1_calling_code'] = (int)$personalMobileNo1[0];
            $input['userData']['personal_mobile_no1'] = $personalMobileNo1[1];

            if(!empty($input['userData']['personal_mobile_no2'])){
                $personalMobileNo2 = explode("-",$input['userData']['personal_mobile_no2']);
                $input['userData']['mobile2_calling_code'] = (int)$personalMobileNo2[0];
                $input['userData']['personal_mobile_no2'] = $personalMobileNo2[1];
            }

            if(!empty($input['userData']['office_mobile_no'])){
                $officeMobileNo = explode("-",$input['userData']['office_mobile_no']);
                $input['userData']['office_mobile_calling_code'] = (int)$officeMobileNo[0];
                $input['userData']['office_mobile_no'] = $officeMobileNo[1];
            }

            if(!empty($input['userData']['landline_no'])){
                $landlineNo = explode("-",$input['userData']['landline_no']);
                $input['userData']['landline_calling_code'] = $landlineNo[0];
                $input['userData']['landline_no'] = $landlineNo[1];
            }

            $input['userData']['education_details'] = !empty($input['userData']['education_details']) ? $input['userData']['education_details'] : "";
            $input['userData']['show_on_homepage'] = !empty($input['userData']['show_on_homepage']) ? $input['userData']['show_on_homepage'] : "1";
            $input['userData']['employee_submenus'] = !empty($input['userData']['employee_submenus']) ? $input['userData']['employee_submenus'] : '["0101","0102","0103","0104"]';
            $input['userData']['employee_permissions'] = !empty($input['userData']['employee_permissions']) ? $input['userData']['employee_permissions'] : "1";
            $input['userData']['employee_email_subscriptions'] = !empty($input['userData']['employee_email_subscriptions']) ? $input['userData']['employee_email_subscriptions'] : "1";
            $input['userData']['employee_sms_subscrption'] = !empty($input['userData']['employee_sms_subscrption']) ? $input['userData']['employee_sms_subscrption'] : "1";
            $input['userData']['employee_info_form_url'] = !empty($input['userData']['employee_info_form_url']) ? $input['userData']['employee_info_form_url'] : "1";
            $input['userData']['employee_info_form_url_status'] = !empty($input['userData']['employee_info_form_url_status']) ? $input['userData']['employee_info_form_url_status'] : "1";
            $input['userData']['created_by'] = Auth::guard('admin')->user()->id;
            $input['userData']['created_IP'] = $_SERVER['REMOTE_ADDR'];
            $input['userData']['created_browser'] = $_SERVER['HTTP_USER_AGENT'];
            $input['userData']['created_mac_id'] = CommonFunctions::getMacAddress();
            $employee =  Employee::create($input['userData']); //insert data into employees table            
            
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
    
    public function editDepartments(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $getDepartmentsFromEmployee = Employee::select('department_id')->where('id', $request['data'])->get();     
        $explodeDepartment = explode(",", $getDepartmentsFromEmployee[0]->department_id);;
        $getDepartments = Department::whereNotIn('id', $explodeDepartment)->get();       
        if(!empty($getDepartments))
        {
            $result = ['success' => true, 'records' => $getDepartments];
            return $result;
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
    public function getDepartmentsToEdit() {
        $result=array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $deptId = $request['data']['deptId'];
        $arr = explode(",", $deptId);
        $getdepts = Department::whereIn('id', $arr)->get();
        if (!empty($getdepts)) {
            $result = ['success'=> true,'records' => $getdepts]; 
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
        $validationMessages = Employee::validationMessages();
        $validationRules = Employee::validationRules();
        $validationRules['email'] = 'required|email|unique:employees,email,' . $id . '';       
        $input = Input::all();
        if(empty($input['userData']['password'])){
            $input['userData']['password'] = $input['userData']['passwordOld'];
        }
        $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
//        echo "<pre>";print_r($input);exit;
        $input['userData']['department_id'] = implode(',', array_map(function($el) {
                    return $el['id'];
                }, $input['userData']['department_id']));
        $input['userData']['password'] = !empty($input['userData']['password']) ? \Hash::make($input['userData']['password']) :$input['userData']['password'];
        $input['userData']['date_of_birth'] = date('Y-m-d', strtotime($input['userData']['date_of_birth']));
        $input['userData']['joining_date'] = date('Y-m-d', strtotime($input['userData']['joining_date']));
        $input['userData']['updated_date'] = date('Y-m-d');
        $input['userData']['employee_id'] = !empty($input['userData']['employee_id']) ? $input['userData']['employee_id'] : "1";
        $input['userData']['high_security_password_type'] = !empty($input['userData']['high_security_password_type']) ? $input['userData']['high_security_password_type'] : "1";
        $input['userData']['high_security_password'] = !empty($input['userData']['high_security_password']) ? $input['userData']['high_security_password'] : "8899";
        $input['userData']['password_changed'] = !empty($input['userData']['password_changed']) ? $input['userData']['password_changed'] : "0";
        $input['userData']['team_lead_id'] = !empty($input['userData']['team_lead_id']) ? $input['userData']['team_lead_id'] : "1";
        $input['userData']['middle_name'] = !empty($input['userData']['middle_name']) ? $input['userData']['middle_name'] : "";
        $input['userData']['marriage_date'] = !empty($input['userData']['marriage_date']) ? date('Y-m-d', strtotime($input['userData']['marriage_date'])) : "";
        $input['userData']['physic_desc'] = !empty($input['userData']['physic_desc']) ? $input['userData']['physic_desc'] : "";

        $personalMobileNo1 = explode("-", $input['userData']['personal_mobile_no1']);
        $input['userData']['mobile1_calling_code'] = $personalMobileNo1[0];
        $input['userData']['personal_mobile_no1'] = $personalMobileNo1[1];
        if (!empty($input['userData']['personal_mobile_no2'])) {
            $personalMobileNo2 = explode("-", $input['userData']['personal_mobile_no2']);
            $input['userData']['mobile2_calling_code'] = $personalMobileNo2[0];
            $input['userData']['personal_mobile_no2'] = $personalMobileNo2[1];
        }

        if (!empty($input['userData']['office_mobile_no'])) {
            $officeMobileNo = explode("-", $input['userData']['office_mobile_no']);
            $input['userData']['office_mobile_calling_code'] = $officeMobileNo[0];
            $input['userData']['office_mobile_no'] = $officeMobileNo[1];
        }

        if (!empty($input['userData']['landline_no'])) {
            $landlineNo = explode("-", $input['userData']['landline_no']);
            $input['userData']['landline_calling_code'] = $landlineNo[0];
            $input['userData']['landline_no'] = $landlineNo[1];
        }
        $input['userData']['updated_by'] = 1;
        $input['userData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
        $input['userData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $input['userData']['updated_mac_id'] = CommonFunctions::getMacAddress();
        unset($input['userData']['password_confirmation']);
        /*   * ************************* EMPLOYEE PHOTO UPLOAD ********************************* */
        /*$imgRules = array(
            'emp_photo_url' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
        );
       // echo"<pre>-------"; print_r( $input['emp_photo_url']);exit;
        $validateEmpPhotoUrl = Validator::make($input['userData'], $imgRules,$imgmsg);
        if ($validateEmpPhotoUrl->fails()) {
            $result = ['success' => false, 'message' => $validateEmpPhotoUrl->messages()];
            echo json_encode($result);
            exit;
        } else {
            $fileName = time() . '.' . $input['userData']['emp_photo_url']->getClientOriginalExtension();
            $input['userData']['emp_photo_url']->move(resource_path('hrEmployeePhoto'), $fileName);
        }  
        /* ******************************* END *************************** */
        // $input['userData']['emp_photo_url'] = $fileName;
       
        $employeeUpdate = Employee::where('id',$id)->update($input['userData']);
         if ($employeeUpdate) {
            $result = ['success' => true, 'message' => 'Employee Updated Succesfully'];
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
        }
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
