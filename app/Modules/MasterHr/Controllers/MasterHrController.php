<?php
namespace App\Modules\MasterHr\Controllers;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use App\Models\backend\Employee;
use App\Models\EmployeesLog;
use App\Models\MlstDepartment;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Classes\MenuItems;
use s3;
use App\Modules\MasterHr\Models\EmployeeRole;

class MasterHrController extends Controller {
   
    public function __construct()
    {
        $this->middleware('web');
    }
    
    public function index() { 
        return view("MasterHr::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
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
                $dept = MlstDepartment::select('department_name')->whereRaw("id IN($user->department_id)")->get();
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
    
    public function manageRoles() {
        if( Auth::guard('admin')->user()->id == 1){ 
            $roles = EmployeeRole::all();
            return view("MasterHr::manageroles")->with("roles",$roles);
        }
    }
    public function getRoles() {
        if( Auth::guard('admin')->user()->id == 1){ 
            $roles = EmployeeRole::all();
            if(!empty($roles)){
                $result = ['success' => true, "list" => $roles];
                echo json_encode($result);
            }else{
                $result = ['success' => false, "message" => "No records found"];
                echo json_encode($result);
            }
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
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if(!empty($input['userData'])){
            if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$userAgent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($userAgent,0,4))){
                $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    echo json_encode($result,true);
                    exit;
                }
            }
            
            /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
            if(!empty($input['emp_photo_url'])){
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
                $input['userData']['emp_photo_url'] = $fileName;
            }
            /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
            
            $input['userData']['password'] = \Hash::make($input['userData']['password']);
            $input['userData']['remember_token'] = str_random(10);
          // $input['userData'][''] = '0000:00:00';
            if(!empty($input['userData']['loggedInUserId'])){
                $loggedInUserId = $input['userData']['loggedInUserId'];
            }
            else{
                $loggedInUserId = Auth::guard('admin')->user()->id;
            }
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['userData'] = array_merge($input['userData'],$create);            
            $input = Employee::doAction($input);
            $employee = Employee::create($input['userData']); //insert data into employees table            
            $input['userData']['main_record_id'] = $loggedInUserId;
            $input['userData']['main_record_id'] = $loggedInUserId;
            $input['userData']['record_type'] = 1;
            $input['userData']['record_restore_status'] = 1;            
            EmployeesLog::create($input['userData']);   //insert data into employees_logs table
            if ($employee) {
                $result = ['success' => true, 'message' => 'Employee registeration successfully', "empId" => $employee->id];
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
        $getDepartments = MlstDepartment::whereNotIn('id', $explodeDepartment)->get();
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
        $getdepts = MlstDepartment::whereIn('id', $arr)->get();
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
        
        $postdata = file_get_contents("php://input");
        $input  = json_decode($postdata, true);
        if(empty($input)){
            $input = Input::all();
        }
           
        $validator = Validator::make($input['userData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
        
        $input = Employee::doAction($input);
        $input['userData']['updated_date'] = date('Y-m-d');
        if(!empty($input['userData']['loggedInUserId'])){
            $loggedInUserId = $input['userData']['loggedInUserId'];
            unset($input['userData']['department_name']);
            unset($input['userData']['login_date_time']);
            unset($input['userData']['departmentid']);
            unset($input['userData']['loggedInUserId']);       
        }
        else{
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $input['userData']['updated_by'] = $loggedInUserId;
        $input['userData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
        $input['userData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $input['userData']['updated_mac_id'] = CommonFunctions::getMacAddress();
        
        unset($input['userData']['password_confirmation']);
        unset($input['userData']['passwordOld']);
        unset($input['userData']['password']);      
        
        /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
        if(!empty($input['emp_photo_url'])){
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
        }
        /*************************** EMPLOYEE PHOTO UPLOAD **********************************/
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['userData'] = array_merge($input['userData'],$update);
        $employeeUpdate = Employee::where('id',$id)->update($input['userData']);  
        $getResult = array_diff_assoc($originalValues[0]['attributes'], $input['userData']);
        $pwdData=$originalValues[0]['attributes']['password'];
        unset($getResult['password']);
        $implodeArr =  implode(",",array_keys($getResult));        
        if ($employeeUpdate == 1) {
            $input['userData']['password'] = $pwdData;            
            $input['userData']['main_record_id'] = $loggedInUserId;
            $input['userData']['record_type'] = 2;
            $input['userData']['column_names'] = $implodeArr;
            $input['userData']['record_restore_status'] = 1;
            EmployeesLog::create($input['userData']);   
        }
        $result = ['success' => true, 'message' => 'Employee Updated Succesfully','empId'=>$id];
        return json_encode($result);
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
    
    public function userPermissions($id) {
        return view("MasterHr::userpermissions")->with("empId", $id);
    }
    public function rolePermissions($id) {
        return view("MasterHr::rolepermissions")->with("roleId", $id);
    }
    public function getMenuLists() {
        $postdata = file_get_contents("php://input");
        $input  = json_decode($postdata, true);
        $id = $input['data']['id'];
        if($input['data']['moduleType'] == 'roles'){
            $getPermission = EmployeeRole::select('employee_submenus')->where('id', $id)->get();
        }else{
            $getPermission = Employee::select('employee_submenus')->where('id', $id)->get();
        }

        $getMenu = MenuItems::getMenuItems();
        
        if($getPermission[0]['employee_submenus'] != ''){
            $permission = json_decode($getPermission[0]['employee_submenus'],true);
            $menuItem = array();
            foreach ($getMenu as $key => $menu) {
                $submenu_ids = explode(',', $menu['submenu_ids']);
                if(count(array_intersect($submenu_ids, $permission)) == count($submenu_ids)){
                    $menu['checked'] = true;
                }
                foreach ($menu['submenu'] as $k1 => $child1) {
                    if(!empty($child1['submenu'])){
                        $submenu_ids1 = explode(',', $menu['submenu'][$k1]['submenu_ids']);
                        if(count(array_intersect($submenu_ids1, $permission)) == count($submenu_ids1)){
                            $menu['submenu'][$k1]['checked'] = true;
                        }  
                        foreach ($child1['submenu'] as $k2 => $child2) { 
                            if(!empty($child2['submenu'])){
                                $submenu_ids2 = explode(',', $menu['submenu'][$k1]['submenu'][$k2]['submenu_ids']);
                                if(count(array_intersect($submenu_ids2, $permission)) == count($submenu_ids2)){
                                    $menu['submenu'][$k1]['submenu'][$k2]['checked'] = true;
                                }
                                foreach ($child2['submenu'] as $k3 => $child3) {
                                    if(!empty($child3['submenu'])){
                                        $submenu_ids3 = explode(',', $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['submenu_ids']);
                                        if(count(array_intersect($submenu_ids3, $permission)) == count($submenu_ids3)){
                                           $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['checked'] = true;
                                        }
                                    }
                                    if (in_array($child3['id'], $permission)) {
                                        $menu['submenu'][$k1]['submenu'][$k2]['submenu'][$k3]['checked'] = true;
                                    }
                                }
                            }
                             else{
                                if (in_array($child2['id'], $permission)) {
                                    $menu['submenu'][$k1]['submenu'][$k2]['checked'] = true;
                                }
                            }
                        }                    
                    }
                    else{
                        if (in_array($child1['id'], $permission)) {
                            $menu['submenu'][$k1]['checked'] = true;
                        }                    
                    }
                }
                $menuItem[] = $menu;
            }
            ksort($menuItem);
            return json_encode($menuItem);
        }
        else{
            ksort($getMenu);
            return json_encode($getMenu); 
        }       
    }
    public function accessControl() {
        $postdata = file_get_contents("php://input");
        $input  = json_decode($postdata, true);
        if(!empty($input)){//checkbox checked
            if($input['data']['moduleType'] === 'roles'){
                $getSubMenus = EmployeeRole::select('employee_submenus')->where('id', $input['data']['empId'])->get();
            }else{
                $getSubMenus = Employee::select('employee_submenus')->where('id', $input['data']['empId'])->get();
            }
            
            $getMenuItem = [];
            if($getSubMenus[0]['employee_submenus'] != ''){
                $getMenuItem = json_decode($getSubMenus[0]['employee_submenus'],true);
            }
            if(!empty($input['data']['isChecked'])){ //checkbox checked
                $parentId = $submenuId = array();
                
                if(!empty($input['data']['parentId'])){
                $parentId = array_map(function($el){ return '0'.$el; },  $input['data']['parentId']);}
                $submenuId = array_map(function($el){ return '0'.$el; },  $input['data']['submenuId']);
                
                $menuArr = array_merge($parentId,$submenuId); 
                if(!empty($getMenuItem)){
                    $menuArr = array_unique(array_merge($menuArr,$getMenuItem)); //merge elements
                }
                asort($menuArr);
                $jsonArr = json_encode($menuArr,true);
                
                if($input['data']['moduleType'] === 'roles'){
                    EmployeeRole::where('id',$input['data']['empId'])->update(array('employee_submenus' => $jsonArr));
                }else{
                    Employee::where('id',$input['data']['empId'])->update(array('employee_submenus' => $jsonArr));
                }               
                $result = ['success' => true];
                return json_encode($result);
            }
            else{//checkbox unchecked
                $submenuId = array_map(function($el){ return '0'.$el; },  $input['data']['submenuId']); 
                $menuArrDiff = array_diff($getMenuItem, $submenuId); //removes elements
                if(!empty($getMenuItem)){
                    $menuArr = array_unique($menuArrDiff); //merge elements
                }
                asort($menuArr);
                $jsonArr = json_encode($menuArr,true);
                if($input['data']['moduleType'] === 'roles'){
                    EmployeeRole::where('id',$input['data']['empId'])->update(array('employee_submenus' => $jsonArr));
                }else{
                    Employee::where('id',$input['data']['empId'])->update(array('employee_submenus' => $jsonArr));
                } 
                $result = ['success' => true];
                return json_encode($result);
            }
        }
    }
    /****************** END (Organization Chart) *********************/

    public function orgchart() {
        return view("MasterHr::chart");
    }

    public function getChartData() {
        $input = Employee::whereIn('employee_status', [1, 2])
                ->select('team_lead_id', 'designation', 'id', 'first_name', 'last_name', 'employee_status', 'emp_photo_url')
                ->orderBy('team_lead_id')
                ->get();
        $data = array();
        foreach ($input as $key => $team) {
            $obj = Employee::where('id', $team['id'])
                    ->whereIn('employee_status', [1, 2])
                    ->select('team_lead_id', 'designation', 'id', 'first_name', 'last_name', 'employee_status', 'emp_photo_url')
                    ->get();
            if (!empty($obj)) {
                $data[$key]['v'] = $obj[0]->id;
                if (empty($team['emp_photo_url'])) {
                    $team['emp_photo_url'] = 'http://icons.iconarchive.com/icons/alecive/flatwoken/96/Apps-User-Online-icon.png';
                } else {
                    $team['emp_photo_url'] = 'https://s3-ap-southeast-1.amazonaws.com/bmsbuilderdotin/admin_users/avatars/' . $team['emp_photo_url'];
                }
                if ($team['employee_status'] == 2) {
                    $data[$key]['f'] = '<center><img src="' . $team['emp_photo_url'] . '" class="tree-user"></center><p class="tree-usr-name">' . $team['first_name'] . ' ' . $team['last_name'] . '</p> <div class="usr-designation themeprimary">' . $team['designation'] . '</div><b class="usr-status" style="color:red">Temporary Suspended</b></div>';
                } else {
                    $data[$key]['f'] = '<center><img src="' . $team['emp_photo_url'] . '" class="tree-user"></center><p class="tree-usr-name">' . $team['first_name'] . ' ' . $team['last_name'] . '</p> <div class="usr-designation themeprimary">' . $team['designation'] . '</div><b class="usr-status" style="color:Green">Active</b></div>';
                }
                $data[$key]['teamId'] = $team['team_lead_id'];
                $data[$key]['designation'] = $team['designation'];
            } else {
                exit;
            }
        }
        return $data;
    }

    public function photoUpload()
    {        
        if(move_uploaded_file($_FILES['file']['tmp_name'], base_path()."/common/employee_photo/".$_FILES['file']['name'])){      
            Employee::where('id',$_FILES['file']['type'])->update(array('emp_photo_url' => $_FILES['file']['name']));
            $result = ['success' => true];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Image not uploaded'];
            return json_encode($result);
        }
    }
    /****************** END (Organization Chart) *********************/
    
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
