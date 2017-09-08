<?php

namespace App\Modules\CloudTelephony\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Auth;
use App\Models\CtBillingSetting;
//use App\Models\EmployeesDevice;
use Validator;
//use Illuminate\Support\Facades\Input;
//use Illuminate\Http\UploadedFile;
//use File;
use DB;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use App\Classes\CommonFunctions;

class CloudTelephonyController extends Controller {

    public function __construct() {
        $this->middleware('web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("CloudTelephony::index");
    }
    
    public function showvirtualnumusers() {
        return view("CloudTelephony::virtualnumberwiseusers");
    }
    public function removeEmpID() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            
            if(!empty($request)){
                $getMenuStatus = \App\Models\CtSetting::select("id","virtual_display_number","forwarding_number_knowlarity","menu_status","msc_default_employee_id","employees")->where("id",$request['data']['pmKey'])->get();
                if(!empty($getMenuStatus[0]->virtual_display_number)){
                    $virtualNum = $getMenuStatus[0]->id."_".$getMenuStatus[0]->virtual_display_number;
                }else{
                    $virtualNum = $getMenuStatus[0]->id."_".$getMenuStatus[0]->forwarding_number_knowlarity;
                }
                if($request['data']['removeType'] == 'defaultEmp'){
                    
                    if($getMenuStatus[0]->menu_status == 1)
                        $arrValue = $getMenuStatus[0]->msc_default_employee_id;
                    else
                        $arrValue = $getMenuStatus[0]->employees;
                }else{
                    $getMenuStatus = \App\Models\CtMenuSetting::select("menu_status","employees")->where("id",$request['data']['extid'])->get();
                    $arrValue = $getMenuStatus[0]->employees;
                }
                $explodeArrValue = explode(",",$arrValue);
                
               // $decodeArrkeys = array_keys($explodeArrValue);
                /*foreach($explodeArrValue as $key=>$rec){   
                    if($request['data']['empId'] == $key){
                        unset($explodeArrValue[$key]);
                    }                    
                }*/
                $checkArrLength = count($explodeArrValue);
                
                if($checkArrLength >= 2){
                    if($request['data']['removeType'] == 'defaultEmp'){
                        if(($key = array_search($request['data']['empId'], $explodeArrValue)) !== false) {
                            unset($explodeArrValue[$key]);
                        }
                        $output = implode(',',$explodeArrValue);
                        //echo $output;exit;

                        if($getMenuStatus[0]->menu_status == 1)
                            $update = \App\Models\CtSetting::where("id",$request['data']['pmKey'])->update(["msc_default_employee_id" => $output]);
                        else
                            $update = \App\Models\CtSetting::where("id",$request['data']['pmKey'])->update(["employees" => $output]);
                        $result = ["success" => true, "message" => "Employee deleted successfully" , "data"=>$virtualNum];

                    }else{
                        if(($key = array_search($request['data']['empId'], $explodeArrValue)) !== false) {
                            unset($explodeArrValue[$key]);
                        }
                        $output = implode(',', array_map(
                            function ($v) { if(is_numeric($v))return sprintf("%s", $v); },
                            $explodeArrValue,
                            array_values($explodeArrValue)
                        ));

                        $update = \App\Models\CtMenuSetting::where("id",$request['data']['extid'])->update(["employees" => rtrim($output,',')]);
                        $result = ["success" => true, "message" => "Employee deleted successfully", "data"=>$virtualNum];                    
                    }
                }else{
                    $result = ["success" => false, "message" => "Employee cannot be deleted. Atleast one employee should be in allocated to virtual number"];
                }
            }
        } catch (Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function getVirtualNumList() {
        try {
            $getList = DB::table('ct_settings')->leftjoin('ct_menu_settings as cms', 'cms.ct_settings_id', '=', 'ct_settings.id')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_enquiry_sales_sources as salessource', 'salessource.id', '=', 'ct_settings.source_id')
                    ->leftjoin('enquiry_sales_sub_sources as salessubsource', 'salessubsource.id', '=', 'ct_settings.sub_source_id')
                    ->select('ct_settings.id','ct_settings.source_id','ct_settings.sub_source_id','ct_settings.virtual_display_number','ct_settings.forwarding_number_knowlarity', 'ct_settings.menu_status', 'ct_settings.employees as ctemployees', 'ct_settings.msc_default_employee_id', 'cms.ct_settings_id',
                            'cms.id as extid','cms.ext_number', 'cms.ext_name', 'cms.employees', 'cms.msc_default_employee_id as menu_default_emp_id',
                            'salessource.sales_source_name','salessubsource.sub_source')
                    ->get();
            
            $getList = json_decode(json_encode($getList),true);
            $listArr = $listArr2 = array();
            $i = $inx = 0;
            if (!empty($getList)) {
                foreach ($getList as $record) {
                    $enquiry_subsource = '';
                    if(!empty($record['enquiry_subsource'])){
                        $enquiry_subsource = "/".$record['enquiry_subsource'];
                    }
                    if(!empty($record['virtual_display_number'])){
                        
                        $virtualNum = $record['virtual_display_number']." [".$record['sales_source_name'].$enquiry_subsource."]";
                    }else{
                        $virtualNum = $record['forwarding_number_knowlarity']." ".$record['sales_source_name'].$enquiry_subsource."]";
                    }
                    if($record['menu_status'] == 0){
                        $ctemployees = explode(',',$record['ctemployees']);
                        $listArr1 = array();
                        foreach ($ctemployees as $defaultemp1){
                            $getEmployeeDetails1 = \App\Models\backend\Employee::select("id","first_name","last_name")->where('id',$defaultemp1)->get();
                            $listArr1[""."_"."Employees"][$getEmployeeDetails1[0]['id']] = $getEmployeeDetails1[0]['first_name']." ".$getEmployeeDetails1[0]['last_name'];
                        }
                    }
                    if($record['menu_status'] == 1){
                        if(!empty($record['msc_default_employee_id'])){
                            $msc_default_employee_id = explode(',',$record['msc_default_employee_id']);
                            $listArr1 = array();
                            foreach ($msc_default_employee_id as $defaultemp){
                                $getEmployeeDetails = \App\Models\backend\Employee::select("id","first_name","last_name")->where('id',$defaultemp)->get();
                                $listArr1[""."_"."Default Employee"][$getEmployeeDetails[0]['id']] = $getEmployeeDetails[0]['first_name']." ".$getEmployeeDetails[0]['last_name'];
                            }
                        }
                        $employees = explode(',',$record['employees']);
                        $listArr2 = array();
                        if(!empty($record['menu_default_emp_id']) || ($record['menu_default_emp_id'] !== 0)){
                            $getEmployeeDetails = \App\Model\backend\Employee::select("id","first_name","last_name")->where('id',$record['menu_default_emp_id'])->get();
                            $listArr2[$record['extid']."_"."".$record['ext_number']."-".$record['ext_name']]["extDefault_".$getEmployeeDetails[0]['id']] = $getEmployeeDetails[0]['first_name']." ".$getEmployeeDetails[0]['last_name']."_(Default)";
                        }
                        foreach ($employees as $emp){
                            $getEmployeeDetails = \App\Model\backend\Employee::select("id","first_name","last_name")->where('id',$emp)->get();
                            $listArr2[$record['extid']."_"."".$record['ext_number']."-".$record['ext_name']][$getEmployeeDetails[0]['id']] = $getEmployeeDetails[0]['first_name']." ".$getEmployeeDetails[0]['last_name'];
                        }
                        $listArr[$record['id']."_".$virtualNum][0] = $listArr1;
                        $listArr[$record['id']."_".$virtualNum][$i] = $listArr2;
                    }else{
                        $listArr[$record['id']."_".$virtualNum][0] = $listArr1;
                    }
                    $i++;
                }
                $result = ["success" => true, "data" => $listArr];
            }
        } catch (Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function manageLists() {

        //$authUser = \Auth()->guard('admin')->user();
        //print_r($authUser);exit;

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageLists = [];
        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
            $manageLists = DB::select('CALL proc_manage_ctbillingsettings(1,' . $request["id"] . ')');
            //echo "here"; print_r($manageLists);exit;
        } else if ($request['id'] === "") {
            $manageLists = DB::select('CALL proc_manage_ctbillingsettings(0,0)');
        }

        if ($manageLists) {
            $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists)]];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("CloudTelephony::create")->with("id", '');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $validationMessages = CtBillingSetting::validationMessages();
        $validationRules = CtBillingSetting::validationRules();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if ($request['data']['registrationData']['default_number'] == 0 || empty($request['data']['registrationData']['default_number'])) {
            $request['data']['registrationData']['outbound_call_status'] = 0;
            $request['data']['registrationData']['outbound_pulse_rate'] = 0;
            $request['data']['registrationData']['outbound_pulse_duration'] = 0;
        }

        $validator = Validator::make($request['data']['registrationData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            return json_encode($result);
        }
        if ($request['data']['registrationData']['id'] > 0 || !empty($request['data']['registrationData']['id'])) {
            $number = CtBillingSetting::updateNumber($request['data']['registrationData']);
            $message = "Record Updated Successfully";
        } else {
            $number = CtBillingSetting::createNumber($request['data']['registrationData']);
            $message = "Record Created Successfully";
        }

        //insert data into database
        if ($number == 1) {
            $result = ['success' => true, 'message' => $message];
        } else {
            $result = ['success' => false, 'message' => 'Number not register. Please try again'];
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

//            echo "here";exit;
        return view("CloudTelephony::create")->with("id", $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
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

}
