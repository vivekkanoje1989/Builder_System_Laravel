<?php

namespace App\Modules\MasterHr\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\backend\Employee;
use App\Models\EmployeesLog;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Classes\MenuItems;
use App\Classes\S3;
use App\Modules\MasterHr\Models\EmployeeRole;
use App\Models\MlstBmsbDesignation;
use App\Models\MlstBmsbDepartment;
use Session;
use App\Models\MlstTitle;

class MasterHrController extends Controller {

    public static $empArr;

    public function __construct() {
        $this->middleware('web');
    }

    public function index() {
        return view("MasterHr::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function manageUsers() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageUsers = [];
        $totalCount = [];
        $department_id = [];

        if (!empty($request['empId']) && $request['empId'] !== "0") { // for edit
            $manageUsers = DB::select('CALL proc_manage_users(1,' . $request["empId"] .')');
        } else if ($request['empId'] == "") { // for index
            $manageData = DB::select('CALL proc_manage_users(0,0)');
            $cnt = DB::select('select FOUND_ROWS() totalCount');
            $totalCount = $cnt[0]->totalCount;
            $manageUser = json_decode(json_encode($manageData), true);
            $i = 0;
            foreach ($manageUser as $manage) {
                $manageUser[$i]['department_id'] = explode(',', $manage['department_id']);
                $i++;
            }
            for ($i = 0; $i < count($manageUser); $i++) {
                $blogData['id'] = $manageUser[$i]['id'];
                $blogData['first_name'] = $manageUser[$i]['first_name'];
                $blogData['last_name'] = $manageUser[$i]['last_name'];
                $blogData['joining_date'] = $manageUser[$i]['joining_date'];
                $blogData['employee_status'] = $manageUser[$i]['employee_status'];
                $blogData['departmentName'] = $manageUser[$i]['departmentName'];
                $blogData['designation'] = $manageUser[$i]['designation'];
                $blogData['team_lead_fname'] = $manageUser[$i]['team_lead_fname'];
                $blogData['team_lead_lname'] = $manageUser[$i]['team_lead_lname'];
                $blogData['reporting_to_fname'] = $manageUser[$i]['reporting_to_fname'];
                $blogData['reporting_to_lname'] = $manageUser[$i]['reporting_to_lname'];
                $blogData['login_date_time'] = $manageUser[$i]['login_date_time'];
                $blogData['firstName'] = $blogData['first_name'].' '.$blogData['last_name'];
                $blogData['team_lead_name'] = $blogData['team_lead_fname'].' '.$blogData['team_lead_lname'];
                $blogData['reporting_to_name'] = $blogData['reporting_to_fname'].' '.$blogData['reporting_to_lname'];

                $manageUsers[] = $blogData;
            }
            
        }
      
        if ($manageUsers) {
            $result = ['success' => true, "records" => ["data" => $manageUsers, "total" => count($manageUsers), 'per_page' => count($manageUsers), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageUsers)]];
            return json_encode($result);
        }
    }

//    public function filteredData() {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
//        $filterData = $request['filterData'];
//        $ids = [];
//
//        if (empty($request['employee_id'])) { // For Web
//            $loggedInUserId = Auth::guard('admin')->user()->id;
//
//            $filterData["firstName"] = !empty($filterData["firstName"]) ? $filterData["firstName"] : "";
//            $filterData["designation_id"] = !empty($filterData['designation_id']) ? $filterData['designation_id'] : "";
//            $filterData["department_id"] = !empty($filterData['department_id']) ? $filterData['department_id'] : "";
//            $filterData["joining_date"] = !empty($filterData['joining_date']) ? $filterData['joining_date'] : "";
//        } else { // For App
//            $request["getProcName"] = MasterHrController::$procname;
//            $loggedInUserId = $request['employee_id'];
//
//            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//                $loggedInUserId = implode(',', array_map(function($el) {
//                            return $el['id'];
//                        }, $filterData['empId']));
//            }
//            $filterData["firstName"] = !empty($filterData["firstName"]) ? $filterData["firstName"] : "";
//            $filterData["designation_id"] = !empty($filterData['designation_id']) ? $filterData['designation_id'] : "";
//            $filterData["department_id"] = !empty($filterData['department_id']) ? $filterData['department_id'] : "";
//            $filterData["joining_date"] = !empty($filterData['joining_date']) ? date('Y-m-d', strtotime($filterData['joining_date'])) : "";
//            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
//        }
//        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//            $loggedInUserId = implode(',', array_map(function($el) {
//                        return $el['id'];
//                    }, $filterData['empId']));
//        }
//
//        $getAllUsers = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["firstName"] . '","' . $filterData["designation_id"] . '","' . $filterData["department_id"] . '","' . $filterData["joining_date"] . '","' . $request['pageNumber'] . '","' . $request['itemPerPage'] . '")');
//
//        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
//        $enqCnt = $enqCnt[0]->totalCount;
//
//        $i = 0;
//        if (!empty($getAllUsers)) {
//            foreach ($getAllUsers as $getAllUser) {
//                $getAllUsers[$i]->employee_name = $getAllUser->first_name . ' ' . $getAllUser->last_name;
//
//                $i++;
//            }
//        }
//
//
//        if (!empty($getAllUsers)) {
//            $result = ['success' => true, 'records' => $getAllUsers, 'totalCount' => $enqCnt];
//        } else {
//            $result = ['success' => false, 'records' => $getAllUsers, 'totalCount' => $enqCnt];
//        }
//        return json_encode($result);
//    }

