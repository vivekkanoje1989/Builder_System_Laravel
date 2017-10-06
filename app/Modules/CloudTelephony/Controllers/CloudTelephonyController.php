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
use Auth;
use Excel;
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
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            
            $empId = (!empty($request['empId'])) ? $request['empId'] : "";
//            $getEmployee = \App\Model\backend\Employee::select("id","first_name","last_name")->get();
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
                        if(!empty($empId)){
                            if(array_key_exists($empId, $listArr1["_Default Employee"]) || 
                                array_key_exists($empId, $listArr2[$record['extid']."_"."".$record['ext_number']."-".$record['ext_name']]) || 
                                array_key_exists("extDefault_".$empId, $listArr2[$record['extid']."_"."".$record['ext_number']."-".$record['ext_name']]))
                            {
                        $listArr[$record['id']."_".$virtualNum][0] = $listArr1;
                        $listArr[$record['id']."_".$virtualNum][$i] = $listArr2;
                            }
                    }else{
                        $listArr[$record['id']."_".$virtualNum][0] = $listArr1;
                            $listArr[$record['id']."_".$virtualNum][$i] = $listArr2;
                    }
                    }else{
                        if(!empty($empId)){
                            if(array_key_exists($empId, $listArr1["_Employees"])){
                                $listArr[$record['id']."_".$virtualNum][0] = $listArr1;
                            }
                        }else{
                            $listArr[$record['id']."_".$virtualNum][0] = $listArr1;
                        }
                    }
                    $i++;
                }
                $result = ["success" => true, "data" => $listArr, "empId" => $empId];
            }
        } catch (Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function manageLists() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageLists = [];
        $export = $deleteBtn = '';
        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
            $manageLists = DB::select('CALL proc_manage_ctbillingsettings(1,' . $request["id"] . ')');
        } else if ($request['id'] === "") {
            $manageLists = DB::select('CALL proc_manage_ctbillingsettings(0,0)');
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if(!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$userAgent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($userAgent,0,4)))
        {
            $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
            if (in_array('01401', $array)) {
                $export = 1;
            }
            if (in_array('01402', $array)) {
                $deleteBtn = 1;
            } 
        } 
        $result = ['success' => true, "records" => ["data" => $manageLists,'exportData'=>$export, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists)]];
        return json_encode($result);
    }

    
     public function telephonyRegExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $client_id = config('global.client_id');
            $manageLists =  $manageLists = DB::select('CALL proc_manage_ctbillingsettings(0,0)');
            $getCount = count($manageLists);
            $manageLists = json_decode(json_encode($manageLists), true);
            $manageReg = array();
            $j = 1;
            for ($i = 0; $i < count($manageLists); $i++) {
                $blogData['Sr No.'] = $j++;
                $blogData['Client NamVirtualNumbee'] = $manageLists[$i]['marketing_name'];
                $blogData['Virtual Number'] = $manageLists[$i]['virtual_number'];
                $blogData['Activation Date'] = $manageLists[$i]['activation_date'];
                if ($manageLists[$i]['default_number'] == '1') {
                    $blogData['Default Number'] = 'Yes';
                } else {
                    $blogData['Default Number'] = 'No';
                }
                if ($manageLists[$i]['incoming_call_status'] == '1') {
                    $blogData['Incoming Call Status'] = 'Yes';
                } else {
                    $blogData['Incoming Call Status'] = 'No';
                }
                if ($manageLists[$i]['outbound_call_status'] == '1') {
                    $blogData['Outbound Call Status'] = 'Yes';
                } else {
                    $blogData['Outbound Call Status'] = 'No';
                }

                $manageReg[] = $blogData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Telephony Registration Details', function($excel) use($manageReg) {
                    $excel->sheet('sheet1', function($sheet) use($manageReg) {
                        $sheet->fromArray($manageReg);
                    });
                })->download('csv');
            }
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
