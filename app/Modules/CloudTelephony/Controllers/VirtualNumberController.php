<?php

namespace App\Modules\CloudTelephony\Controllers;

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
use Auth;

class VirtualNumberController extends Controller {

    public function __construct() {
        $this->middleware('web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("CloudTelephony::virtualnumberslist");
    }

    public function manageLists() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageLists = [];
        $client_id = config('global.client_id');
        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
            $manageLists = DB::select('CALL proc_manage_ctsettings(1,' . $request["id"] . ',' . $client_id . ')');
        } else if ($request['id'] === "") {
            $manageLists = DB::select('CALL proc_manage_ctsettings(0,0,' . $client_id . ')');
            $i = 0;
            foreach ($manageLists as $list) {
                if(!empty($list->source_id)){
                    $sourcename = \App\Models\MlstBmsbEnquirySalesSource::select('sales_source_name')->where("id", "=", $list->source_id)->first();
                    $manageLists[$i]->source_name = $sourcename->sales_source_name;
                }
                if ($list->sub_source_id == 0) {
                    $manageLists[$i]->subsource = "";
                } else {
                    $sub = \App\Models\EnquirySalesSubsource::select('enquiry_subsource')->where("id", "=", $list->sub_source_id)->first();
                    $manageLists[$i]->subsource = $sub->enquiry_subsource;
                }
                if ($list->menu_status == 0) {
                    if(!empty($list->employees)){
                        $menuemployee = array();
                        $menuemployee = \App\Models\backend\Employee::select('first_name', 'last_name')->whereRaw("id IN($list->employees)")->get();
                        $getemployee = array();
                        for ($j = 0; $j < count($menuemployee); $j++) {
                            $getemployee[] = $menuemployee[$j]->first_name . " " . $menuemployee[$j]->last_name;
                        }
                        $implodeemployee = implode(",", $getemployee);
                        $manageLists[$i]->employee_name = $implodeemployee;
                    }
                } else {
                    if(empty($list->employees)){
                        $menusetting = \App\Models\CtMenuSetting::select('ext_number', 'ext_name','employees')->where('ct_settings_id', '=', $list->id)->get();
                        $menuemployee = array();
                        $getemployee = array();
                        $getExtensionName = array();
                        for ($k = 0; $k < count($menusetting); $k++) {
                            $getExtensionName[] =  " <b>(".$menusetting[$k]->ext_number.")</b> ".$menusetting[$k]->ext_name;
                            if(!empty($menusetting[$k]->employees)){
                                $menuemployee = \App\Model\backend\Employee::select('first_name', 'last_name')->whereRaw("id IN(".$menusetting[$k]->employees.")")->get();
                                $getemployee[] = "<b> (".$menusetting[$k]->ext_number.")</b>";
                                for($j=0;$j<count($menuemployee);$j++){
                                    $getemployee[] .= $menuemployee[$j]->first_name . " " . $menuemployee[$j]->last_name.",";
                                }
                            }
                        }
                        $implodeemployee = implode(" ", $getemployee);
                        $manageLists[$i]->employee_name = rtrim($implodeemployee,",");

                        $implodeext = implode(",", $getExtensionName);
                        $manageLists[$i]->ext_name = $implodeext;
                        }
                     }
                $i++;
            }
        }
   
        if ($manageLists) {
            $result = ['success' => true, 's3Path' => config('global.s3Path'), "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists)]];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
        }
        echo json_encode($result);
    }

