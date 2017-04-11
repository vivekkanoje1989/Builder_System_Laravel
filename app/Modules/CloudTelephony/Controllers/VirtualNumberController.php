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
use App\Classes\S3;

class VirtualNumberController extends Controller {

    
        public function __construct() {
            $this->middleware('web');
        }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
                return view("CloudTelephony::virtualnumberslist");
	}
        
        
        public function manageLists() {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $manageLists = [];
            if(!empty($request['id']) && $request['id'] !== "0"){ // for edit
                $manageLists = DB::select('CALL proc_manage_ctsettings(1,'.$request["id"].',1)');
                //echo "here"; print_r($manageLists);exit;
            }else if($request['id'] === ""){
                $manageLists = DB::select('CALL proc_manage_ctsettings(0,0,1)');
            }
            //print_r($manageLists);exit;
            if ($manageLists) {            
                $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists)]];
                echo json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
                echo json_encode($result);
            }
        }
        
        public function manageextLists() {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $manageLists = [];
            if(!empty($request['menu_id']) && $request['menu_id'] !== "0"){ // for edit
                $manageLists = DB::select('CALL proc_ctsettings_menu(1,'.$request["cvn_id"].','.$request["menu_id"].')');
                //echo "here"; print_r($manageLists);exit;
            }else if(!empty($request['cvn_id'])){
                $manageLists = DB::select('CALL proc_ctsettings_menu(0,'.$request["cvn_id"].',0)');
            }
            //print_r($manageLists);exit;
            if ($manageLists) {            
                $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists)]];
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
                $validationMessages = CtSetting::validationMessages();
                $validationRules = CtSetting::validationRules();

                $input = Input::all();
              

                $validator = Validator::make($input['vnumberData'], $validationRules,$validationMessages);
                
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    echo json_encode($result);
                    exit;
                }
                //echo '<pre>';print_r($input);exit;
                if($input['vnumberData']['id'] > 0 || !empty($input['vnumberData']['id'])){
                    if($input['vnumberData']['welcome_tune_type_id'] == 3){
                        if(!empty($input['vnumberData']['welcome_tune_audio'])){
                            $s3FolderName ='caller_tunes';  
                            $name = S3::s3FileUplod($input['vnumberData']['welcome_tune_audio'], $s3FolderName,1);
                            $name = trim($name, ",");
                            $input['vnumberData']['welcome_tune'] = $name;
                        }
                    }elseif($input['vnumberData']['welcome_tune_type_id'] == 2){
                        $input['vnumberData']['welcome_tune'] = $input['vnumberData']['welcome_tune'];
                    }elseif($input['vnumberData']['welcome_tune_type_id'] == 1){
                        $input['vnumberData']['welcome_tune'] = '';
                    }
                    if($input['vnumberData']['hold_tune_type_id'] == 3){
                        if(!empty($input['vnumberData']['hold_tune_audio'])){
                            $s3FolderName ='caller_tunes';  
                            $name = S3::s3FileUplod($input['vnumberData']['hold_tune_audio'], $s3FolderName,1);
                            $name = trim($name, ",");
                            $input['vnumberData']['hold_tune'] = $name;
                        }
                    }elseif($input['vnumberData']['hold_tune_type_id'] == 2){
                        $input['vnumberData']['hold_tune'] = $input['vnumberData']['hold_tune'];
                    }elseif($input['vnumberData']['hold_tune_type_id'] == 1){
                        $input['vnumberData']['hold_tune'] = '';
                    }
                    if($input['vnumberData']['nwh_welcome_tune_type_id'] == 3){
                        if(!empty($input['vnumberData']['nwh_welcome_tune_audio'])){
                            $s3FolderName ='caller_tunes';  
                            $name = S3::s3FileUplod($input['vnumberData']['nwh_welcome_tune_audio'], $s3FolderName,1);
                            $name = trim($name, ",");
                            $input['vnumberData']['nwh_welcome_tune'] = $name;
                        }
                    }elseif($input['vnumberData']['nwh_welcome_tune_type_id'] == 2){
                        $input['vnumberData']['nwh_welcome_tune'] = $input['vnumberData']['nwh_welcome_tune'];
                    }elseif($input['vnumberData']['nwh_welcome_tune_type_id'] == 1){
                        $input['vnumberData']['nwh_welcome_tune'] = '';
                    }
                    $status = CtSetting::updateStep1($input['vnumberData']);
                    $message = "Record Updated Successfully";
                }
                
                //insert data into database
                if ($status==1) {
                    $result = ['success' => true, 'message' => $message];
                    echo json_encode($result);
                } else {
                    $result = ['success' => false, 'message' => 'Something went wrong. Please try again'];
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
            return view("CloudTelephony::virtualnumberupdate")->with("id",$id);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
            $validationMessages = CtSetting::validationMessages();
                $validationRules = CtSetting::validationRules();

                $input = Input::all();
               // print_r($input);exit;
                
                if($input['vnumberData']['id'] > 0 || !empty($input['vnumberData']['id'])){
                    if($input['vnumberData']['ec_welcome_tune_type_id'] == 3){
                        if(!empty($input['vnumberData']['welcome_tune_audio'])){
                            //$wfileName = 'ecwelcome_tune'.date('Ymd').'.'.$input['vnumberData']['welcome_tune_audio']->getClientOriginalExtension();
                            //$input['vnumberData']['welcome_tune_audio']->move(base_path()."/common/tunes/", $wfileName);
                            //$input['vnumberData']['ec_welcome_tune'] = $wfileName;
                            $s3FolderName ='caller_tunes';  
                            $name = S3::s3FileUplod($input['vnumberData']['welcome_tune_audio'], $s3FolderName,1);
                            $name = trim($name, ",");
                            $input['vnumberData']['ec_welcome_tune'] = $name;
                        }
                    }elseif($input['vnumberData']['ec_welcome_tune_type_id'] == 2){
                        $input['vnumberData']['ec_welcome_tune'] = $input['vnumberData']['ec_welcome_tune'];
                    }elseif($input['vnumberData']['ec_welcome_tune_type_id'] == 1){
                        $input['vnumberData']['ec_welcome_tune'] = '';
                    }
                    if($input['vnumberData']['ec_hold_tune_type_id'] == 3){
                        if(!empty($input['vnumberData']['hold_tune_audio'])){
                            //$hfileName = 'echold_tune'.date('Ymd').'.'.$input['vnumberData']['hold_tune_audio']->getClientOriginalExtension();
                            //$input['vnumberData']['hold_tune_audio']->move(base_path()."/common/tunes/", $hfileName);
                            //$input['vnumberData']['ec_hold_tune'] = $hfileName;
                            $s3FolderName ='caller_tunes';  
                            $name = S3::s3FileUplod($input['vnumberData']['hold_tune_audio'], $s3FolderName,1);
                            $name = trim($name, ",");
                            $input['vnumberData']['ec_hold_tune'] = $name;
                        }
                    }elseif($input['vnumberData']['ec_hold_tune_type_id'] == 2){
                        $input['vnumberData']['ec_hold_tune'] = $input['vnumberData']['ec_hold_tune'];
                    }elseif($input['vnumberData']['hold_tune_type_id'] == 1){
                        $input['vnumberData']['ec_hold_tune'] = '';
                    }
                    $status = CtSetting::updateStep2($input['vnumberData']);
                    $message = "Record Updated Successfully";
                }
                
                //insert data into database
                if ($status==1) {
                    $result = ['success' => true, 'message' => $message];
                    echo json_encode($result);
                } else {
                    $result = ['success' => false, 'message' => 'Something went wrong. Please try again'];
                    echo json_encode($result);
                }
                exit;
	}
        
        public function existingUpdate($id)
        {
            return view("CloudTelephony::existingupdate")->with("id",$id);
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
        
        public function getEmployeelist(){
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $empid = explode(',', $request['ids']);
            //echo '<pre>';print_r($empid);exit;
            $getemployeelist = Employee::select('id','first_name')->whereIn('id',$empid)->get();
            if(!empty($getemployeelist))
            {
                $result = ['success' => true, 'records' => $getemployeelist];
                return json_encode($result);
            }
            else
            {
                $result = ['success' => false,'message' => 'Something went wrong'];
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
