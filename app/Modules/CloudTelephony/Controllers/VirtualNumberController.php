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
//                $postdata = file_get_contents("php://input");
//                $request = json_decode($postdata, true);
                
                $input = Input::all();
                echo "<pre>";
print_r($input);exit;
//echo $request['data']['registrationData']['default_number'];exit;
                

                $validator = Validator::make($request['data']['vnumberData'], $validationRules,$validationMessages);
                
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    echo json_encode($result);
                    exit;
                }
                //echo $request['data']['registrationData']['id'];exit;
                
                if($request['data']['vnumberData']['id'] > 0 || !empty($request['data']['vnumberData']['id'])){
                    //$fileName = time().'.'.$request['data']['vnumberData']['welcome_tune']->getClientOriginalExtension();
                   // $request['data']['vnumberData']['welcome_tune']->move(base_path()."/common/tunes/", $fileName);
                   // $request['data']['vnumberData']['welcome_tune'] = $fileName;
                   // echo $request['data']['vnumberData']['welcome_tune'];exit;
                    $status = CtSetting::updateStep1($request['data']['vnumberData']);
                    $message = "Record Updated Successfully";
                }
                
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