    public function getVirtualnoList() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageLists = [];
        $client_id = config('global.client_id');
        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
            $manageLists = DB::select('CALL proc_manage_ctsettings(1,' . $request["id"] . ',' . $client_id . ')');
        } else if ($request['id'] === "") {
            $manageLists = DB::select('CALL proc_manage_ctsettings(0,0,' . $client_id . ')');
        }
        if (!empty($manageLists)) {
            $i = 0;
            foreach ($manageLists as $manageList) {
                if ($manageList->welcome_tune_type_id == 3) {
                    $manageLists[$i]->welcome_tune = config('global.s3Path') . '/caller_tunes/' . $manageList->welcome_tune;
                }
                if ($manageList->hold_tune_type_id == 3) {
                    $manageLists[$i]->hold_tune = config('global.s3Path') . '/caller_tunes/' . $manageList->hold_tune;
                }
                if (!empty($manageList->employees)) {
                    $manageLists[$i]->employees = explode(',', $manageList->employees);
                }
                if (!empty($manageList->msc_default_employee_id)) {
                    $manageLists[$i]->msc_default_employee_id = explode(',', $manageList->msc_default_employee_id);
                }

                if ($manageList->ec_welcome_tune_type_id == 3) {
                    $manageLists[$i]->ec_welcome_tune = config('global.s3Path') . '/caller_tunes/' . $manageList->ec_welcome_tune;
                }
                if ($manageList->ec_hold_tune_type_id == 3) {
                    $manageLists[$i]->ec_hold_tune = config('global.s3Path') . '/caller_tunes/' . $manageList->ec_hold_tune;
                }
                $i++;
            }
            $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists)]];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];  
        }
        echo json_encode($result);
    }

    public function manageextLists() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageLists = [];
        if (!empty($request['menu_id']) && $request['menu_id'] !== "0") { // for edit
            $manageLists = DB::select('CALL proc_ctsettings_menu(1,' . $request["cvn_id"] . ',' . $request["menu_id"] . ')');
        } else if (!empty($request['cvn_id'])) {
            $manageLists = DB::select('CALL proc_ctsettings_menu(0,' . $request["cvn_id"] . ',0)');
        }
        if ($manageLists) {
            $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists)]];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
        }
        echo json_encode($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $validationMessages = CtSetting::validationMessages();
        $validationRules = CtSetting::validationRules();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if (empty($input)) {
            $input = Input::all();
        }
        $validator = Validator::make($input['vnumberData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            return json_encode($result);
        }
        if (empty($input['vnumberData']['loggedInUserId'])) {
            $input['vnumberData']['loggedInUserId'] = Auth::guard('admin')->user()->id;
        }
        echo "<pre>";print_r($input);exit;
        if ($input['vnumberData']['id'] > 0 || !empty($input['vnumberData']['id'])) {
            if ($input['vnumberData']['welcome_tune_type_id'] == 3) {
                if (!empty($input['vnumberData']['welcome_tune_audio'])) {
                    $s3FolderName = 'caller_tunes';
                    $name = S3::s3FileUplod($input['vnumberData']['welcome_tune_audio'], $s3FolderName, 1);
                    $name = trim($name, ",");
                    $input['vnumberData']['welcome_tune'] = $name;
                }
            } elseif ($input['vnumberData']['welcome_tune_type_id'] == 2) {
                $input['vnumberData']['welcome_tune'] = $input['vnumberData']['welcome_tune'];
            } elseif ($input['vnumberData']['welcome_tune_type_id'] == 1) {
                $input['vnumberData']['welcome_tune'] = '';
            }
            if (!empty($input['vnumberData']['hold_tune_type_id'])) {
                if ($input['vnumberData']['hold_tune_type_id'] == 3) {
                    if (!empty($input['vnumberData']['hold_tune_audio'])) {
                        $s3FolderName = 'caller_tunes';
                        $name = S3::s3FileUpload($input['vnumberData']['hold_tune_audio'], $s3FolderName, 1);
                        $name = trim($name, ",");
                        $input['vnumberData']['hold_tune'] = $name;
                    }
                } elseif ($input['vnumberData']['hold_tune_type_id'] == 2) {
                    $input['vnumberData']['hold_tune'] = $input['vnumberData']['hold_tune'];
                } elseif ($input['vnumberData']['hold_tune_type_id'] == 1) {
                    $input['vnumberData']['hold_tune'] = '';
                }
            }
            if (!empty($input['vnumberData']['nwh_welcome_tune_type_id'])) {
                if ($input['vnumberData']['nwh_welcome_tune_type_id'] == 3) {
                    if (!empty($input['vnumberData']['nwh_welcome_tune_audio'])) {
                        $s3FolderName = 'caller_tunes';
                        $name = S3::s3FileUplod($input['vnumberData']['nwh_welcome_tune_audio'], $s3FolderName, 1);
                        $name = trim($name, ",");
                        $input['vnumberData']['nwh_welcome_tune'] = $name;
                    }
                } elseif ($input['vnumberData']['nwh_welcome_tune_type_id'] == 2) {
                    $input['vnumberData']['nwh_welcome_tune'] = $input['vnumberData']['nwh_welcome_tune'];
                } elseif ($input['vnumberData']['nwh_welcome_tune_type_id'] == 1) {
                    $input['vnumberData']['nwh_welcome_tune'] = '';
                }
            }
            $status = CtSetting::updateStep1($input['vnumberData']);
            $message = "Record Updated Successfully";
        }

        //insert data into database
        if ($status == 1) {
            $result = ['success' => true, 'message' => $message];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please try again'];
        }
        echo json_encode($result);
    }
    
    
    public function updateNonworkinghours()
    {    
        $validationMessages = CtSetting::validationMessages();
        $validationRules = CtSetting::validationRules();

        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        if (empty($input)) {
            $input = Input::all();
        }

        $validator = Validator::make($input['nonworkingData'], $validationRules, $validationMessages);

        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            return json_encode($result);
        }
        if (empty($input['nonworkingData']['loggedInUserId'])) {
            $input['nonworkingData']['loggedInUserId'] = Auth::guard('admin')->user()->id;
        }
        if ($input['nonworkingData']['id'] > 0 || !empty($input['nonworkingData']['id'])) {
            if (!empty($input['nonworkingData']['nwh_welcome_tune_type_id'])) {
                    if ($input['nonworkingData']['nwh_welcome_tune_type_id'] == 3) {
                        if (!empty($input['nonworkingData']['nwh_welcome_tune_audio'])) {
                            $s3FolderName = 'caller_tunes';
                            $name = S3::s3FileUpload($input['nonworkingData']['nwh_welcome_tune_audio'], $s3FolderName, 1);
                            $name = trim($name, ",");
                            $input['nonworkingData']['nwh_welcome_tune'] = $name;
                        }
                    } elseif ($input['nonworkingData']['nwh_welcome_tune_type_id'] == 2) {
                        $input['nonworkingData']['nwh_welcome_tune'] = $input['nonworkingData']['nwh_welcome_tune'];
                    } elseif ($input['nonworkingData']['nwh_welcome_tune_type_id'] == 1) {
                        $input['nonworkingData']['nwh_welcome_tune'] = '';
                    }
                }
                $status = CtSetting::updateStep4($input['nonworkingData']);
                $message = "Record Updated Successfully";
        }
    }

    public function fileUpload() {
        $folderName = 'caller_tunes';

        if (!empty($_FILES['welcome_tune'])) {
            $welcomefileName = S3::s3FileUploadForApp($_FILES['welcome_tune'], $folderName, 1);
            if (!empty($welcomefileName)) {
                $wfile = CtSetting::where('id', $_FILES['welcome_tune']['type'])->update(array('welcome_tune' => $welcomefileName));
                if ($wfile) {
                    $result = ['success' => true, 'message' => 'File uploaded'];
                    return json_encode($result);
                }
            }
        }
        if (!empty($_FILES['hold_tune'])) {
            $holdfileName = S3::s3FileUploadForApp($_FILES['hold_tune'], $folderName, 1);
            if (!empty($holdfileName)) {
                $hfile = CtSetting::where('id', $_FILES['hold_tune']['type'])->update(array('hold_tune' => $holdfileName));
                if ($hfile) {
                    $result = ['success' => true, 'message' => 'File uploaded'];
                    return json_encode($result);
                }
            }
        }
        if (!empty($_FILES['ec_welcome_tune'])) {
            $ecwelcomefileName = S3::s3FileUploadForApp($_FILES['ec_welcome_tune'], $folderName, 1);
            if (!empty($ecwelcomefileName)) {
                $ecwfile = CtSetting::where('id', $_FILES['ec_welcome_tune']['type'])->update(array('ec_welcome_tune' => $ecwelcomefileName));
                if ($ecwfile) {
                    $result = ['success' => true, 'message' => 'File uploaded'];
                    return json_encode($result);
                }
            }
        }
        if (!empty($_FILES['ec_hold_tune'])) {
            $echoldfileName = S3::s3FileUploadForApp($_FILES['ec_hold_tune'], $folderName, 1);
            if (!empty($echoldfileName)) {
                $echfile = CtSetting::where('id', $_FILES['ec_hold_tune']['type'])->update(array('ec_hold_tune' => $echoldfileName));
                if ($echfile) {
                    $result = ['success' => true, 'message' => 'File uploaded'];
                    return json_encode($result);
                }
            }
        }
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
        return view("CloudTelephony::virtualnumberupdate")->with("id", $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {

        $validationMessages = CtSetting::validationMessages();
        $validationRules = CtSetting::validationRules();

        $input = Input::all();

        if (empty($input['vnumberData']['loggedInUserId'])) {
            $input['vnumberData']['loggedInUserId'] = Auth::guard('admin')->user()->id;
        }
        if ($input['vnumberData']['id'] > 0 || !empty($input['vnumberData']['id'])) {
            if ($input['vnumberData']['ec_welcome_tune_type_id'] == 3) {
                if (!empty($input['vnumberData']['welcome_tune_audio'])) {
                    //$wfileName = 'ecwelcome_tune'.date('Ymd').'.'.$input['vnumberData']['welcome_tune_audio']->getClientOriginalExtension();
                    //$input['vnumberData']['welcome_tune_audio']->move(base_path()."/common/tunes/", $wfileName);
                    //$input['vnumberData']['ec_welcome_tune'] = $wfileName;
                    $s3FolderName = 'caller_tunes';
                    $name = S3::s3FileUpload($input['vnumberData']['welcome_tune_audio'], $s3FolderName, 1);
                    $name = trim($name, ",");
                    $input['vnumberData']['ec_welcome_tune'] = $name;
                }
            } elseif ($input['vnumberData']['ec_welcome_tune_type_id'] == 2) {
                $input['vnumberData']['ec_welcome_tune'] = $input['vnumberData']['ec_welcome_tune'];
            } elseif ($input['vnumberData']['ec_welcome_tune_type_id'] == 1) {
                $input['vnumberData']['ec_welcome_tune'] = '';
            }
            if ($input['vnumberData']['ec_hold_tune_type_id'] == 3) {
                if (!empty($input['vnumberData']['hold_tune_audio'])) {
                    //$hfileName = 'echold_tune'.date('Ymd').'.'.$input['vnumberData']['hold_tune_audio']->getClientOriginalExtension();
                    //$input['vnumberData']['hold_tune_audio']->move(base_path()."/common/tunes/", $hfileName);
                    //$input['vnumberData']['ec_hold_tune'] = $hfileName;
                    $s3FolderName = 'caller_tunes';
                    $name = S3::s3FileUpload($input['vnumberData']['hold_tune_audio'], $s3FolderName, 1);
                    $name = trim($name, ",");
                    $input['vnumberData']['ec_hold_tune'] = $name;
                }
            } elseif ($input['vnumberData']['ec_hold_tune_type_id'] == 2) {
                $input['vnumberData']['ec_hold_tune'] = $input['vnumberData']['ec_hold_tune'];
            } elseif ($input['vnumberData']['hold_tune_type_id'] == 1) {
                $input['vnumberData']['ec_hold_tune'] = '';
            }
            $status = CtSetting::updateStep2($input['vnumberData']);
            $message = "Record Updated Successfully";
        }

        //insert data into database
        if ($status == 1) {
            $result = ['success' => true, 'message' => $message];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please try again'];
            echo json_encode($result);
        }
        exit;
    }

    public function existingUpdate($id) {
        return view("CloudTelephony::existingupdate")->with("id", $id);
    }

    public function nonworkingUpdate($id){
          return view("CloudTelephony::nonworkinghours")->with("id", $id);
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

    public function getCttunetype() {
        $getcttunetype = CtTuneType::all();
        if (!empty($getcttunetype)) {
            $result = ['success' => true, 'records' => $getcttunetype];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getCtforwardingtypes() {
        $getctforwardingtype = CtForwardingType::all();
        if (!empty($getctforwardingtype)) {
            $result = ['success' => true, 'records' => $getctforwardingtype];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
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

        $getEmployee = CtSetting::select('id', 'employees', 'msc_default_employee_id')->where('id', $request['ct_id'])->get();
        $explodeEmployees = explode(",", $getEmployee[0]->employees);
        $explodemissEmployees = explode(",", $getEmployee[0]->msc_default_employee_id);
        //print_r($getEmployee);exit;
        $getEmployees = \App\Models\backend\Employee::with('designationName')->select('id', 'first_name', 'last_name','designation_id')->whereNotIn('id', $explodeEmployees)->get();
        $getmissEmployees = \App\Models\backend\Employee::with('designationName')->select('id', 'first_name', 'last_name','designation_id')->whereNotIn('id', $explodemissEmployees)->get();


        if (!empty($getEmployees)) {
            $result = ['success' => true, 'employees' => $getEmployees, 'memployees' => $getmissEmployees];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function changeEmployees() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $empArr = array();
        $getEmployees = "";
        $getmissEmployees = "";
        if (!empty($request['employees'])) {
            foreach ($request['employees'] as $empid) {
                $empArr[] = $empid['id'];
            }
            $getEmployees = \App\Models\backend\Employee::select('id', 'first_name', 'last_name')->whereNotIn('id', $empArr)->with('designationName')->get();
        } else {
            $getEmployees = \App\Models\backend\Employee::select('id', 'first_name', 'last_name')->whereNotIn('id', $empArr)->with('designationName')->get();
        }



        if (!empty($getEmployees)) {
            $result = ['success' => true, 'employees' => $getEmployees, 'memployees' => $getmissEmployees];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getSubsources() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        //$empid = explode(',', $request['source_id']);
        $getEnquirysubsources = EnquirySubSource::select('*')->where("source_id", $request['source_id'])->get();
        if (!empty($getEnquirysubsources)) {
            $result = ['success' => true, 'records' => $getEnquirysubsources];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getSources() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        //$empid = explode(',', $request['source_id']);
        $getEnquirysources = \App\Models\MlstLmsaEnquirySalesSource::all();
        if (!empty($getEnquirysources)) {
            $result = ['success' => true, 'records' => $getEnquirysources];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

}
