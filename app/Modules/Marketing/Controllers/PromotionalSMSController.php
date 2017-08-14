<?php

namespace App\Modules\Marketing\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\CommonFunctions;
use App\Classes\Gupshup;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use File;
use DB;
use Auth;
use App\Classes\S3;
use App\Models\SmsLog;
use PHPExcel;
use PHPExcel_IOFactory;
use Maatwebsite\Excel\Facades\Excel;

class PromotionalSMSController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public static $procname;

    public function __construct() {
        $this->middleware('web');
    }

    public function index() {
        return view("Marketing::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
//    public function store()
//	{
//		//$postdata = file_get_contents("php://input");
//               // $request = json_decode($postdata, true);
//                $input = Input::all();
//                $smsbody = $input['promotionalsmsData']['sms_body'];
//                $smstype = $input['promotionalsmsData']['sms_type'];
//                
//                if($input['promotionalsmsData']['send_sms_type'] == 1){ 
//                    $mobile = $input['promotionalsmsData']['smsnumbers'];
//                    //$smsresult = Gupshup::sendSMS($smsbody, $mobile, $smstype);
//                    $loggedInUserId = 1;
//                    $customer = "Yes";
//                    $customerId = 0;
//                    $isInternational = 0; //0 OR 1
//                    $sendingType = $smstype; //always 0 for T_SMS
//                    $smsType = "P_SMS";
//                    $result = Gupshup::sendSMS($smsbody, $mobile, $loggedInUserId, $customer, $customerId, $isInternational,$sendingType, $smsType);
//                    $decodeResult = json_decode($result,true);
//                   // return $decodeResult["success"];
//                    if($decodeResult["success"] == true){
//                        $result = ['success' => true, 'message' => "SMS Send Successfully"];
//                        echo json_encode($result);
//                    }else{
//                        $result = ['success' => false, 'message' => "SMS Not Send, Please Try Again..."];
//                        echo json_encode($result);
//                    }
//                }elseif($input['promotionalsmsData']['send_sms_type'] == 2){
//                    if(!empty($input['promotionalsmsData']['mobilenumbers'])){
//                        if(!empty($input['promotionalsmsData']['mobilenumbers'])){
//                        $wfileName = 'bulk_sms_file'.date('Ymd').'.'.$input['promotionalsmsData']['mobilenumbers']->getClientOriginalExtension();
//                        $input['promotionalsmsData']['mobilenumbers']->move(base_path()."/common/tunes/", $wfileName);
//                        $file = base_path()."/common/tunes/".$wfileName;
//                        }
//                        $mobile = '';
//                        //$smsresult = CommonFunctions::sendBULKSMS($smsbody, $smstype, $file);
//                        $data = ["fileName" => $wfileName,"filePath" => $file, "sendingType" => 1, "textSmsBody" => $smsbody, "smsType" => "bulk_sms"];
//                        $result = Gupshup::sendBulkSMS($data);
//                        $decodeResult = json_decode($result,true);
//                        //return $decodeResult["message"];
//
//                        if($decodeResult["success"] == true){
//                            $result = ['success' => true, 'message' => "SMS Send Successfully"];
//                            echo json_encode($result);
//                        }else{
//                            $result = ['success' => false, 'message' => "SMS Not Send, Please Try Again..."];
//                            echo json_encode($result);
//                        }
//                    }
//                    
//                }
//	}
//        
    public function store() {

        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if (empty($input)) {
            $input = Input::all();
        }

        $smsbody = $input['promotionalsmsData']['sms_body'];
        $smstype = $input['promotionalsmsData']['sms_type'];


        if ($input['promotionalsmsData']['send_sms_type'] == 1) {
            $mobile = $input['promotionalsmsData']['smsnumbers'];
            if (!empty($input['loggedInUserId']))
                $loggedInUserId = $input['loggedInUserId'];
            else
                $loggedInUserId = Auth::guard('admin')->user()->id;

            $customer = "Yes";
            $customerId = 0;
            $isInternational = 0; //0 OR 1
            $sendingType = $smstype; //always 0 for T_SMS
            $smsType = "P_SMS";
            $result = Gupshup::sendSMS($smsbody, $mobile, $loggedInUserId, $customer, $customerId, $isInternational, $sendingType, $smsType);
           print_r($result);
           die();
            $decodeResult = json_decode($result, true);
            // return $decodeResult["success"];
            if ($decodeResult["success"] == true) {
                $result = ['success' => true, 'message' => "SMS Send Successfully"];
                echo json_encode($result);
            } else {
                $result = ['success' => false, 'message' => $decodeResult['message']];
                echo json_encode($result);
            }
        } elseif ($input['promotionalsmsData']['send_sms_type'] == 2) {

            if (!empty($input['promotionalsmsData']['mobilenumbers'])) {
                $wfileName = 'bulk_sms_file' . time() . '.' . $input['promotionalsmsData']['mobilenumbers']->getClientOriginalExtension();
                $input['promotionalsmsData']['mobilenumbers']->move(base_path() . "/common/tunes/", $wfileName);
                $file = base_path() . "/common/tunes/" . $wfileName;
            }

            $mobile = '';

            if (!empty($input['loggedInUserId'])) {

                $loggedInUserId = $input['loggedInUserId'];
                $file = base_path() . "/common/tunes/" . $input['fileName'];
                $wfileName = $input['fileName'];
            } else {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            }

            $data = ["fileName" => $wfileName, "filePath" => $file, "sendingType" => 1, "textSmsBody" => $smsbody, "smsType" => "bulk_sms", "loggedInUserId" => $loggedInUserId];
            $result = Gupshup::sendBulkSMS($data);
            $decodeResult = json_decode($result, true);

            \File::delete($file);

            if ($decodeResult["success"] == true) {
                $result = ['success' => true, 'message' => "SMS Send Successfully"];
                echo json_encode($result);
            } else {
                $result = ['success' => false, 'message' => "SMS Not Send, Please Try Again..."];
                echo json_encode($result);
            }
        } elseif ($input['promotionalsmsData']['send_sms_type'] == 3) {


            if (!empty($input['promotionalsmsData']['mobilenumbers'])) {
                $wfileName = $input['promotionalsmsData']['mobilenumbers'];
                $file = base_path() . "/public/downloads/" . $wfileName;
            }

            if (!empty($input['loggedInUserId'])) {

                $loggedInUserId = $input['loggedInUserId'];
                $file = base_path() . "/public/downloads/" . $input['fileName'];
                $wfileName = $input['fileName'];
            } else {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            }

            $data = ["fileName" => $wfileName, "filePath" => $file, "sendingType" => 1, "textSmsBody" => $smsbody, "smsType" => "bulk_sms", "loggedInUserId" => $loggedInUserId];

            $result = Gupshup::sendBulkSMS($data);

            $decodeResult = json_decode($result, true);

            \File::delete($file);

            if ($decodeResult["success"] == true) {
                $result = ['success' => true, 'message' => "SMS Send Successfully"];
                echo json_encode($result);
            } else {
                $result = ['success' => false, 'message' => "SMS Not Send, Please Try Again..."];
                echo json_encode($result);
            }
        }
    }

    public function fileUpload() {

        $folderName = '/bulk_sms_file';
        $bulkfileName = S3::s3FileUploadForApp($_FILES['file'], $folderName, 1);
        $target_file = base_path() . "/common/tunes/" . $bulkfileName;
        move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
        if (!empty($bulkfileName)) {
            if ($bulkfileName) {
                $awsurl = config('global.s3Path') . $folderName . $bulkfileName;
                $result = ['success' => true, 'message' => 'Image uploaded', 'awsfileUrl' => $awsurl, 'fileName' => $bulkfileName];
                return json_encode($result);
            }
        } else {
            $result = ['success' => false, 'message' => 'Image not uploaded'];
            return json_encode($result);
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
        //
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

    protected function guard() {
        return Auth::guard('admin');
    }

    public function tuserid($id) {

        $admin = \App\Models\backend\Employee::where(['team_lead_id' => $id])->get();

        if (!empty($admin)) {

            foreach ($admin as $item) {
                $this->allusers[$item->id] = $item->id;
                $this->tuserid($item->id);
            }
        } else {
            return;
        }
    }

    public function getSmslogs() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        if (!empty($input['loggedInUserId']))
            $loggedInUserId = $input['loggedInUserId'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;

        $startFrom = ($input['pageNumber'] - 1) * $input['itemPerPage'];

        if ($input['isTeam'] == 1) {

            $this->tuserid($loggedInUserId);
            $alluser = $this->allusers;
            $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;
            $getsmsLogs = DB::select('CALL proc_smslogs("' . $loggedInUserId . '",' . $startFrom . ',' . $input['itemPerPage'] . ',"","","")');
            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;
        } else if ($input['isTeam'] == 0) {
            $getsmsLogs = DB::select('CALL proc_smslogs("' . $loggedInUserId . '",' . $startFrom . ',' . $input['itemPerPage'] . ',"","","")');
            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;
        }
        if (!empty($getsmsLogs[0])) {
            $result = ['success' => true, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        } else {
            $result = ['success' => false, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        }
        return json_encode($result);
    }

    public function getFilterdata() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $filterData = $request['filterData'];

        if (!empty($request['loggedInUserId']))
            $loggedInUserId = $request['loggedInUserId'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;

        /* filter data from filter record */

        $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];

        $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
        $filterData["toDate"] = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
        $filterData["mobile_number"] = !empty($filterData['mobile_number']) ? $filterData['mobile_number'] : "";


        if ($request['isTeam'] == 1) {

            $this->tuserid($loggedInUserId);
            $alluser = $this->allusers;
            $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;

            $getsmsLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '",' . $request["pageNumber"] . ',' .
                            $request["itemPerPage"] . ',"' . $filterData["fromDate"] . '","' . $filterData['toDate'] . '","' . $filterData['mobile_number'] . '")');

            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;
        } else {

            $getsmsLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $request["pageNumber"] . '","' .
                            $request["itemPerPage"] . '","' . $filterData["fromDate"] . '","' . $filterData['toDate'] . '","' . $filterData['mobile_number'] . '")');

            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;
        }

        if (!empty($getsmsLogs[0])) {
            $result = ['success' => true, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        } else {
            $result = ['success' => false, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        }
        return json_encode($result);
    }

    public function getSmslogsconsumption() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);

        if (!empty($input['loggedInUserId']))
            $loggedInUserId = $input['loggedInUserId'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;

        $startFrom = ($input['pageNumber'] - 1) * $input['itemPerPage'];

        if ($input['isTeam'] == 1) {

            $this->tuserid($loggedInUserId);
            $alluser = $this->allusers;
            $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;


            $getsmsLogs = DB::select('CALL proc_smslogconsumption("' . $loggedInUserId . '",' . $startFrom . ',' . $input['itemPerPage'] . ',"","","")');
            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;
        } else if ($input['isTeam'] == 0) {

            $getsmsLogs = DB::select('CALL proc_smslogconsumption("' . $loggedInUserId . '",' . $startFrom . ',' . $input['itemPerPage'] . ',"","","")');
            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;
        }
        if (!empty($getsmsLogs[0])) {
            $result = ['success' => true, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        } else {
            $result = ['success' => false, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        }
        return json_encode($result);
    }

    public function getFilterdataconsumption() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $filterData = $request['filterData'];

        if (!empty($request['loggedInUserId']))
            $loggedInUserId = $request['loggedInUserId'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;

        /* filter data from filter record */

        $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];

        $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
        $filterData["toDate"] = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
        $filterData["mobile_number"] = !empty($filterData['mobile_number']) ? $filterData['mobile_number'] : "";


        if ($request['isTeam'] == 1) {

            $this->tuserid($loggedInUserId);
            $alluser = $this->allusers;
            $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;

            $getsmsLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '",' . $request["pageNumber"] . ',' .
                            $request["itemPerPage"] . ',"' . $filterData["fromDate"] . '","' . $filterData['toDate'] . '","' . $filterData['mobile_number'] . '")');

            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;
        } else {

            $getsmsLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $request["pageNumber"] . '","' .
                            $request["itemPerPage"] . '","' . $filterData["fromDate"] . '","' . $filterData['toDate'] . '","' . $filterData['mobile_number'] . '")');

            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;
        }

        if (!empty($getsmsLogs[0])) {
            $result = ['success' => true, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        } else {
            $result = ['success' => false, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        }
        return json_encode($result);
    }

    public function detaillog($id, $empid) {

        return view("Marketing::detaillog")->with(array('tranid' => $id, 'empid' => $empid));
    }

    public function getalllogdetail() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $externalId1 = !empty($request['externalId1']) ? $request['externalId1'] : "";
        $employee_id = !empty($request['employee_id']) ? $request['employee_id'] : "";

        $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];

        $getsmsLogs = DB::select('CALL proc_smslogdetail("' . $externalId1 . '","' . $employee_id . '","' . $request['pageNumber'] . '","' . $request['itemPerPage'] . '","","","")');
        $getCount = DB::select("select FOUND_ROWS() totalCount");
        $getsmsCount = $getCount[0]->totalCount;

        if (!empty($getsmsLogs[0])) {
            $result = ['success' => true, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        } else {
            $result = ['success' => false, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        }
        return json_encode($result);
    }

    public function getDetailFilterdata() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        // echo '<pre>';print_r($request); exit;
        $filterData = $request['filterData'];


        /* filter data from filter record */

        $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];

        $externalId1 = !empty($request['externalId1']) ? $request['externalId1'] : "";
        $employee_id = !empty($request['employee_id']) ? $request['employee_id'] : "";

        $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
        $filterData["toDate"] = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
        $filterData["mobile_number"] = !empty($filterData['mobile_number']) ? $filterData['mobile_number'] : "";

        $getsmsLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $externalId1 . '","' . $employee_id . '","' .
                        $request['pageNumber'] . '","' . $request['itemPerPage'] . '","' . $filterData['fromDate'] . '","' . $filterData['toDate'] . '","' . $filterData['mobile_number'] . '")');

        $getCount = DB::select("select FOUND_ROWS() totalCount");
        $getsmsCount = $getCount[0]->totalCount;


        if (!empty($getsmsLogs[0])) {
            $result = ['success' => true, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        } else {
            $result = ['success' => false, 'records' => $getsmsLogs, 'totalCount' => $getsmsCount];
        }
        return json_encode($result);
    }

    public function smslogs() {
        return view("Marketing::smslogs");
    }

    public function teamsmslogs() {
        return view("Marketing::teamsmslogs");
    }

    public function smslogconsumption() {
        return view("Marketing::smslogconsumption");
    }

    public function teamsmslogconsumption() {
        return view("Marketing::teamsmslogconsumption");
    }

    public function getcustomerFilterdata() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $filterData = $request['filterData'];


        if (!empty($request['loggedInUserId']))
            $loggedInUserId = $request['loggedInUserId'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;

        $request["getProcName"] = !empty($request["getProcName"]) ? $request["getProcName"] : "proc_get_customers_mobile_number";

        if (!empty($filterData)) {
            $filterData["category_id"] = !empty($filterData["category_id"]) ? $filterData["category_id"] : "";
            $filterData["source_id"] = !empty($filterData['source_id']) ? $filterData["source_id"] : "";
            $filterData["model_id"] = !empty($filterData['model_id']) ? $filterData["model_id"] : "";
            $filterData['status_id'] = !empty($filterData['status_id']) ? $filterData["status_id"] : "";
            $filterData["lostReason_id"] = !empty($filterData['lostReason_id']) ? $filterData["lostReason_id"] : "";

            $filterData["customerFirstName"] = !empty($filterData['fname']) ? $filterData['fname'] : "";
            $filterData["customerLastName"] = !empty($filterData['lname']) ? $filterData['lname'] : "";
            $filterData["company_name"] = !empty($filterData['company_name']) ? $filterData['company_name'] : "";
            $filterData["emailId"] = !empty($filterData['emailId']) ? $filterData['emailId'] : "";
            $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
            $filterData["toDate"] = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
            $filterData["subcategory_id"] = !empty($filterData['subcategory_id']) ? implode(',', array_column($filterData['subcategory_id'], 'id')) : "";
            $filterData["subsource_id"] = !empty($filterData['subsource_id']) ? implode(',', array_column($filterData['subsource_id'], 'id')) : "";
            $filterData["substatus_id"] = !empty($filterData['substatus_id']) ? implode(',', array_column($filterData['substatus_id'], 'id')) : "";
            $filterData["subreason_id"] = !empty($filterData['subreason_id']) ? implode(',', array_column($filterData['subreason_id'], 'id')) : "";
            $filterData["testdriveFromDate"] = !empty($filterData['testdriveFromDate']) ? date('Y-m-d', strtotime($filterData['testdriveFromDate'])) : "";
            $filterData["testdriveToDate"] = !empty($filterData['testdriveToDate']) ? date('Y-m-d', strtotime($filterData['testdriveToDate'])) : "";
            $filterData["test_drive_given"] = (!empty($filterData['test_drive_given']) || isset($filterData['test_drive_given'])) ? $filterData['test_drive_given'] : "";
            $filterData["mobileNumber"] = !empty($filterData['mobileNumber']) ? $filterData['mobileNumber'] : "";
            $filterData["verifiedMobNo"] = !empty($filterData['verifiedMobNo']) ? $filterData['verifiedMobNo'] : "0";
            $filterData["verifiedEmailId"] = !empty($filterData['verifiedEmailId']) ? $filterData['verifiedEmailId'] : "0";
            $filterData["lfromDate"] = !empty($filterData['lfromDate']) ? date('Y-m-d', strtotime($filterData['lfromDate'])) : "";
            $filterData["ltoDate"] = !empty($filterData['ltoDate']) ? date('Y-m-d', strtotime($filterData['ltoDate'])) : "";
            //echo '<pre>';print_r($filterData);

            $customercontactDetails = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["customerFirstName"] . '","' . $filterData['customerLastName'] . '","' . $filterData["mobileNumber"] . '","' . $filterData["emailId"] . '","' . $filterData["verifiedMobNo"] . '","' .
                            $filterData["verifiedEmailId"] . '","' . $filterData["category_id"] . '","' . $filterData["subcategory_id"] . '","' . $filterData["source_id"] . '","' . $filterData["subsource_id"] . '","' . $filterData["model_id"] . '","' . $filterData["fromDate"] . '","' . $filterData["toDate"] . '","' . $filterData["test_drive_given"] . '","' . $filterData['status_id'] . '","' . $filterData["substatus_id"] . '","' . $filterData['company_name'] . '")');

            $getCount = DB::select("select FOUND_ROWS() totalCount");
            $getsmsCount = $getCount[0]->totalCount;

            $data = $customercontactDetails;
            $currentDate = date('d_m_Y_h_i_s_A');
            $loggedName = Auth::guard('admin')->user()->first_name . "_" . Auth::guard('admin')->user()->last_name;
            $filename = $loggedName . "_" . $currentDate;

            $reportName = "sendsmstocustomer";
            /* Create excel sheet */
            ob_end_clean();

            Excel::create($filename, function($excel) use ($data, $reportName) {
                $excel->sheet($reportName, function($sheet) use ($data, $reportName) {
                    $sheet->appendRow(["PHONE"]);
                    $i = 1;
                    // putting phone data as next rows
                    foreach ($data as $phoneData) {

                        $srno = ["srno" => $i++];
                        if (!empty($phoneData)) {
                            if ($phoneData->mobile !== "" && $phoneData->mobile !== 'null') {
                                $phonenumber = $phoneData->mobile;
                            }
                        }

                        $getPhoneData = [$phonenumber];
                        $phone = array_merge($getPhoneData);
                        $sheet->appendRow($phone);
                    }
                });
            })->save('XLS', "downloads/");


            $customerphonefile = $filename . ".xls";


            if (!empty($customercontactDetails)) {
                $result = ['success' => true, 'totalCount' => $getsmsCount, 'url' => $customerphonefile];
            } else {
                $result = ['success' => false, 'totalCount' => $getsmsCount];
            }

            return json_encode($result);
        } else {

            $result = ['success' => false, 'message' => 'something went wrong'];
            return json_encode($result);
        }
    }

}
