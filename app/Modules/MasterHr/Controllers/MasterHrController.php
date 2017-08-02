<?php

namespace App\Modules\MasterHr\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\backend\Employee;
use App\Models\EmployeesLog;
use App\Modules\ManageDepartment\Models\MlstBmsbDepartment;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Classes\Gupshup;
use App\Classes\MenuItems;
use App\Classes\S3;
use App\Modules\MasterHr\Models\EmployeeRole;
use App\Models\MlstBmsbDesignation;
use Session;

class MasterHrController extends Controller {

    public function __construct() {

        /* $routeName = \Route::getCurrentRoute()->getActionName();
          $actionName = substr($routeName, strpos($routeName, "@") + 1);
          $actionArr = ["create" => "030102", "store" => "030102","edit" => "030102", "update" => "030102", 'index' => '030101', 'manageUsers' => '030101',
          'orgchart' => '030104','getChartData' => '030104','manageRolesPermission' => '030101','getRoles' => '030101', 'getDepartmentsToEdit' => '030102','editDepartments' => '030102',
          'userPermissions' => '030101','getMenuLists'=>'030101','accessControl' => '030101','updatePermissions' => '030101',
          'rolePermissions' => '030101','changePassword' => '030101'];
          if(!empty($actionArr[$actionName])){
          $this->middleware('check-permission',['only' => $actionArr[$actionName]]);
          //          $this->middleware('check-permission:'.$actionArr[$actionName]);
          } */
    }

    public function index() {
        return view("MasterHr::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

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

    public function manageUsers() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageUsers = [];

        if (!empty($request['empId']) && $request['empId'] !== "0") { // for edit
            $manageUsers = DB::select('CALL proc_manage_users(1,' . $request["empId"] . ')');
        } else if ($request['empId'] === "") { // for index
            $manageUsers = DB::select('CALL proc_manage_users(0,0)');
        }
        if ($manageUsers) {
            $result = ['success' => true, "records" => ["data" => $manageUsers, "total" => count($manageUsers), 'per_page' => count($manageUsers), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageUsers)]];
            echo json_encode($result);
        }
    }

    public function appProfile() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        /*
          $postdata = file_get_contents("php://input");
          $request = json_decode($postdata, true);

          $getProfileDetails = Employee::select('title_id', 'first_name', 'last_name', 'date_of_birth', 'gender_id', 'personal_mobile1', 'personal_mobile1', 'department_id', 'designation_id', 'team_lead_id', 'joining_date'
          , 'employee_photo_file_name')->where('id', $request['id'])->get();
          if (!empty($getProfileDetails)) {
          $result = ['success' => true, "records" => $getProfileDetails];
          } else {
          $result = ['success' => false, "records" => "No records found"];
          }
          echo json_encode($result);
         * */
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
                    $value->employee_photo_file_name = config('global.s3Path') . 'employee-photos/' . $value->employee_photo_file_name;
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
                $response['employee_photo_file_name'] = config('global.s3Path') . 'employee-photos/' . $empModel->employee_photo_file_name;
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

    public function manageRolesPermission() {
        if (Auth::guard('admin')->user()->id == 1) {
            $roles = EmployeeRole::all();
            return view("MasterHr::manageroles")->with("roles", $roles);
        }
    }

    public function getRoles() {
        $roles = EmployeeRole::all();
        if (!empty($roles)) {
            $result = ['success' => true, "list" => $roles];
        } else {
            $result = ['success' => false, "message" => "No records found"];
        }
        echo json_encode($result);
    }

    public function checkUniqueEmpId() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $checkEmpIdExist = Employee::select("employee_id")->where([['employee_id', '=', $request['employeeId']],
                    ['id', '<>', $request['recordId']]])->get();

