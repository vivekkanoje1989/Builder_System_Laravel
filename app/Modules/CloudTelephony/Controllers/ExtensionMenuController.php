<?php namespace App\Modules\CloudTelephony\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EmployeesDevice;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use File;
use DB;
use Illuminate\Http\Request;
use App\Models\CtTuneType;
use App\Models\CtForwardingType;
use App\Models\EnquirySubSource;
use App\Models\CtSetting;
use App\Models\backend\Employee;
use App\Models\CtMenuSetting;
use Auth;
use App\Classes\S3;

class ExtensionMenuController extends Controller {

    
        public function __construct() {
            $this->middleware('web');
        }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
            return view("CloudTelephony::extensionmenu");
        }
       
        public function manageextLists() {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            //print_r($request);exit;
            $manageLists = [];
            if(!empty($request['id'])){
                $manageLists = DB::select('CALL proc_ctsettings_menu(0,'.$request['id'].',0)');
            }
            $i = 0;
            foreach ($manageLists as $list) {
                if(!empty($list->employees)){
                        $menuemployee = array();
                        $menuemployee = \App\Model\backend\Employee::select('first_name', 'last_name')->whereRaw("id IN($list->employees)")->get();
                        $getemployee = array();
                        for ($j = 0; $j < count($menuemployee); $j++) {
                            $getemployee[] = $menuemployee[$j]->first_name . " " . $menuemployee[$j]->last_name;
                        }
                        $implodeemployee = implode(", ", $getemployee);
                        $manageLists[$i]->employee_name = $implodeemployee;
                    }
                 $i++;   
                    
            }
            
            
            $getvirtualnumber = CtSetting::select('id','virtual_display_number')->where('id',$request['id'])->get();
            
            if ($manageLists) {            
                $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists),"virtualno" => $getvirtualnumber]];
                echo json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again',"virtualno" => $getvirtualnumber];
                echo json_encode($result);
            }
        }
        
        
        public function getMenuextlist(){
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $ctid= $request['ct_settings_id'];
            $query = "SELECT ct_menu_settings.*,ct_forwarding_types.type as type,concat(employees.first_name,' ',employees.last_name) as name FROM ct_menu_settings LEFT JOIN ct_forwarding_types ON ct_menu_settings.forwarding_type_id = ct_forwarding_types.id LEFT JOIN employees ON ct_menu_settings.employees = employees.id WHERE ct_menu_settings.ct_settings_id ='".$ctid."' ORDER BY ct_menu_settings.ext_number";
            $ext_menu_list = DB::select($query);
            
            
            if(!empty($ext_menu_list)){
                $i=0;
                foreach($ext_menu_list as $manageList){
                    if($manageList->welcome_tune_type_id == 3){
                        $ext_menu_list[$i]->welcome_tune = config('global.s3Path').'/caller_tunes/'.$manageList->welcome_tune;
                    }
                    if($manageList->hold_tune_type_id == 3){
                        $ext_menu_list[$i]->hold_tune = config('global.s3Path').'/caller_tunes/'.$manageList->hold_tune;
                    }
                    if(!empty($manageList->employees)){
                        $ext_menu_list[$i]->employees = explode(',', $manageList->employees);
                    }
                    
                    if($manageList->msc_welcome_tune_type_id == 3){
                        $ext_menu_list[$i]->msc_welcome_tune = config('global.s3Path').'/caller_tunes/'.$manageList->msc_welcome_tune;
                    }
                    
                    $i++;
                }
                $result = ['success' => true, "records" => ["data" => $ext_menu_list, "total" => count($ext_menu_list), 'per_page' => count($ext_menu_list), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($ext_menu_list)]];
                echo json_encode($result);
            }else{
                $result = ['success' => false, 'message' => 'Menu List is empty'];
                echo json_encode($result);
            }
        }
        
        public function manageextUpdate() {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            //print_r($request);exit;
            $manageLists = [];
            if(!empty($request['id'])){
                $manageLists = DB::select('CALL proc_ctsettings_menu(1,0,'.$request['id'].')');
            }
            $get_ct_settings_id = CtMenuSetting::select('ct_settings_id')->where('id',$request['id'])->get();
            
            
            //print_r($get_ct_settings_id[0]['ct_settings_id']);exit;
            //$getmenu = CtMenuSetting::select('cvn_id','virtual_number')->where('id',$request['id'])->get();
            $getvirtualnumber = CtSetting::select('id','virtual_display_number')->where('id',$get_ct_settings_id[0]['ct_settings_id'])->get();
            if ($manageLists) {            
                $result = ['success' => true,'s3Path'=>config('global.s3Path'), "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists),"virtualno" => $getvirtualnumber]];
                echo json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
                echo json_encode($result);
            }
        }
        
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
               // $postdata = file_get_contents("php://input");
               // $request = json_decode($postdata, true);
               
                

                $postdata = file_get_contents("php://input");
                $input = json_decode($postdata, true);
                
                if (empty($input)) {
                    $input = Input::all();
                    $validationMessages = CtMenuSetting::validationMessages();
                    $validationRules = CtMenuSetting::validationRules();
                    
                    $validator = Validator::make($input['extData1'], $validationRules,$validationMessages);
                
                    if ($validator->fails()) {
                        $result = ['success' => false, 'message' => $validator->messages()];
                        echo json_encode($result);
                        exit;
                    }
                }
                if(empty($input['extData1']['loggedInUserId'])){
                    $input['extData1']['loggedInUserId'] = Auth::guard('admin')->user()->id;
                }
                //echo "<pre>";print_r($input);exit;
                
                
                    $status = CtMenuSetting::createMenuExtension($input['extData1']);
                    $message = "Record Created Successfully";
               
                
                //insert data into database
                if ($status==1) {
                    $result = ['success' => true, 'message' => $message];
                    echo json_encode($result);
                } else {
                    $result = ['success' => false, 'message' => 'Number not register. Please try again'];
                    echo json_encode($result);
                }
                exit;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		
//            echo "here";exit;
            return view("CloudTelephony::extensionmenu")->with("id",$id);
	}
        
        
        public function viewData($id){
            return view("CloudTelephony::extensionmenu")->with("id",$id);
        }
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		
                
                $postdata = file_get_contents("php://input");
                $input = json_decode($postdata, true);
                
                if (empty($input)) {
                    $input = Input::all();
                    //echo "<pre>";print_r($input);exit;
                    $validationMessages = CtMenuSetting::validationMessages();
                    $validationRules = CtMenuSetting::validationRules();
                    $validator = Validator::make($input['extData1'], $validationRules,$validationMessages);
                
                    if ($validator->fails()) {
                        $result = ['success' => false, 'message' => $validator->messages()];
                        echo json_encode($result);
                        exit;
                    }
                }
                if(empty($input['extData1']['loggedInUserId'])){
                    $input['extData1']['loggedInUserId'] = Auth::guard('admin')->user()->id;
                }
                //print_r(json_encode($input));exit;
                
                
                    $status = CtMenuSetting::updateMenuExtension($input['extData1']);
                    $message = "Record Updated Successfully";
               
                
                //insert data into database
                if ($status==1) {
                    $result = ['success' => true, 'message' => $message];
                    echo json_encode($result);
                } else {
                    $result = ['success' => false, 'message' => 'Number not register. Please try again'];
                    echo json_encode($result);
                }
                exit;
	}
        
        
        public function menufileUpload() {
            $folderName = 'caller_tunes';
           
            if(!empty($_FILES['welcome_tune'])){
                $welcomefileName = S3::s3FileUplodForApp($_FILES['welcome_tune'], $folderName, 1);
                 //print_r($welcomefileName);exit;
                if (!empty($welcomefileName)) {
                    $wfile = CtMenuSetting::where('id', $_FILES['welcome_tune']['type'])->update(array('welcome_tune' => $welcomefileName));
                    if($wfile)
                    {
                        $result = ['success' => true, 'message' => 'File uploaded'];
                        return json_encode($result);
                    }

                } 
            }
            if(!empty($_FILES['hold_tune'])){
                $holdfileName = S3::s3FileUplodForApp($_FILES['hold_tune'], $folderName, 1);
                if (!empty($holdfileName)) {
                    $hfile = CtMenuSetting::where('id', $_FILES['hold_tune']['type'])->update(array('hold_tune' => $holdfileName));
                    if($hfile)
                    {
                        $result = ['success' => true, 'message' => 'File uploaded'];
                        return json_encode($result);
                    }

                } 
            }
            
            
            if(!empty($_FILES['msc_welcome_tune'])){
                $mscfileName = S3::s3FileUplodForApp($_FILES['msc_welcome_tune'], $folderName, 1);
                if (!empty($mscfileName)) {
                    $mscfile = CtMenuSetting::where('id', $_FILES['msc_welcome_tune']['type'])->update(array('msc_welcome_tune' => $mscfileName));
                    if($mscfile)
                    {
                        $result = ['success' => true, 'message' => 'File uploaded'];
                        return json_encode($result);
                    }

                } 
            }
            
            
        }
        

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
        
        public function getCttunetype(){
            $getcttunetype = CtTuneType::all();
            if(!empty($getcttunetype))
            {
                $result = ['success' => true, 'records' => $getcttunetype];
                return json_encode($result);
            }
            else
            {
                $result = ['success' => false,'message' => 'Something went wrong'];
                return json_encode($result);
            }
        
        }
    
        public function getCtforwardingtypes(){
            $getctforwardingtype = CtForwardingType::all();
            if(!empty($getctforwardingtype))
            {
                $result = ['success' => true, 'records' => $getctforwardingtype];
                return json_encode($result);
            }
            else
            {
                $result = ['success' => false,'message' => 'Something went wrong'];
                return json_encode($result);
            }
        }
        
        
        
        public function getEmployeelist() {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $empid = explode(',', $request['ids']);
            //echo '<pre>';print_r($empid);exit;
            $getemployeelist = \App\Models\backend\Employee::with('designationName')->select('id', 'first_name', 'last_name','designation_id')->whereIn('id', $empid)->get();
            if (!empty($getemployeelist)) {
                $result = ['success' => true, 'records' => $getemployeelist];
                return json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong'];
                return json_encode($result);
            }
        }
        
    
        
        public function editEmp() {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            if(!empty($request['ct_mid']) && $request['ct_mid'] > 0){
            $getEmployee = CtMenuSetting::select('id', 'employees', 'msc_default_employee_id')->where('id', $request['ct_mid'])->get();
            
            $explodeEmployees = explode(",", $getEmployee[0]->employees);
            $explodemissEmployees = explode(",", $getEmployee[0]->msc_default_employee_id);
            
            //print_r($getEmployee);exit;
            $getEmployees = \App\Models\backend\Employee::with('designationName')->select('id','first_name','last_name','designation_id')->whereNotIn('id', $explodeEmployees)->get();
            $getmissEmployees = \App\Models\backend\Employee::with('designationName')->select('id','first_name','last_name','designation_id')->whereNotIn('id', $explodemissEmployees,'designation_id')->get();
            }else{
                $getEmployees = \App\Models\backend\Employee::with('designationName')->select('id','first_name','last_name','designation_id')->where('employee_status', 1)->get();
                $getmissEmployees = \App\Models\backend\Employee::with('designationName')->select('id','first_name','last_name','designation_id')->where('employee_status', 1)->get();
            }

            if (!empty($getEmployees)) {
                $result = ['success' => true, 'employees' => $getEmployees, 'memployees' => $getmissEmployees];
                return $result;
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong'];
                return json_encode($result);
            }
        }
        
        public function getSubsources(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        //$empid = explode(',', $request['source_id']);
        $getEnquirysubsources = EnquirySubSource::select('*')->where("source_id",$request['source_id'])->get();
        if(!empty($getEnquirysubsources))
        {
            $result = ['success' => true, 'records' => $getEnquirysubsources];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

}
