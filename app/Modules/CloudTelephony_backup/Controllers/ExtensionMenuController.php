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
            $getvirtualnumber = CtSetting::select('id','virtual_number')->where('id',$request['id'])->get();
            if ($manageLists) {            
                $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists),"virtualno" => $getvirtualnumber]];
                echo json_encode($result);
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
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
            $getvirtualnumber = CtSetting::select('id','virtual_number')->where('id',$get_ct_settings_id[0]['ct_settings_id'])->get();
            if ($manageLists) {            
                $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists),"virtualno" => $getvirtualnumber]];
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
               
                $validationMessages = CtMenuSetting::validationMessages();
                $validationRules = CtMenuSetting::validationRules();

                $input = Input::all();
                $validator = Validator::make($input['extData1'], $validationRules,$validationMessages);
                
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    echo json_encode($result);
                    exit;
                }
                
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
		$validationMessages = CtMenuSetting::validationMessages();
                $validationRules = CtMenuSetting::validationRules();
                
                $input = Input::all();
                $validator = Validator::make($input['extData1'], $validationRules,$validationMessages);
                
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    echo json_encode($result);
                    exit;
                }
                
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