    public function checkRole() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $checkRole = Employee::select("client_role_id")->where("id", $request["empId"])->get();
        if (!empty($checkRole[0]['client_role_id'])) {
            $result = ['success' => true, "role_id" => $checkRole[0]['client_role_id']];
        } else {
            $result = ['success' => false, "records" => "No records found"];
        }
        return \Response()->json($result);
    }

    public function manageRolesPermission() {
//        if (Auth::guard('admin')->user()->id == 1) {
        $roles = EmployeeRole::all();
        return view("MasterHr::manageroles")->with("roles", $roles);
//        }
    }

    public function getRoles() {
        $roles = EmployeeRole::orderBy('role_name', 'ASC')->get();
        if (!empty($roles)) {
            $result = ['success' => true, "list" => $roles];
            echo json_encode($result);
        } else {
            $result = ['success' => false, "message" => "No records found"];
            echo json_encode($result);
        }
    }

    public function changePassword() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (!empty($request['data']['empId'])) {
            $checkEmp = Employee::where('id', $request['data']['empId'])->first();
            if (empty($request['data']['password'])) {
                $password = str_random(8);
            } else {
                $old_password = $request['data']['old_password'];

                if (\Hash::check($request['data']['old_password'], $checkEmp->password)) {
                    $password = $request['data']['password'];
                } else {
                    $result = ['success' => false, 'message' => 'Old password is wrong!'];
                    echo json_encode($result);
                    exit;
                }
            }
            //print_r($password);exit;
            $changedPassword = \Hash::make($password);

            DB::table('employees')
                    ->where('id', $request['data']['empId'])
                    ->update(['password' => $changedPassword]);
            //$empModel = \App\Model\backend\Employee::where('id',$request['empId'])->first();
            $templatedata['employee_id'] = $checkEmp->id;
            $templatedata['client_id'] = $checkEmp->client_id;
            $templatedata['template_setting_customer'] = 0;
            $templatedata['template_setting_employee'] = 27;
            $templatedata['customer_id'] = 0;
            $templatedata['model_id'] = 0;

            $templatedata['arrExtra'][0] = array(
                '[#currentDate#]',
                '[#currentTime#]',
                '[#username#]',
                '[#password#]'
            );
            $templatedata['arrExtra'][1] = array(
                date('d-M-Y'),
                date('h:s A'),
                $checkEmp->username,
                $password
            );
            $result = CommonFunctions::templateData($templatedata);

            $result = ['success' => true, "message" => "Password changed and email and SMS sent to selected user."];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
        }
    }

    public function getProfile() {

        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        //getting authkey from api call
        $authkey = trim($request["authkey"]);
        //checking for user related to authkey.
        $empModel = Employee::where(['mobile_remember_token' => $authkey])->first();
        if (!empty($empModel)) {
            $teams = array();
            $validate = Employee::where(['client_id' => $empModel->client_id])->get();
            $client = \App\Models\ClientInfo::where(['id' => $empModel->client_id])->first();
            foreach ($validate as $value) {

                $title = DB::connection('masterdb')->table('mlst_titles')->where('id', '=', $value->title_id)->select('title')->first();
                $value->title = $title->title;

                if (!empty($value->employee_photo_file_name)) {
                    $value->employee_photo_file_name = config('global.s3Path') . '/employee-photos/' . $value->employee_photo_file_name;
                } else {
                    $value->employee_photo_file_name = '';
                }

                if (!empty($value->department_id))
                    $value->department_id = explode(',', $value->department_id);


                $designations = DB::connection('masterdb')->table('mlst_bmsb_designations')->where('id', '=', $value->designation_id)->select('designation')->first();

                $value->designation = $designations->designation;


                $value->employee_menus = json_decode($value->employee_submenus);
                $teams[] = $value->getAttributes();
            }
            $this->allusers = array();
            $this->tuserid($empModel->id);
            $alluser = $this->allusers;
            $team_member = implode(',', $alluser);
            $response = $empModel->getAttributes();

            if (!empty($empModel->employee_photo_file_name)) {
                $response['employee_photo_file_name'] = config('global.s3Path') . '/employee-photos/' . $empModel->employee_photo_file_name;
            } else {
                $response['employee_photo_file_name'] = "";
            }
            if (!empty($empModel->department_id))
                $response['department_id'] = explode(',', $empModel->department_id);
            $title1 = DB::connection('masterdb')->table('mlst_titles')->where('id', '=', $empModel->title_id)->select('title')->first();
            $response['title'] = $title1->title;
            $designations = DB::connection('masterdb')->table('mlst_bmsb_designations')->where('id', '=', $empModel->designation_id)->select('designation')->first();
            $response['designation'] = $designations->designation;
            $response['employee_menus'] = json_decode($empModel->employee_submenus);
            $response['brand_id'] = $client->brand_id;
            $response['company_name'] = $client->marketing_name;
            $response['team_members'] = $team_member;
            $result = ['success' => true, 'Profile' => $response, 'teams' => $teams];
        }
        else {
            $result = ['success' => false, 'message' => "Login expired,please login again.."];
        }

        return json_encode($result);
    }

    public function tuserid($id) {

        $admin = Employee::where(['team_lead_id' => $id])->get();
        if (!empty($admin)) {

            foreach ($admin as $item) {

                $this->allusers[$item->id] = $item->id;

                $this->tuserid($item->id);
            }
        } else {
            return;
        }
    }

    public function create() {
        return view("MasterHr::create")->with("empId", '0');
    }

    public function store(Request $request) {

        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if (empty($input)) {
            $input = Input::all();
            $input['userData']['loggedInUserId'] = Auth::guard('admin')->user()->id;
            $validationMessages = Employee::validationMessages();
            $validationRules = Employee::validationRules();
            $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                echo json_encode($result, true);
                exit;
            }
        }
        $input['userData']['password'] = substr($input['userData']['username'], 0, 6);
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!empty($input['userData'])) {
            /*             * ************************* EMPLOYEE PHOTO UPLOAD ********************************* */
            if (!empty($input['employee_photo_file_name'])) {
                $imgRules = array(
                    'employee_photo_file_name' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
                );
                $validateEmpPhotoUrl = Validator::make($input, $imgRules);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    echo json_encode($result);
                    exit;
                } else {
                    $folderName = 'employee-photos';
                    $image = ['0' => $input['employee_photo_file_name']];
                    $imageName = S3::s3FileUpload($image, $folderName, 1);
                    $imageName = trim($imageName, ',');
                }
                $input['userData']['employee_photo_file_name'] = $imageName;
            }
            /*             * ************************* EMPLOYEE PHOTO UPLOAD ********************************* */
            $password = $input['userData']['password'];
            $username = $input['userData']['username'];
            $input['userData']['password'] = \Hash::make($input['userData']['password']);
            $input['userData']['remember_token'] = str_random(10);

            if (!empty($input['userData']['loggedInUserId'])) {
                $loggedInUserId = $input['userData']['loggedInUserId'];
            }
            if (empty($input['userData']['high_security_password'])) {
                $input['userData']['high_security_password'] = '1234';
            }
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['userData'] = array_merge($input['userData'], $create);
            $input = Employee::doAction($input);
            $employee = Employee::create($input['userData']); //insert data into employees table     

            $input['userData']['main_record_id'] = $employee->id;
            $input['userData']['record_type'] = 1;
            $input['userData']['record_restore_status'] = 1;
            EmployeesLog::create($input['userData']);   //insert data into employees_logs table

            if ($employee) {
                $templatedata['employee_id'] = $employee->id;
                $templatedata['client_id'] = config('global.client_id');
                $templatedata['template_setting_customer'] = 0;
                $templatedata['template_setting_employee'] = 26;
                $templatedata['customer_id'] = 0;
                $templatedata['model_id'] = 0;
                $templatedata['arrExtra'][0] = array(
                    '[#username#]',
                    '[#password#]'
                );
                $templatedata['arrExtra'][1] = array(
                    $username,
                    $password
                );

                $result = CommonFunctions::templateData($templatedata);

                $result = ['success' => true, 'message' => 'Employee registration successfully', "empId" => $employee->id];
                return json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong.'];
                return json_encode($result);
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

        return view("MasterHr::updatehr")->with("empId", $id);
    }

    public function storeEmployeeData() {
        $validationMessages = Employee::validationStep1();
        $validationRules = Employee::validationRulesstep1();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        if (!empty($input['data']['empId'])) {
            $loggedInUserId = $input['data']['empId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }

        $request = $input['data'];
        if (!empty($request['userData'])) {
            unset($request['userData']['birth_date']);

            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['userData'] = array_merge($request['userData'], $create);

            if ($request['userData']['date_of_birth'] == 'NaN-aN-NaN') {
                unset($request['userData']['date_of_birth']);
            }
            $employee = Employee::create($request['userData']);
            $input['userData']['main_record_id'] = $loggedInUserId;
            $input['userData']['record_type'] = 1;
            $input['userData']['record_restore_status'] = 1;

            $input['userData']['client_id'] = config('global.client_id');
            EmployeesLog::create($request['userData']);
            $result = ['success' => true, 'message' => 'Employee registeration successfully', "empId" => $employee->id];
            return json_encode($result);
        }
    }

    public function manageContact() {
        $validationMessages = Employee::validationStep2();
        $validationRules = Employee::validationRulesstep2();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);


        if (!empty($input['userContact']['personal_landline_no'])) {
            $input['userContact']['personal_landline_no'] = $input['userContact']['personal_landline_no'];
        }
        if (!empty($input['userContact']['personal_landline_calling_code'])) {
            $input['userContact']['personal_landline_calling_code'] = str_replace('+', '', str_replace('-', '', $input['userContact']['personal_landline_calling_code']));
        }
        if (!empty($input['userContact']['personal_mobile1'])) {
            $input['userContact']['personal_mobile1'] = $input['userContact']['personal_mobile1'];
        }
        if (!empty($input['userContact']['personal_mobile1_calling_code'])) {
            $input['userContact']['personal_mobile1_calling_code'] = str_replace('+', '', str_replace('-', '', $input['userContact']['personal_mobile1_calling_code']));
        }
        if (!empty($input['userContact']['personal_mobile2'])) {
            $input['userContact']['personal_mobile2'] = $input['userContact']['personal_mobile2'];
        }
        if (!empty($input['userContact']['personal_mobile2_calling_code'])) {
            $input['userContact']['personal_mobile2_calling_code'] = str_replace('+', '', str_replace('-', '', $input['userContact']['personal_mobile2_calling_code']));
        }
        if (!empty($input['userContact']['office_mobile_no'])) {
            $input['userContact']['office_mobile_no'] = $input['userContact']['office_mobile_no'];
        }
        if (!empty($input['userContact']['office_mobile_calling_code'])) {
            $input['userContact']['office_mobile_calling_code'] = str_replace('+', '', str_replace('-', '', $input['userContact']['office_mobile_calling_code']));
        }

        $employee = Employee::where('id', '=', $input['employeeId'])->update($input['userContact']);

        $result = ['success' => true, 'message' => 'Employee registeration successfully'];
        return json_encode($result);
    }

    public function manageJobForm() {
        $validationMessages = Employee::validationStep4();
        $validationRules = Employee::validationRulesstep4();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        $departmentData = array();
        if (!empty($input['userJobData']['department_id'])) {
            foreach ($input['userJobData']['department_id'] as $department_id) {
                $department = $department_id['id'];
                array_push($departmentData, $department);
            }
            $department_id = implode(',', $departmentData);
            $input['userJobData']['department_id'] = $department_id;
        }
        $employee = Employee::where('id', '=', $input['employeeId'])->update($input['userJobData']);
        $result = ['success' => true, 'message' => 'Employee registeration successfully'];
        return json_encode($result);
    }

    public function manageStatusForm() {
        $validationMessages = Employee::validationStep5();
        $validationRules = Employee::validationRulesstep5();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        if ($input['createStatus'] == 0) {
            $password = substr(rand(10000000, 99999999), 0, 8);
            $username = $input['userStatus']['username'];
            $input['userStatus']['password'] = \Hash::make($password);
            $input['userStatus']['remember_token'] = str_random(10);

            $templatedata['employee_id'] = $input['employeeId'];
            $templatedata['client_id'] = config('global.client_id');
            $templatedata['template_setting_customer'] = 0;
            $templatedata['template_setting_employee'] = 26;
            $templatedata['customer_id'] = 0;
            $templatedata['model_id'] = 0;
            $templatedata['arrExtra'][0] = array(
                '[#username#]',
                '[#password#]'
            );
            $templatedata['arrExtra'][1] = array(
                $username,
                $password
            );
        }

        if ($input['userStatus']['high_security_password_type'] == '0') {
            $highsecuritypassword = substr(rand(100000, 999999), 0, 4);
        } else {
            $highsecuritypassword = $input['userStatus']['high_security_password'];
        }
        if (!empty($input['userStatus']['loggedInUserId'])) {
            $loggedInUserId = $input['userStatus']['loggedInUserId'];
        }
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['userStatus'] = array_merge($input['userStatus'], $create);
        $input['userStatus']['client_id'] = config('global.client_id');
        $input['userStatus']['employee_permissions'] = '["0101","0102","0103","0104","0105","0106","0107"]';
        $employee = Employee::where('id', '=', $input['employeeId'])->update($input['userStatus']);
        $result = ['success' => true, 'message' => 'Employee registered successfully'];
        return json_encode($result);
    }

    public function createEducationForm() {
        $validationMessages = Employee::validationStep3();
        $validationRules = Employee::validationRulesstep3();
        $input = Input::all();
        $originalName = $input['employee_photo_file_name']->getClientOriginalName();

        if ($originalName != "fileNotSelected") {
            if (!empty($input['employee_photo_file_name'])) {

                $folderName = 'employee-photos';
                $image = ['0' => $input['employee_photo_file_name']];
                $imageName = S3::s3FileUpload($image, $folderName, 1);
                $imageName = trim($imageName, ',');
                $input['userEducation']['employee_photo_file_name'] = $imageName;
            }
        } else {
            unset($input['userEducation']['employee_photo_file_name']);
        }

        $employee = Employee::where('id', '=', $input['employeeId'])->update($input['userEducation']);
        $result = ['success' => true, 'message' => 'Employee registeration successfully'];
        return json_encode($result);
    }

    public function updateEmployee() {

        $validationMessages = Employee::validationStep1();
        $validationRules = Employee::validationRulesstep1();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $request = $input['data'];
        unset($request['userData']['birth_date']);


        if (empty($request)) {
            $request = Input::all();
            $request['userData']['loggedInUserId'] = Auth::guard('admin')->user()->id;
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!empty($request['userData'])) {

            $loggedInUserId = Auth::guard('admin')->user()->id;
            if ($request['userData']['date_of_birth'] == 'NaN-aN-NaN') {
                unset($request['userData']['date_of_birth']);
            }
            $employee = Employee::where('id', '=', $request['empId'])->update($request['userData']); //insert data into employees table     
            $input['userData']['main_record_id'] = $loggedInUserId;
            $input['userData']['record_type'] = 1;
            $input['userData']['record_restore_status'] = 1;
            $input['userData']['client_id'] = config('global.client_id');

            EmployeesLog::create($request['userData']);   //insert data into employees_logs table

            $result = ['success' => true, 'message' => 'Employee Updated successfully'];
            return json_encode($result);
        }
    }

    public function editDepartments() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $getDepartmentsFromEmployee = Employee::select('department_id')->where('id', $request['data'])->get();
        $explodeDepartment = explode(",", $getDepartmentsFromEmployee[0]->department_id);
        $getDepartments = MlstBmsbDepartment::whereNotIn('id', $explodeDepartment)->get();
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
        $getdepts = MlstBmsbDepartment::whereIn('id', $arr)->get();
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
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);


        //   $validationRules['personal_email1'] = 'required|email|unique:employees,personal_email1,' . $id . '';
        $validationRules['password'] = '';

        if (empty($input)) {
            $input = Input::all();
            $validationMessages = Employee::validationMessages();
            $validationRules = Employee::validationRules();
            $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result);
            }
            $loggedInUserId = Auth::guard('admin')->user()->id;
        } else {
            $loggedInUserId = $input['userData']['loggedInUserId'];
            unset($input['userData']['department_name']);
            unset($input['userData']['login_date_time']);
            unset($input['userData']['departmentid']);
            unset($input['userData']['loggedInUserId']);
            $imageName = $input['employee_photo_file_name'];
            $input['employee_photo_file_name'] = "";
            $input['userData']['employee_photo_file_name'] = '';
        }

        $input = Employee::doAction($input);
        $input['userData']['updated_date'] = date('Y-m-d');

        $input['userData']['updated_by'] = $loggedInUserId;
        $input['userData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
        $input['userData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $input['userData']['updated_mac_id'] = CommonFunctions::getMacAddress();

        unset($input['userData']['password_confirmation']);
        unset($input['userData']['passwordOld']);
        unset($input['userData']['password']);

        /*         * ************************* EMPLOYEE PHOTO UPLOAD ********************************* */
        if (!empty($input['employee_photo_file_name'])) {
            $originalName = $input['employee_photo_file_name']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $imgRules = array(
                    'employee_photo_file_name' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
                );
                $validateEmpPhotoUrl = Validator::make($input, $imgRules);
                if ($validateEmpPhotoUrl->fails()) {
                    $result = ['success' => false, 'message' => $validateEmpPhotoUrl->messages()];
                    return json_encode($result);
                } else {
                    $folderName = 'employee-photos';
                    $image = ['0' => $input['employee_photo_file_name']];
                    $imageName = S3::s3FileUpload($image, $folderName, 1);
                    $imageName = trim($imageName, ',');
                }
                $input['userData']['employee_photo_file_name'] = $imageName;
            }
        } else {
            $input['userData']['employee_photo_file_name'] = $imageName;
        }
        /*         * ************************* EMPLOYEE PHOTO UPLOAD ********************************* */

        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['userData'] = array_merge($input['userData'], $update);
        unset($input['userData']['$$hashKey']);

        $employeeUpdate = Employee::where('id', $id)->update($input['userData']);
        $getResult = array_diff_assoc($originalValues[0]['attributes'], $input['userData']);
        $pwdData = $originalValues[0]['attributes']['password'];
        unset($getResult['password']);
        $implodeArr = implode(",", array_keys($getResult));

        if ($employeeUpdate == 1) {
            $input['userData']['password'] = $pwdData;
            $input['userData']['main_record_id'] = $loggedInUserId;
            $input['userData']['record_type'] = 2;
            $input['userData']['column_names'] = $implodeArr;
            $input['userData']['record_restore_status'] = 1;
            EmployeesLog::create($input['userData']);
        }
        $result = ['success' => true, 'message' => 'Employee Updated Succesfully', 'empId' => $id];
        return json_encode($result);
    }

    public function destroy($id) {
        //
    }

    public function showpermissions() {
        return view("MasterHr::showpermissions");
    }

    public function userPermissions($id) {

        return view("MasterHr::userpermissions")->with("empId", $id);
    }

    public function rolePermissions($id) {
        return view("MasterHr::rolepermissions")->with("roleId", $id);
    }

    public function updatePermissions() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        $id = $input['data']['empId'];
        $roleId = $input['data']['roleId'];
        $getRolePermission = EmployeeRole::select('employee_submenus')->where('id', $roleId)->get();
        $updateRecord = Employee::where('id', $input['data']['empId'])->update(array('employee_submenus' => $getRolePermission[0]['employee_submenus'], 'client_role_id' => $roleId));
        $result = MasterHrController::arrangeMenu($getRolePermission[0]['employee_submenus']);
        return json_encode($result);
        if ($result) {
            $result = ['success' => true, "employeeSubmenus" => json_encode($menuItems)];
        } else {
            $result = ['success' => false, "message" => "Something went wrong"];
        }
        return json_encode($result);
    }

    public static function arrangeMenu($employeeSubmenus) {
        $getMenu = MenuItems::getMenuItems();
        if ($employeeSubmenus != '') {
            $permission = json_decode($employeeSubmenus, true);
            $menuItem = array();
            foreach ($getMenu as $key => $menu) {
                $submenu_ids = explode(',', $menu['submenu_ids']);
                if (count(array_intersect($submenu_ids, $permission)) == count($submenu_ids)) {
                    $menu['checked'] = true;
                }
                foreach ($menu['submenu'] as $k1 => $child1) {
                    if (!empty($child1['submenu'])) {
                        $submenu_ids1 = explode(',', $menu['submenu'][$k1]['submenu_ids']);
                        if (count(array_intersect($submenu_ids1, $permission)) == count($submenu_ids1)) {
                            $menu['submenu'][$k1]['checked'] = true;
                        }
                        foreach ($child1['submenu'] as $k2 => $child2) {
                            if (!empty($child2['submenu'])) {
                                $submenu_ids2 = explode(',', $menu['submenu'][$k1]['submenu'][$k2]['submenu_ids']);
                                if (count(array_intersect($submenu_ids2, $permission)) == count($submenu_ids2)) {
                                    $menu['submenu'][$k1]['submenu'][$k2]['checked'] = true;
                                }
                                foreach ($child2['submenu'] as $k3 => $child3) {
                                    if (!empty($child3['submenu'])) {
                                        $submenu_ids3 = explode(',', $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['submenu_ids']);
                                        if (count(array_intersect($submenu_ids3, $permission)) == count($submenu_ids3)) {
                                            $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['checked'] = true;
                                        }
                                    }
                                    if (in_array($child3['id'], $permission)) {
                                        $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['checked'] = true;
                                    }
                                }
                            } else {
                                if (in_array($child2['id'], $permission)) {
                                    $menu['submenu'][$k1]['submenu'][$k2]['checked'] = true;
                                }
                            }
                        }
                    } else {
                        if (in_array($child1['id'], $permission)) {
                            $menu['submenu'][$k1]['checked'] = true;
                        }
                    }
                }
                $menuItem[] = $menu;
            }
            ksort($menuItem);
            return $menuItem;
        } else {
            ksort($getMenu);
            return $getMenu;
        }
    }

    static public function getEmpName($arr1, $arr2) {
        if (!empty($arr2)) {
            foreach ($arr2 as $k => $v) {
                if ($k == $arr1) {
                    MasterHrController::$empArr = $arr2[$k];
                }
            }
        }
        return MasterHrController::$empArr;
    }

    public function getMenuListsForEmployee() {

        $getMenu = MenuItems::getMenuItems();
        $getEmployees = Employee::select('id', 'title_id', 'first_name', 'last_name', 'designation_id', 'employee_submenus')->get();

        if (!empty($getEmployees)) {
            $i = 0;
            $employee_submenus = $empchild1 = $arr = $arr1 = [];
            foreach ($getEmployees as $keyemp => $emp) {
                $menuItem = array();
                $arr = [];
                $emptitle = MlstTitle::select('title')->where('id', '=', $emp['title_id'])->first();
                $empdesignation = MlstBmsbDesignation::select('designation')->where(['id' => $emp['designation_id'], 'status' => 1])->first();

                if (!empty($empdesignation)) {
                    $empFullName = $emptitle->title . " " . $emp['first_name'] . " " . $emp['last_name'] . "-" . $empdesignation->designation;
                }
                $employee_submenus = json_decode($emp['employee_submenus'], true);
                foreach ($getMenu as $key => $menu) {
                    $arr = $arr1 = [];
                    $submenu_ids = explode(',', $menu['submenu_ids']);

                    foreach ($menu['submenu'] as $k1 => $child1) {
                        if (is_array($employee_submenus) && in_array($child1['id'], $employee_submenus)) {
                            $empchild1[$child1['id']][$emp['id']] = $empFullName;
                            $menu['submenu'][$k1]['emp'] = MasterHrController::getEmpName($child1['id'], $empchild1);
                        } else {
                            $menu['submenu'][$k1]['emp'] = MasterHrController::getEmpName($child1['id'], $empchild1);
                        }

                        if (!empty($child1['submenu'])) {

                            foreach ($child1['submenu'] as $k2 => $child2) {
                                if (is_array($employee_submenus) && in_array($child2['id'], $employee_submenus)) {
                                    $empchild1[$child2['id']][$emp['id']] = $empFullName;
                                    $menu['submenu'][$k1]['submenu'][$k2]['emp'] = MasterHrController::getEmpName($child2['id'], $empchild1);
                                } else {
                                    $menu['submenu'][$k1]['submenu'][$k2]['emp'] = MasterHrController::getEmpName($child2['id'], $empchild1);
                                }
                                if (!empty($child2['submenu'])) {

                                    foreach ($child2['submenu'] as $k3 => $child3) {
                                        if (is_array($employee_submenus) && in_array($child3['id'], $employee_submenus)) {
                                            $empchild1[$child3['id']][$emp['id']] = $empFullName;
                                            $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['emp'] = MasterHrController::getEmpName($child3['id'], $empchild1);
                                        } else {
                                            $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['emp'] = MasterHrController::getEmpName($child3['id'], $empchild1);
                                        }
                                        if (!empty($child3['submenu'])) {

                                            if (is_array($employee_submenus) && in_array($child3['id'], $employee_submenus)) {
                                                $empchild1[$child3['id']][$emp['id']] = $empFullName;
                                                $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['emp'] = MasterHrController::getEmpName($child3['id'], $empchild1);
                                            } else {
                                                $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['emp'] = MasterHrController::getEmpName($child3['id'], $empchild1);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $menuItem[] = $menu;
                }
                $i++;
            }
            ksort($menuItem);
            $result = ['success' => true, "getMenu" => $menuItem, "empdetail" => $empchild1];
        }
        return json_encode($result);
    }

    public function removeEmpID() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if (!empty($input)) {

            $getSubMenus = Employee::select('employee_submenus')->where('id', $input['empId'])->get();

            $getMenuItem = $tempMenuItem = [];
            if ($getSubMenus[0]['employee_submenus'] != '') {
                $getMenuItem = $tempMenuItem = json_decode($getSubMenus[0]['employee_submenus'], true);
            }
            $parentId = $submenuId = $getAllParent = $removeId = $arrdiff3 = $arrdiff2 = array();

            $submenuId = array_map(function($el) {
                $firstdigit = substr($el, 0, 1);
                if ($firstdigit !== '0')
                    return '0' . $el;
                else
                    return $el;
            }, $input['submenuId']);
            if (!empty($input['parentId'])) {
                $getMenu = MenuItems::getMenuItems();

                $parentId = array_map(function($el) {
                    $firstdigit = substr($el, 0, 1);
                    if ($firstdigit !== '0')
                        return '0' . $el;
                    else
                        return $el;
                }, $input['parentId']);
            }

            if (!empty($input['allChild2Id'])) { //[01401,0140102],[014010205], [0140101,0140102], [014010201,014010202,014010203,014010204,014010205]
                $allChild2Id = array_map(function($el) {
                    $firstdigit = substr($el, 0, 1);
                    if ($firstdigit !== '0')
                        return '0' . $el;
                    else
                        return $el;
                }, $input['allChild2Id']);

                if (!empty($input['allChild3Id'])) {
                    if (($key = array_search($parentId[1], $tempMenuItem)) !== false) {
                        unset($tempMenuItem[$key]);
                    }
                } else {
                    if (($key = array_search($submenuId[0], $tempMenuItem)) !== false) {
                        unset($tempMenuItem[$key]);
                    }
                }
                foreach ($allChild2Id as $chk2 => $ch2) {
                    if (in_array($ch2, $tempMenuItem)) {
                        $arrdiff2[] = $ch2;
                    }
                }
                if (count($arrdiff2) == 0) {
                    $removeId[] = $parentId[0];
                }
            }
            if (!empty($input['allChild3Id'])) { //[01401,0140102],[014010205], [0140101,0140102], [014010201,014010202,014010203,014010204,014010205]
                $allChild3Id = array_map(function($el) {
                    $firstdigit = substr($el, 0, 1);
                    if ($firstdigit !== '0')
                        return '0' . $el;
                    else
                        return $el;
                }, $input['allChild3Id']);

                if (($key = array_search($submenuId[0], $tempMenuItem)) !== false) {
                    unset($tempMenuItem[$key]);
                }

                foreach ($allChild3Id as $chk3 => $ch3) {
                    if (in_array($ch3, $tempMenuItem)) {
                        $arrdiff3[] = $ch3;
                    }
                }
                if (count($arrdiff3) == 0) {
                    $removeId[] = $parentId[1];
                }
            }

            $menuArr = array_merge($removeId, $submenuId);

            if (!empty($getMenuItem)) {
                $menuArr = array_unique(array_diff($getMenuItem, $menuArr)); //merge elements
            }

            asort($menuArr);
            $jsonArr = json_encode($menuArr, true);
            Employee::where('id', $input['empId'])->update(array('employee_submenus' => $jsonArr, 'menu_change_status' => 1));
            $result = ['success' => true];
            return json_encode($result);
        }
    }

    public function getMenuLists() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $permission = $rolepermission = [];
        $teams = array();

        $employeedetail = "";
        if (empty($input['data']['id']) || $input['data']['id'] == 0) {
            $getPermission = EmployeeRole::select('employee_submenus')->get();
        } else {
            if (!empty($input['data']['id'])) {
                $id = $input['data']['id'];
                $teams = Employee::where('team_lead_id', $id)->get();
            } else {
                $id = 0;
            }

            if ($input['data']['moduleType'] == 'roles') {
                $getPermission = EmployeeRole::select('role_name', 'employee_submenus')->where('id', $id)->get();
                $employeedetail = $getPermission[0]['role_name'];
            } else {
                $getPermission = Employee::select('title_id', 'first_name', 'last_name', 'employee_submenus')->where('id', $id)->get();
                /* This code for display - Roles - Title, first name, last name */
                $emptitle = \App\Models\MlstTitle::select('title')->where('id', '=', $getPermission[0]['title_id'])->first();
                $employeedetail = $emptitle->title . " " . $getPermission[0]['first_name'] . " " . $getPermission[0]['last_name'];
            }
            if ($getPermission[0]['employee_submenus'] !== '') {
                $permission = json_decode($getPermission[0]['employee_submenus'], true);
                $rolepermission = json_decode($getPermission[0]['employee_submenus']);
            }
        }

        $getMenu = MenuItems::getMenuItems();

        if (!empty($permission)) {
            $menuItem = array();
            foreach ($getMenu as $key => $menu) {
                $submenu_ids = explode(',', $menu['submenu_ids']);
                if (count(array_intersect($submenu_ids, $permission)) == count($submenu_ids)) {
                    $menu['checked'] = true;
                }
                foreach ($menu['submenu'] as $k1 => $child1) {
                    if ($child1['slug'] == 'Team' && count($teams) == 0) {
                        unset($menu['submenu'][$k1]);
                        continue;
                    }
                    if (!empty($child1['submenu'])) {
                        $submenu_ids1 = explode(',', $menu['submenu'][$k1]['submenu_ids']);
                        if (count(array_intersect($submenu_ids1, $permission)) == count($submenu_ids1)) {
                            $menu['submenu'][$k1]['checked'] = true;
                        }
                        foreach ($child1['submenu'] as $k2 => $child2) {
                            if ($child2['slug'] == 'Team' && count($teams) == 0) {
                                unset($menu['submenu'][$k1]['submenu'][$k2]);
                                continue;
                            }
                            if (!empty($child2['submenu'])) {
                                $submenu_ids2 = explode(',', $menu['submenu'][$k1]['submenu'][$k2]['submenu_ids']);
                                if (count(array_intersect($submenu_ids2, $permission)) == count($submenu_ids2)) {
                                    $menu['submenu'][$k1]['submenu'][$k2]['checked'] = true;
                                }
                                foreach ($child2['submenu'] as $k3 => $child3) {
                                    if (!empty($child3['submenu'])) {
                                        $submenu_ids3 = explode(',', $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['submenu_ids']);
                                        if (count(array_intersect($submenu_ids3, $permission)) == count($submenu_ids3)) {
                                            $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['checked'] = true;
                                        }
                                    }
                                    if (in_array($child3['id'], $permission)) {
                                        $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['checked'] = true;
                                    }
                                }
                            } else {
                                if (in_array($child2['id'], $permission)) {
                                    $menu['submenu'][$k1]['submenu'][$k2]['checked'] = true;
                                }
                            }
                        }
                    } else {
                        if (in_array($child1['id'], $permission)) {
                            $menu['submenu'][$k1]['checked'] = true;
                        }
                    }
                }
                $menuItem[] = $menu;
            }
            ksort($menuItem);
            $result = ['success' => true, "getMenu" => $menuItem, "totalPermissions" => count($permission), 'empName' => $employeedetail, 'role_name' => $employeedetail, 'menuId' => $rolepermission];
        } else {
            ksort($getMenu);
            $result = ['success' => true, "getMenu" => $getMenu, "totalPermissions" => count($permission), 'empName' => $employeedetail, 'role_name' => $employeedetail, 'menuId' => []];
        }
        return json_encode($result);
    }

    public function accessControl() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if (!empty($input)) {
            if ($input['data']['moduleType'] === 'roles') {
                $getSubMenus = EmployeeRole::select('employee_submenus')->where('id', $input['data']['empId'])->get();
            } else {
                $getSubMenus = Employee::select('employee_submenus')->where('id', $input['data']['empId'])->get();
            }

            $getMenuItem = [];
            if ($getSubMenus[0]['employee_submenus'] != '') {
                $getMenuItem = json_decode($getSubMenus[0]['employee_submenus'], true);
            }
//            $parentId = $submenuId = array();
            $tempMenuItem = $getMenuItem;
            $parentId = $submenuId = $getAllParent = $removeId = $arrdiff3 = $arrdiff2 = array();
            if (!empty($input['data']['isChecked'])) { //checkbox checked
                if (!empty($input['data']['parentId'])) {
                    $parentId = array_map(function($el) {
                        $firstdigit = substr($el, 0, 1);
                        if ($firstdigit !== '0')
                            return '0' . $el;
                        else
                            return $el;
                    }, $input['data']['parentId']);
                }
                $submenuId = array_map(function($el) {
                    $firstdigit = substr($el, 0, 1);
                    if ($firstdigit !== '0')
                        return '0' . $el;
                    else
                        return $el;
                }, $input['data']['submenuId']);

                $menuArr = array_merge($parentId, $submenuId);
                if (!empty($getMenuItem)) {
                    $menuArr = array_unique(array_merge($menuArr, $getMenuItem)); //merge elements
                }
                asort($menuArr);
                $jsonArr = json_encode($menuArr, true);
            } else {//checkbox unchecked    
                /* if (!empty($input['data']['parentId'])) {
                  $parentId = array_map(function($el) {
                  return '0' . $el;
                  }, $input['data']['parentId']);
                  }

                  $submenuId = array_map(function($el) {
                  return '0' . $el;
                  }, $input['data']['submenuId']);

                  $menuArr = array_merge($parentId, $submenuId); */

                /*                 * *********************************************************************** */
                $submenuId = array_map(function($el) {
                    $firstdigit = substr($el, 0, 1);
                    if ($firstdigit !== '0')
                        return '0' . $el;
                    else
                        return $el;
                }, $input['data']['submenuId']);
                if (!empty($input['data']['parentId'])) {
                    $getMenu = MenuItems::getMenuItems();

                    $parentId = array_map(function($el) {
                        $firstdigit = substr($el, 0, 1);
                        if ($firstdigit !== '0')
                            return '0' . $el;
                        else
                            return $el;
                    }, $input['data']['parentId']);
                }

                if (!empty($input['data']['allChild2Id'])) { //[01401,0140102],[014010205], [0140101,0140102], [014010201,014010202,014010203,014010204,014010205]
                    $allChild2Id = array_map(function($el) {
                        $firstdigit = substr($el, 0, 1);
                        if ($firstdigit !== '0')
                            return '0' . $el;
                        else
                            return $el;
                    }, $input['data']['allChild2Id']);

                    if (!empty($input['data']['allChild3Id'])) {
                        if (($key = array_search($parentId[1], $tempMenuItem)) !== false) {
                            unset($tempMenuItem[$key]);
                        }
                    } else {
                        if (($key = array_search($submenuId[0], $tempMenuItem)) !== false) {
                            unset($tempMenuItem[$key]);
                        }
                    }
                    foreach ($allChild2Id as $chk2 => $ch2) {
                        if (in_array($ch2, $tempMenuItem)) {
                            $arrdiff2[] = $ch2;
                        }
                    }
                    if (count($arrdiff2) == 0) {
                        $removeId[] = $parentId[0];
                    }
                }
                if (!empty($input['data']['allChild3Id'])) { //[01401,0140102],[014010205], [0140101,0140102], [014010201,014010202,014010203,014010204,014010205]
                    $allChild3Id = array_map(function($el) {
                        $firstdigit = substr($el, 0, 1);
                        if ($firstdigit !== '0')
                            return '0' . $el;
                        else
                            return $el;
                    }, $input['data']['allChild3Id']);

                    if (($key = array_search($submenuId[0], $tempMenuItem)) !== false) {
                        unset($tempMenuItem[$key]);
                    }

                    foreach ($allChild3Id as $chk3 => $ch3) {
                        if (in_array($ch3, $tempMenuItem)) {
                            $arrdiff3[] = $ch3;
                        }
                    }
                    if (count($arrdiff3) == 0) {
                        $removeId[] = $parentId[1];
                    }
                }

                $menuArr = array_merge($removeId, $submenuId);
                /*                 * ********************************************************************** */


                if (!empty($getMenuItem)) {
                    $menuArr = array_unique(array_diff($getMenuItem, $menuArr)); //merge elements
                }
                asort($menuArr);
                $jsonArr = json_encode($menuArr, true);
            }

            if ($input['data']['moduleType'] === 'roles') {
                EmployeeRole::where('id', $input['data']['empId'])->update(array('employee_submenus' => $jsonArr));
            } else {
                Employee::where('id', $input['data']['empId'])->update(array('employee_submenus' => $jsonArr));
            }
            $result = ['success' => true, "totalPermissions" => count($menuArr)];
            return json_encode($result);
        }
    }

    public function appAccessControl() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if ($input['data']['isChecked'] == true) {//checkbox checked
            //{"data":{"empId":2,"submenuId":[0307],"isChecked":true,"moduleType":"employee"},{"empId":2,"submenuId":[0107,0108,0201],"isChecked":false,"moduleType":"employee"}}
            if ($input['data']['moduleType'] === 'roles') {
                $getSubMenus = EmployeeRole::select('employee_submenus')->where('id', $input['data']['empId'])->get();
            } else {
                $getSubMenus = Employee::select('employee_submenus')->where('id', $input['data']['empId'])->get();
            }
            $getMenuItem = [];
            if ($getSubMenus[0]['employee_submenus'] != '') {
                $getMenuItem = json_decode($getSubMenus[0]['employee_submenus'], true);
            }

            if (!empty($getMenuItem)) {
                $menuArr = array_unique(array_merge($input['data']['submenuId'], $getMenuItem)); //merge elements
            } else {
                $menuArr = $input['data']['submenuId'];
            }
            asort($menuArr);
            $jsonArr = json_encode($menuArr, true);
            if ($input['data']['moduleType'] === 'roles') {
                EmployeeRole::where('id', $input['data']['empId'])->update(array('employee_submenus' => $jsonArr));
            } else {
                Employee::where('id', $input['data']['empId'])->update(array('employee_submenus' => $jsonArr));
            }
            $result = ['success' => true];
            return json_encode($result);
        }
    }

    public function orgchart() {
        return view("MasterHr::chart");
    }

    public function getChartData() {
        $input = Employee::whereIn('employee_status', [1, 2])
                ->leftJoin('laravel_developement_master_edynamics.mlst_bmsb_designations', 'employees.designation_id', '=', 'laravel_developement_master_edynamics.mlst_bmsb_designations.id')
                ->select('team_lead_id', 'designation', 'employees.id', 'first_name', 'last_name', 'employee_status', 'employee_photo_file_name')
                ->orderBy('team_lead_id')
                ->get();
        $data = array();
        foreach ($input as $key => $team) {
            $obj = Employee::where('employees.id', $team['id'])
                    ->leftJoin('laravel_developement_master_edynamics.mlst_bmsb_designations', 'employees.designation_id', '=', 'laravel_developement_master_edynamics.mlst_bmsb_designations.id')
                    ->whereIn('employee_status', [1, 2])
                    ->select('team_lead_id', 'designation', 'employees.id', 'first_name', 'last_name', 'employee_status', 'employee_photo_file_name')
                    ->get();
            if (!empty($obj)) {
                $data[$key]['v'] = $obj[0]->id;
                if (empty($team['employee_photo_file_name'])) {
                    $team['employee_photo_file_name'] = 'http://icons.iconarchive.com/icons/alecive/flatwoken/96/Apps-User-Online-icon.png';
                } else {
                    $team['employee_photo_file_name'] = config('global.s3Path') . '/employee-photos/' . $team['employee_photo_file_name'];
                }
                if ($team['employee_status'] == 2) {
                    $data[$key]['f'] = '<img src="' . $team['employee_photo_file_name'] . '" class="imgdata" style="border: 4px double #fd4949;"><div class="myblock" style="background-color: rgba(253, 42, 42, 0.85);">' . $team['first_name'] . ' ' . $team['last_name'] . '<br>' . $team['designation'] . '</div></div>';
                } else {
                    $data[$key]['f'] = '<img src="' . $team['employee_photo_file_name'] . '" class="imgdata" style="border: 4px double #2dc3e8;"><div class="myblock" style="background-color: rgb(45, 195, 232);">' . $team['first_name'] . ' ' . $team['last_name'] . '<br>' . $team['designation'] . '</div></div>';
                }
                if ($team['team_lead_id'] == '0') {
                    $data[$key]['teamId'] = $team['id'];
                } else {
                    $data[$key]['teamId'] = $team['team_lead_id'];
                }
                //$data[$key]['teamId'] = $team['team_lead_id'];
                $data[$key]['designation'] = $team['designation'];
            }
        }
        return $data;
    }

    public function appProfile() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $response = array();
        $authkey = trim($request["authkey"]);
        //checking for user related to authkey.
        $empModel = Employee::where('mobile_remember_token', $authkey)->first();
        if (!empty($empModel)) {
            $teams = array();
            $validate = Employee::where('client_id', $empModel->client_id)->get();
            $client = \App\Models\ClientInfo::where(['id' => $empModel->client_id])->first();
            foreach ($validate as $value) {
                $title = DB::connection('masterdb')->table('mlst_titles')->where('id', '=', $value->title_id)->select('title')->first();
                $value->title = $title->title;

                if (!empty($value->employee_photo_file_name)) {
                    $value->employee_photo_file_name = config('global.s3Path') . '/employee-photos/' . $value->employee_photo_file_name;
                } else {
                    $value->employee_photo_file_name = '';
                }

                if (!empty($value->department_id))
                    $value->department_id = explode(',', $value->department_id);
                $designations = DB::connection('masterdb')->table('mlst_bmsb_designations')->where('id', '=', $value->designation_id)->select('designation')->first();

                $value->designation = $designations->designation;


                $value->employee_menus = json_decode($value->employee_submenus);
                $teams[] = $value->getAttributes();
            }
            $this->allusers = array();
            $this->getTeamIds($empModel->id);
            $alluser = $this->allusers;
            $team_member = implode(',', $alluser);
            $response = $empModel->getAttributes();

            if (!empty($empModel->employee_photo_file_name)) {
                $response['employee_photo_file_name'] = config('global.s3Path') . '/employee-photos/' . $empModel->employee_photo_file_name;
            } else {
                $response['employee_photo_file_name'] = "";
            }
            if (!empty($empModel->department_id))
                $response['department_id'] = explode(',', $empModel->department_id);
            $title1 = DB::connection('masterdb')->table('mlst_titles')->where('id', '=', $empModel->title_id)->select('title')->first();
            $response['title'] = $title1->title;
            $designations = DB::connection('masterdb')->table('mlst_bmsb_designations')->where('id', '=', $empModel->designation_id)->select('designation')->first();
            $response['designation'] = $designations->designation;
            $response['employee_menus'] = json_decode($empModel->employee_submenus);
            $response['team_members'] = $team_member;
            $result = ['success' => true, 'Profile' => $response, 'teams' => $teams];
        }
        else {
            $result = ['success' => false, 'message' => "Login expired,please login again.."];
        }

        return json_encode($result);
    }

    public function getTeamIds($id) {
        $admin = \App\Models\backend\Employee::where(['team_lead_id' => $id])->get();
        if (!empty($admin)) {
            foreach ($admin as $item) {
                $this->allusers[$item->id] = $item->id;
                $this->getTeamIds($item->id);
            }
        } else {
            return;
        }
    }

    public function photoUpload() {
        $folderName = 'employee-photos';
        $imageName = S3::s3FileUploadForApp($_FILES['file'], $folderName, 1);
        if (!empty($imageName)) {
            $img = Employee::where('id', $_FILES['file']['type'])->update(array('employee_photo_file_name' => $imageName));
            if ($img) {
                $result = ['success' => true, 'message' => 'Image uploaded'];
                return json_encode($result);
            }
        } else {
            $result = ['success' => false, 'message' => 'Image not uploaded'];
            return json_encode($result);
        }
    }

    public function getTeamLead($id) {
        $employee = Employee::with('designationName')->select("id", "first_name", "last_name", 'designation_id')->where("id", "<>", $id)->orderBy("first_name", "ASC")->get();
        if (!empty($employee)) {
            $result = ['success' => true, 'records' => $employee];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getTeamLeadForQuick() {
        //$employee = Employee::select("id", "first_name", "last_name")->where("id", "<>", $id)->with('designationName')->get();
        $employee = Employee::with('designationName')->select("id", "first_name", "last_name", 'designation_id')->orderBy("first_name", "ASC")->get();

        if (!empty($employee)) {
            $result = ['success' => true, 'records' => $employee];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    /*     * *************** END (Organization Chart) ******************** */

    protected function guard() {
        return Auth::guard('admin');
    }

    public function profile() {
        return view("MasterHr::profile");
    }

    public function getProfileInfo() {
        $id = Auth::guard('admin')->user()->id;
        $employee = Employee::select('title_id', 'first_name', 'last_name', 'employee_photo_file_name', 'username')->where('id', $id)->first();
        $old_profile_photo = '';
        if (!empty($employee)) {

            $flag_profile_photo = 0;
            if (!empty($employee->employee_photo_file_name)) {
                $old_profile_photo = config('global.s3Path') . '/employee-photos/' . $employee->employee_photo_file_name;
                $flag_profile_photo = 1;
            }
            $result = ['success' => true, 'records' => $employee, 'old_profile_photo' => $old_profile_photo, 'flag_profile_photo' => $flag_profile_photo];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function updatePassword() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (!empty($request['data']['employee_id'])) {
            $id = $request['data']['employee_id'];
        } else {
            $id = Auth::guard('admin')->user()->id;
        }
        $employee = Employee::where('id', $id)->first();
        if (!empty($employee)) {
            if (!empty($request['data']['password'])) {
                $password = $request['data']['password'];
                $employee->password = \Hash::make($password);

                $templatedata['employee_id'] = $employee->id;
                $templatedata['client_id'] = $employee->client_id;
                $templatedata['template_setting_customer'] = 0;
                $templatedata['template_setting_employee'] = 27;
                $templatedata['event_id_customer'] = 0;
                $templatedata['event_id_employee'] = 53;
                $templatedata['customer_id'] = 0;
                $templatedata['model_id'] = 0;

                $templatedata['arrExtra'][0] = array(
                    '[#currentDate#]',
                    '[#currentTime#]',
                    '[#username#]',
                    '[#password#]'
                );
                $templatedata['arrExtra'][1] = array(
                    date('d-M-Y'),
                    date('h:s A'),
                    $employee->username,
                    $password
                );
                $result = CommonFunctions::templateData($templatedata);
                if ($employee->update()) {
                    $result = ['success' => true];
                    return json_encode($result);
                } else {
                    $result = ['success' => false];
                    return json_encode($result);
                }
            }
        }
    }

//    public function updateProfileInfo() {
//        $id = Auth::guard('admin')->user()->id;
//        $employee = Employee::where('id', $id)->first();
//        $request = Input::all();
//        $photo = [];
//        if (!empty($employee)) {
//            $imageName = time() . "." . $request['data']['employee_photo_file_name']->getClientOriginalExtension();
//            $tempPath = $request['data']['employee_photo_file_name']->getPathName();
//            $folderName = 'employee-photos';
//            $name = S3::s3FileUpload($tempPath, $imageName, $folderName);
//            $employee->employee_photo_file_name = $name;
//            if ($employee->update()) {
//                $photo = config('global.s3Path') . '/employee-photos/' . $name;
//                $result = ['success' => true, 'photo' => $photo];
//                return json_encode($result);
//            } else {
//                $result = ['success' => false];
//                return json_encode($result);
//            }
//        } else {
//            $result = ['success' => false];
//            return json_encode($result);
//        }
//    }

    public function updateProfileInfo() {
        $id = Auth::guard('admin')->user()->id;
        $employee = Employee::where('id', $id)->first();
        $request = Input::all();
        $photo = [];
        if (!empty($employee)) {
            $originalName = $request['data']['employee_photo_file_name']->getClientOriginalName();
            if ($originalName != "fileNotSelected") {
                $imageName = time() . "." . $request['data']['employee_photo_file_name']->getClientOriginalExtension();
                $tempPath = $request['data']['employee_photo_file_name']->getPathName();
                $folderName = 'employee-photos';
                $name = S3::s3FileUpload($tempPath, $imageName, $folderName);
                $employee->employee_photo_file_name = $name;
                $photo = config('global.s3Path') . 'employee-photos/' . $name;
            } else {
                unset($request['data']['employee_photo_file_name']);
            }
            if ($employee->update()) {
                $result = ['success' => true, 'photo' => $photo];
                return json_encode($result);
            } else {
                $result = ['success' => false];
                return json_encode($result);
            }
        } else {
            $result = ['success' => false];
            return json_encode($result);
        }
    }

    public function getquickuser() {

        return view("MasterHr::quickuser");
    }

    public function manageOtherPermission() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $result = Employee::where('employee_id', $request['employee_id'])->update($request['data']);
        $result = ['success' => true, 'result' => $result];
        return json_encode($result);
    }

    public function getOtherPermission() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $result = Employee::where('employee_id', $request['employee_id'])->select('customer_contact_numbers', 'customer_email')->first();
        $result = ['success' => true, 'result' => $result];
        return json_encode($result);
    }

    public function appCreateUser(Request $request) {
        $validationMessages = Employee::validationMessages();
        $validationRules = Employee::validationRules();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if (empty($input)) {
            $input = Input::all();
            $input['userData']['loggedInUserId'] = Auth::guard('admin')->user()->id;
            $input['userData']['client_id'] = 1;
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!empty($input['userData'])) {
            if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
                $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    echo json_encode($result, true);
                    exit;
                }
            }
            /*             * ************************ EMPLOYEE PHOTO UPLOAD ********************************* */
            if (!empty($input['employee_photo_file_name'])) {
                $imgRules = array(
                    'employee_photo_file_name' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
                );
                $validateEmpPhotoUrl = Validator::make($input, $imgRules);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    return json_encode($result);
                } else {
                    $folderName = 'employee-photos';
                    $imageName = 'hr' . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['employee_photo_file_name']->getClientOriginalExtension();
                    S3::s3FileUpload($input['employee_photo_file_name']->getPathName(), $imageName, $folderName);
                }
                $input['userData']['employee_photo_file_name'] = $imageName;
            }
            /*             * ************************ EMPLOYEE PHOTO UPLOAD ********************************* */

            $input['userData']['password'] = \Hash::make($input['userData']['password']);
            $input['userData']['remember_token'] = str_random(10);

            if (!empty($input['userData']['loggedInUserId'])) {
                $loggedInUserId = $input['userData']['loggedInUserId'];
            }
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['userData'] = array_merge($input['userData'], $create);
            $departmentData = [];
            if (!empty($input['userData']['department_id'])) {
                foreach ($input['userData']['department_id'] as $department_id) {

                    $department = $department_id['id'];
                    array_push($departmentData, $department);
                }
                $department_id = implode(',', $departmentData);
                $input['userData']['department_id'] = $department_id;
            }
//            $input = Employee::doAction($input);
            $employee = Employee::create($input['userData']); //insert data into employees table     

            $input['userData']['main_record_id'] = $employee->id;
            $input['userData']['record_type'] = 1;
            $input['userData']['record_restore_status'] = 1;
            EmployeesLog::create($input['userData']);   //insert data into employees_logs table

            if ($employee) {
                $result = ['success' => true, 'message' => 'Employee registeration successfully', "empId" => $employee->id];
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong.'];
            }
        }
        return json_encode($result);
    }

    public function createquickuser() {
        $validationRules = Employee::validationRulesQuick();
        $validationMessages = Employee::validationMessagesQuick();

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $request['data']['team_lead_id'] = $request['data']['team_to_id'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $validator = Validator::make($request['data'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                return json_encode($result, true);
            }
        }

        $departmentData = [];
        if (!empty($request['data']['loggedInUserId'])) {
            $loggedInUserId = $request['data']['loggedInUserId'];
        } else {
            $request['data']['loggedInUserId'] = Auth::guard('admin')->user()->id;
            $loggedInUserId = $request['data']['loggedInUserId'];
        }
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);

        $employee = new Employee();
        $employee->title_id = $request['data']['title_id'];
        $employee->employee_status = $request['data']['employee_status'];
        $employee->first_name = $request['data']['first_name'];
        $employee->last_name = $request['data']['last_name'];
        if (!empty($request['data']['personal_mobile1_calling_code']))
            $employee->personal_mobile1_calling_code = $request['data']['personal_mobile1_calling_code'];
        else
            $employee->personal_mobile1_calling_code = '91';

        $employee->personal_mobile1 = $request['data']['personal_mobile1'];
        $employee->joining_date = $request['data']['joining_date'];

        if (!empty($request['data']['department_id'])) {
            foreach ($request['data']['department_id'] as $department_id) {

                $department = $department_id['id'];
                array_push($departmentData, $department);
            }
            $department_id = implode(',', $departmentData);
            $employee->department_id = $department_id;
        }
        if (!empty($request['data']['personal_mobile2'])) {
            $personalMobileNo2 = explode("-", $request['data']['personal_mobile2']);
            if (!empty($personalMobileNo2[1])) {
                $personal_mobile2_calling_code = (int) $personalMobileNo2[0];
                $employee->personal_mobile2 = !empty($personalMobileNo2[1]) ? $personalMobileNo2[1] : NULL;
                $employee->personal_mobile2_calling_code = !empty($personal_mobile2_calling_code) ? $personal_mobile2_calling_code : NULL;
            }
        }

        $employee->office_mobile_no = $request['data']['office_mobile_no'];
        $request['data']['office_mobile_calling_code'] = '91';

        if (!empty($request['data']['personal_landline_no'])) {
            $landlineNo = explode("-", $request['data']['personal_landline_no']);
            if (!empty($landlineNo[1])) {
                $employee->personal_landline_no = (!empty($landlineNo[1])) ? $landlineNo[1] : "";
                $employee->personal_landline_calling_code = !empty($landlineNo[1]) ? (int) $landlineNo[0] : NULL;
            }
        }

        if (!empty($request['data']['personal_email1']))
            $employee->personal_email1 = $request['data']['personal_email1'];

        if (!empty($request['data']['office_email_id']))
            $employee->office_email_id = $request['data']['office_email_id'];

        $designation_id = 0;
        if (!empty($request['data']['designation_id']['id']))
            $designation_id = $request['data']['designation_id']['id'];
        else if (!empty($request['data']['designation_id']))
            $designation_id = $request['data']['designation_id'];

        $team_lead_id = 0;
        if (!empty($request['data']['team_to_id']['id']))
            $team_lead_id = $request['data']['team_to_id']['id'];
        else if (!empty($request['data']['team_lead_id']))
            $team_lead_id = $request['data']['team_lead_id'];

        $reporting_to_id = 0;
        if (!empty($request['data']['reporting_to_id']['id']))
            $reporting_to_id = $request['data']['reporting_to_id']['id'];
        else if (!empty($request['data']['reporting_to_id']))
            $reporting_to_id = $request['data']['reporting_to_id'];

        $employee->designation_id = $designation_id;
        $employee->reporting_to_id = $reporting_to_id;
        $employee->team_lead_id = $team_lead_id;

        $employee_submenus = array();
        if (!empty($request['data']['roleId']['id'])) {
            $employee_submenus = $request['data']['roleId']['employee_submenus'];
        } else if (!empty($request['data']['roleId'])) {
            $role_id = $request['data']['roleId'];
            $role = EmployeeRole::where('id', $role_id)->first();
            $employee_submenus = $role->employee_submenus;
        }

        if (!empty($employee_submenus))
            $employee->employee_submenus = $employee_submenus;
        else
            $employee->employee_submenus = '["0101","0102","0103","0104","0105","0106","0107"]';

        $employee->client_id = config('global.client_id');

        $employee->client_role_id = 1;
        $employee->high_security_password_type = 1;
        $employee->high_security_password = 1234;
        $employee->created_date = $create['created_date'];
        $employee->created_by = $create['created_by'];
        $employee->created_IP = $create['created_IP'];
        $employee->created_browser = $create['created_browser'];
        $employee->created_mac_id = $create['created_mac_id'];
        //$password = substr($request['data']['personal_mobile1'], 0, 6);
        $username = $request['data']['personal_mobile1'];
        //$employee->password = \Hash::make($password);
        $employee->username = $username;
        $employee->save();
        $employeelog = $employee->getAttributes();
        $employeelog['main_record_id'] = $employee->id;
        $employeelog['record_type'] = 1;
        $employeelog['record_restore_status'] = 1;
        EmployeesLog::create($employeelog);

        if (!empty($employee->id)) {
            $id = base64_encode($employee->id);
            $server_url = $_SERVER['HTTP_HOST'] . '/website/registration/' . $id;
            //$return_val = $this->shortenUrl($server_url); //live
            $return_val = $server_url; //localhost

            $templatedata['employee_id'] = $employee->id;


            $templatedata['client_id'] = config('global.client_id');
            $templatedata['template_setting_customer'] = 0;
            $templatedata['template_setting_employee'] = 25;
            $templatedata['event_id_customer'] = 0;
            $templatedata['event_id_employee'] = 7;
            $templatedata['customer_id'] = 0;
            $templatedata['model_id'] = 0;
            $templatedata['arrExtra'][0] = array(
                '[#employeeRegistrationLink#]'
            );
            $templatedata['arrExtra'][1] = array(
                //$return_val['id'],
                $return_val
            );
            $result = CommonFunctions::templateData($templatedata);
            $res = ['success' => true, 'message' => 'Employee registered successfully', "empId" => $employee->id];
            return json_encode($res);
        } else {
            $result = ['success' => false, 'message' => 'something went wrong. try again later'];
            return json_encode($result);
        }
    }

    public function updateRoles() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        $role_id = $input['roleId'];
        $rolename = $input['role_name'];
        if (!empty($role_id)) {
            $menuArr = $input['submenuId'];
            asort($menuArr);
            $jsonArr = json_encode($menuArr, true);
            EmployeeRole::where('id', $role_id)->update(array('employee_submenus' => $jsonArr, 'role_name' => $rolename));

            $result = ['success' => true];
            return json_encode($result);
        } else {
            $result = ['success' => false];
            return json_encode($result);
        }
    }

    public function shortenUrl($longUrl) {
        $data = array('longUrl' => $longUrl);
        $data_string = json_encode($data);
        $ch = @curl_init('https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyBC0YOgQJFeoD1m4eFJj-rEggFksB7HW4M');
        @curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
        );
        $result = @curl_exec($ch);
        return json_decode($result, true);
    }

    /* create user role for save code */

    public function createRole() {
        return view("MasterHr::createrole");
    }

    public function createUserRole() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        if (!empty($input)) {
            if (empty($input['data']['loggedInUserId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $input['data']['loggedInUserId'];
            }
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $checkRole = EmployeeRole::select("role_name")->where("role_name", $input['data']['role_name'])->get();
            if (empty($checkRole[0]['role_name'])) {
                $employeeRole = new EmployeeRole();
                $employeeRole->role_name = $input['data']['role_name'];
                $input['data']['masterRole'] = array_filter($input['data']['masterRole']);
                asort($input['data']['masterRole']);
                $jsonArr = json_encode($input['data']['masterRole'], true);
                $employeeRole->employee_submenus = $jsonArr;
                $employeeRole->client_id = config('global.client_id');
                $employeeRole->created_date = $create['created_date'];
                $employeeRole->created_by = $create['created_by'];
                $employeeRole->created_IP = $create['created_IP'];
                $employeeRole->created_browser = $create['created_browser'];
                $employeeRole->created_mac_id = $create['created_mac_id'];
                $employeeRole->save();
                $result = ['success' => true];
            } else {
                $result = ['success' => false, 'message' => $input['data']['role_name'] . ' role already exist'];
            }
        } else {
            $result = ['success' => false, 'message' => 'something went wrong. try again later'];
        }
        return \Response()->json($result);
    }

    public function updateUserRole() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        $originalValues = EmployeeRole::select("role_name", "employee_submenus")->where("id", $input['data']['roleId'])->get();
        if (!empty($input)) {

            if (empty($input['data']['loggedInUserId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $input['data']['loggedInUserId'];
            }
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            if (!empty($input['data']['masterRole'])) {
                $input['data']['masterRole'] = array_filter($input['data']['masterRole']);
                $input['data']['masterRole'] = array_map(function($el) {
                    substr($el, 0, 1);
                    if (substr($el, 0, 1) != 0) {
                        return '0' . $el;
                    } else {
                        return $el;
                    }
                }, $input['data']['masterRole']);
                asort($input['data']['masterRole']);
                $jsonArr = json_encode($input['data']['masterRole'], true);
            } else {
                $jsonArr = $originalValues[0]['employee_submenus'];
            }

            if (!empty($input['data']['role_name'])) {
                $rolename = $input['data']['role_name'];
            }

            $employeeUpdate = EmployeeRole::where('id', $input['data']['roleId'])->update(["employee_submenus" => $jsonArr, 'role_name' => $rolename,
                'updated_date' => $update['updated_date'], 'updated_IP' => $update['updated_IP'], 'updated_browser' => $update['updated_browser'], 'updated_mac_id' => $update['updated_mac_id']]);

            $result = ['success' => true];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. try again later'];
        }
        return \Response()->json($result);
    }

}