        if (!empty($checkEmpIdExist[0]['employee_id'])) {
            $result = ['success' => false, "message" => "Employee id already exist."];
        } else {
            $result = ['success' => true];
        }
        return \Response::json($result);
    }

    public function changePassword() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (!empty($request['empId'])) {
            //send msg code
            //send email code
            $strRandomNo = str_random(4);
            $changedPassword = \Hash::make($strRandomNo);
            DB::table('employees')
                    ->where('id', $request['empId'])
                    ->update(['password' => $changedPassword]);
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $post = [
                'client_id' => $loggedInUserId,
                'employee_id' => $request['empId'],
                'password' => $strRandomNo,
                'status' => '1',
                'username' => $request['username'],
            ];
            DB::table('employee_password_history')->where('employee_id', $request['empId'])->update(['status' => '0']);
            $common = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $create = array_merge($common, $post);
            $result = DB::table('employee_password_history')->insert($create);
            if ($result > 0) {
                $select = DB::table('employees')->where('id', $request['empId'])->select('personal_email1')->first();
                if (!empty($select->personal_email1)) {
                    $userName = "support@edynamics.co.in";
                    $password = "edsupport@2016#";
                    $mailBody = "your account password is" . " " . $strRandomNo . "<br><br>" . "Thank You!";
                    $companyName = config('global.companyName');
                    $subject = "Mail subject";
                    $data = ['mailBody' => $mailBody, "fromEmail" => "support@edynamics.co.in", "fromName" => $companyName, "subject" => $subject, "to" => $select->personal_email1, "cc" => "umabshinde@gmail.com"];
                    $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
                }
            }
            $smsBody = "your account password is" . " " . $strRandomNo . "<br><br>" . "Thank You!";
            //$mobileNo = 917709026395; //9970844335;
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $customer = "No";
            $customerId = $request['empId'];
            $isInternational = 0; //0 OR 1
            $sendingType = 0; //always 0 for T_SMS
            $smsType = "T_SMS";
            $result = Gupshup::sendSMS($smsBody, $request['username'], $loggedInUserId, $customer, $customerId, $isInternational, $sendingType, $smsType);
            $decodeResult = json_decode($result, true);

            $result = ['success' => true, "successMsg" => "Password has been changed as well as Mail and sms has been sent to selected user."];
            echo json_encode($result);
        } else {
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
            $input = Employee::doAction($input);
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

//    public function editDepartments() {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
//        $getDepartmentsFromEmployee = Employee::select('department_id')->where('id', $request['data'])->get();
//        $explodeDepartment = explode(",", $getDepartmentsFromEmployee[0]->department_id);
//        $getDepartments = MlstBmsbDepartment::whereNotIn('id', $explodeDepartment)->get();
//        if (!empty($getDepartments)) {
//            $result = ['success' => true, 'records' => $getDepartments];
//            return $result;
//        } else {
//            $result = ['success' => false, 'message' => 'Something went wrong'];
//            return json_encode($result);
//        }
//    }

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

        $validationMessages = Employee::validationMessages();
        $validationRules = Employee::validationRules();
        $validationRules['personal_email1'] = 'required|email|unique:employees,personal_email1,' . $id . '';
        $validationRules['password'] = '';

        if (empty($input)) {
            $input = Input::all();
            if ($input['userData']['physic_desc'] == "")
                $input['userData']['physic_desc'] == "";
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
                    $path = "/" . $folderName . "/" . $originalValues[0]['employee_photo_file_name'];
                    S3::s3FileDelete($path);

                    $imageName = 'hr_' . $id . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['employee_photo_file_name']->getClientOriginalExtension();
                    $val = S3::s3FileUpload($input['employee_photo_file_name']->getPathName(), $imageName, $folderName);
                }
                $input['userData']['employee_photo_file_name'] = $imageName;
            }
        } else {
            $input['userData']['employee_photo_file_name'] = "a.jpg";
        }
        /*         * ************************* EMPLOYEE PHOTO UPLOAD ********************************* */

        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['userData'] = array_merge($input['userData'], $update);
        $employeeUpdate = Employee::where('id', $id)->update($input['userData']);
        $getResult = array_diff_assoc($originalValues[0]['attributes'], $input['userData']);
        $pwdData = $originalValues[0]['attributes']['password'];
        unset($getResult['password']);
        $implodeArr = implode(",", array_keys($getResult));

        if ($employeeUpdate == 1) {
            $input['userData']['password'] = $pwdData;
            $input['userData']['main_record_id'] = $id;
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

    public function getMenuLists() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $id = $input['data']['id'];
        if ($input['data']['moduleType'] == 'roles') {
            $getPermission = EmployeeRole::select('employee_submenus')->where('id', $id)->get();
        } else {
            $getPermission = Employee::select('employee_submenus')->where('id', $id)->get();
        }


        $getMenu = MenuItems::getMenuItems();
        $permission = json_decode($getPermission[0]['employee_submenus'], true);
        if (!empty($permission)) {
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
            $result = ['success' => true, "getMenu" => $menuItem, "totalPermissions" => count($permission)];
        } else {
            ksort($getMenu);
            $result = ['success' => true, "getMenu" => $getMenu, "totalPermissions" => count($permission)];
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
            $parentId = $submenuId = array();
            if (!empty($input['data']['isChecked'])) { //checkbox checked
                if (!empty($input['data']['parentId'])) {
                    $parentId = array_map(function($el) {
                        return '0' . $el;
                    }, $input['data']['parentId']);
                }
                $submenuId = array_map(function($el) {
                    return '0' . $el;
                }, $input['data']['submenuId']);

                $menuArr = array_merge($parentId, $submenuId);
                if (!empty($getMenuItem)) {
                    $menuArr = array_unique(array_merge($menuArr, $getMenuItem)); //merge elements
                }
                asort($menuArr);
                $jsonArr = json_encode($menuArr, true);
            } else {//checkbox unchecked    
                if (!empty($input['data']['parentId'])) {
                    $parentId = array_map(function($el) {
                        return '0' . $el;
                    }, $input['data']['parentId']);
                }

                $submenuId = array_map(function($el) {
                    return '0' . $el;
                }, $input['data']['submenuId']);

                $menuArr = array_merge($parentId, $submenuId);
//print_R($menuArr);
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

    /*     * **************** END (Organization Chart) ******************** */

    public function orgchart() {
        return view("MasterHr::chart");
    }

    public function getChartData() {
        $input = Employee::whereIn('employee_status', [1, 2])
                ->leftJoin('lmsauto_master_final.mlst_lmsa_designations', 'employees.designation_id', '=', 'lmsauto_master_final.mlst_lmsa_designations.id')
                ->select('team_lead_id', 'designation', 'employees.id', 'first_name', 'last_name', 'employee_status', 'employee_photo_file_name')
                ->orderBy('team_lead_id')
                ->get();
        $data = array();
        foreach ($input as $key => $team) {
            $obj = Employee::where('employees.id', $team['id'])
                    ->leftJoin('lmsauto_master_final.mlst_lmsa_designations', 'employees.designation_id', '=', 'lmsauto_master_final.mlst_lmsa_designations.id')
                    ->whereIn('employee_status', [1, 2])
                    ->select('team_lead_id', 'designation', 'employees.id', 'first_name', 'last_name', 'employee_status', 'employee_photo_file_name')
                    ->get();
            if (!empty($obj)) {
                $data[$key]['v'] = $obj[0]->id;
                if (empty($team['employee_photo_file_name'])) {
                    $team['employee_photo_file_name'] = 'http://icons.iconarchive.com/icons/alecive/flatwoken/96/Apps-User-Online-icon.png';
                } else {
                    $team['employee_photo_file_name'] = 'https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/employee-photos/' . $team['employee_photo_file_name'];
                    // $team['employee_photo_file_name'] ='https://s3.ap-south-1.amazonaws.com/bmsbuilderv2/hr/employee-photos/1492516782.jpg';
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

    public function photoUpload() {
        $folderName = 'employee-photos';
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $imageFileName = time() . '.' . $ext;
        S3::s3FileUpload($_FILES['file']['tmp_name'], $imageFileName, $folderName);

        if ($imageFileName) {
            $img = Employee::where('id', $_FILES['file']['type'])->update(array('employee_photo_file_name' => $imageFileName));
            if ($img) {
                $result = ['success' => true, 'message' => 'Image uploaded'];
                return json_encode($result);
            }
        } else {
            $result = ['success' => false, 'message' => 'Image not uploaded'];
            return json_encode($result);
        }
    }

    /*     * *************** END (Organization Chart) ******************** */

    public function profile() {
        return view("MasterHr::profile");
    }

    public function getProfileInfo() {
        $id = Auth::guard('admin')->user()->id;
        $employee = Employee::select('title_id', 'first_name', 'last_name', 'employee_photo_file_name', 'username')->where('id', $id)->first();

        if (!empty($employee)) {

            $flagProfilePhoto = 0;
            if (!empty($employee->employee_photo_file_name)) {
                $profilePhoto = config('global.s3Path') . 'employee-photos/' . $employee->employee_photo_file_name;
                $flagProfilePhoto = 1;
            }
            $result = ['success' => true, 'records' => $employee, 'profilePhoto' => $profilePhoto, 'flagProfilePhoto' => $flagProfilePhoto];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function updateProfileInfo() {
        $id = Auth::guard('admin')->user()->id;
        $employee = Employee::where('id', $id)->first();
        $request = Input::all();

        if (!empty($employee)) {
            $imageName = time() . "." . $request['data']['employee_photo_file_name']->getClientOriginalExtension();
            $tempPath = $request['data']['employee_photo_file_name']->getPathName();

            $folderName = 'employee-photos';

            $path = "/" . $folderName . "/" . $employee->employee_photo_file_name;
            S3::s3FileDelete($path);

            $imageName = 'hr' . '_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $request['data']['employee_photo_file_name']->getClientOriginalExtension();
            S3::s3FileUpload($tempPath, $imageName, $folderName);

            $employee->employee_photo_file_name = $imageName;
            if (!empty($request['data']['password']) && $request['data']['changePasswordflag'] == true) {
                $password = $request['data']['password'];
                $employee->password = \Hash::make($password);

                $templatedata['employee_id'] = $employee->id;
                $templatedata['client_id'] = $employee->client_id;
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
            }
            if ($employee->update()) {
                $result = ['success' => true, "profilePhoto" => $imageName];
            } else {
                $result = ['success' => false];
            }
        } else {
            $result = ['success' => false];
        }
        return \Response()->json($result);
    }

    public function updatePassword() {
        $id = Auth::guard('admin')->user()->id;
        $employee = Employee::where('id', $id)->first();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
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

    public function showQuickUser() {
        return view("MasterHr::quickuser")->with("empId", Auth::guard('admin')->user()->id);
    }

//    public function createQuickUser() {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
//
//        if (!empty($request['data']['loggedInUserId'])) {
//            $loggedInUserId = $request['data']['loggedInUserId'];
//        } else {
//            $request['data']['loggedInUserId'] = Auth::guard('admin')->user()->id;
//            $loggedInUserId = $request['data']['loggedInUserId'];
//        }
//
//        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
//        $role_id = $request['data']['roleId'];
//        $role = EmployeeRole::where('id', $role_id)->first();
//
//        $employee = new Employee();
//        $employee->client_id = 1;
//        $employee->title_id = $request['data']['title_id'];
//        $employee->employee_status = $request['data']['employee_status'];
//        $employee->first_name = $request['data']['first_name'];
//        $employee->last_name = $request['data']['last_name'];
//        $personalMobileNo1 = explode("-", $request['data']['personal_mobile1']);
//        $employee->personal_mobile1_calling_code = (int) $personalMobileNo1[0];
//        $employee->personal_mobile1 = $personalMobileNo1[1];
//
//        if (!empty($request['data']['personal_mobile2'])) {
//            $personalMobileNo2 = explode("-", $request['data']['personal_mobile2']);
//            if (!empty($personalMobileNo2[1])) {
//                $personal_mobile2_calling_code = (int) $personalMobileNo2[0];
//                $employee->personal_mobile2 = !empty($personalMobileNo2[1]) ? $personalMobileNo2[1] : NULL;
//                $employee->personal_mobile2_calling_code = !empty($personal_mobile2_calling_code) ? $personal_mobile2_calling_code : NULL;
//            }
//        }
//
//        $officeMobileNo = explode("-", $request['data']['office_mobile_no']);
//        if (!empty($officeMobileNo[1])) {
//            $employee->office_mobile_calling_code = (int) $officeMobileNo[0];
//            $employee->office_mobile_no = $officeMobileNo[1];
//        }
//
//        if (!empty($request['data']['personal_landline_no'])) {
//            $landlineNo = explode("-", $request['data']['personal_landline_no']);
//            if (!empty($landlineNo[1])) {
//                $employee->personal_landline_no = (!empty($landlineNo[1])) ? $landlineNo[1] : "";
//                $employee->personal_landline_calling_code = !empty($landlineNo[1]) ? (int) $landlineNo[0] : NULL;
//            }
//        }
//
//        if (!empty($request['data']['personal_email1']))
//            $employee->personal_email1 = $request['data']['personal_email1'];
//
//        if (!empty($request['data']['office_email_id']))
//            $employee->office_email_id = $request['data']['office_email_id'];
//
//        $latest_employee = Employee::latest('id')->first();
//        if (!empty($latest_employee->employee_id)) {
//            $employee->employee_id = $latest_employee->employee_id + 1;
//        } else {
//            $employee->employee_id = 1;
//        }
//
//        $employee->designation_id = $request['data']['designation_id'];
//        $employee->reporting_to_id = $request['data']['reporting_to_id'];
//        $employee->team_lead_id = $request['data']['team_lead_id'];
//        $employee->employee_submenus = $role->employee_submenus;
//        $employee->client_id = config('global.client_id');
//        $employee->client_role_id = 1;
//        $employee->high_security_password_type = 1;
//        $employee->high_security_password = 1234;
//        $employee->created_date = $create['created_date'];
//        $employee->created_by = $create['created_by'];
//        $employee->created_IP = $create['created_IP'];
//        $employee->created_browser = $create['created_browser'];
//        $employee->created_mac_id = $create['created_mac_id'];
//        $password = substr($request['data']['username'], 0, 6);
//        $username = $request['data']['username'];
//        $employee->password = \Hash::make($password);
//        $employee->username = $username;
//        $employee->save();
//
//        $employeelog = $employee->getAttributes();
//        $employeelog['main_record_id'] = $employee->id;
//        $employeelog['record_type'] = 1;
//        $employeelog['record_restore_status'] = 1;
//        EmployeesLog::create($employeelog);
//
//        if (!empty($employee->id)) {
//            $templatedata['employee_id'] = $employee->id;
//            $templatedata['client_id'] = config('global.client_id');
//            $templatedata['event_id_customer'] = 0;
//            $templatedata['event_id_employee'] = 7;
//            $templatedata['customer_id'] = 0;
//            $templatedata['model_id'] = 0;
//
//            $templatedata['arrExtra'][0] = array(
//                '[#username#]',
//                '[#password#]',
//                '[#secuiry_password#]'
//            );
//            $templatedata['arrExtra'][1] = array(
//                $username,
//                $password,
//                '1234'
//            );
//            $result = CommonFunctions::templateData($templatedata);
//            $res = ['success' => true, 'message' => 'Employee registeration successfully', "empId" => $employee->id];
//        } else {
//            $result = ['success' => false, 'message' => 'something went wrong. try again later'];
//        }
//        return json_encode($result);
//    }


    public function createquickuser() {
        $validationRules = Employee::validationRules1();
        $validationMessages = Employee::validationMessages1();

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

    protected function guard() {
        return Auth::guard('admin');
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

}
