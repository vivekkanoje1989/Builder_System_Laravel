<?php

namespace App\Modules\MasterSales\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Modules\MasterSales\Models\Customer;
use App\Modules\MasterSales\Models\CustomersLog;
use App\Modules\MasterSales\Models\CustomersContact;
use App\Modules\MasterSales\Models\CustomersContactsLog;
use App\Models\backend\Employee;
use App\Models\MlstBmsbBlockType;
use App\Modules\MasterSales\Models\EnquiryDetail;
use App\Modules\MasterSales\Models\EnquiryFollowup;
use Validator;
use DB;
use Auth;
use App\Classes\CommonFunctions;
use App\Modules\MasterSales\Models\Enquiry;
use App\Modules\EnquiryLocations\Models\lstEnquiryLocations;
use App\Models\LstEnquiryLocation;
use Illuminate\Support\Facades\Session;

class MasterSalesController extends Controller {

    public $allusers;
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("MasterSales::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("MasterSales::index");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        try {
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);

            if (empty($input)) {
                $input = Input::all();
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $input['customerData']['loggedInUserId'];
            }
            $validationRules = Customer::validationRules();
            $validationMessages = Customer::validationMessages();
            $userAgent = $_SERVER['HTTP_USER_AGENT'];

            if (!empty($input['customerData'])) {
                $validator = Validator::make($input['customerData'], $validationRules, $validationMessages);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    return json_encode($result, true);
                }
            }
            $input['customerData']['birth_date'] = date('Y-m-d', strtotime($input['customerData']['birth_date']));
            $input['customerData']['marriage_date'] = date('Y-m-d', strtotime($input['customerData']['marriage_date']));
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['customerData'] = array_merge($input['customerData'], $create);
            $createCustomer = Customer::create($input['customerData']); //insert data into employees table
            CustomersLog::create($input['customerData']);
            $input['customerData']['main_record_id'] = $createCustomer->id;
            $input['customerData']['record_type'] = 1;
            $input['customerData']['record_restore_status'] = 1;

            $createCustomerId = $createCustomer->id;
            if (!empty($input['customerContacts'])) {
                foreach ($input['customerContacts'] as $contacts) {
                    $contacts['customer_id'] = (int) $createCustomerId;
                    $contacts['mobile_optin_status'] = $contacts['mobile_verification_status'] = $contacts['landline_optin_status'] = $contacts['landline_verification_status'] = $contacts['landline_alerts_status'] = $contacts['email_optin_status'] = $contacts['email_verification_status'] = $contacts['mobile_verification_timestamp'] = 0;
                    $contacts['mobile_optin_info'] = $contacts['mobile_verification_details'] = $contacts['mobile_alerts_inactivation_details'] = $contacts['landline_optin_info'] = $contacts['landline_verification_details'] = $contacts['landline_alerts_inactivation_details'] = $contacts['email_optin_info'] = $contacts['email_verification_details'] = $contacts['email_alerts_inactivation_details'] = NULL;
                    $contacts['mobile_alerts_status'] = $contacts['landline_alerts_status'] = $contacts['email_alerts_status'] = 1;
                    $contacts['mobile_alerts_inactivation_timestamp'] = $contacts['landline_verification_timestamp'] = $contacts['landline_alerts_inactivation_timestamp'] = $contacts['email_verification_timestamp'] = $contacts['email_alerts_inactivation_timestamp'] = "0000-00-00 00:00:00";

                    if (!empty($contacts['mobile_number'])) {
                        $mobileNumber = explode("-", $contacts['mobile_number']);
                        $contacts['mobile_calling_code'] = !empty($mobileNumber[1]) ? (int) $mobileNumber[0] : "";
                        $contacts['mobile_number'] = (!empty($mobileNumber[1])) ? (int) $mobileNumber[1] : "";
                    }

                    if (!empty($contacts['landline_number'])) {
                        $landlineNumber = explode("-", $contacts['landline_number']);
                        $contacts['landline_calling_code'] = (!empty($landlineNumber[1])) ? (int) $landlineNumber[0] : "";
                        $contacts['landline_number'] = (!empty($landlineNumber[1])) ? (int) $landlineNumber[1] : "";
                    }
                    $contacts = array_merge($contacts, $create);
                    CustomersContact::create($contacts); //insert data into customer_contacts table
                    CustomersContactsLog::create($contacts); //insert data into customer_contacts_logs table
                }
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
        $result = ["success" => true, "customerId" => $createCustomer->id];
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
       
    }
    
    public function addEnquiryDetailRow(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $request = array_merge($request, $create);
        $recInserted = EnquiryDetail::create($request);
        if(1){
            $result = ['success' => true, "enqId" => $recInserted->id];
        }else{
            $result = ['success' => false];
        }        
        return json_encode($result);
    }
    public function delEnquiryDetailRow(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        EnquiryDetail::where('id', $request['enquiryDetailId'])->delete();
        $result = ['success' => true];
        return json_encode($result);
    }
    public function editCustomer($cid) {
        return view("MasterSales::index")->with(["editCustomerId" => $cid]);
    }
    public function editEnquiry($cid,$eid) {
        return view("MasterSales::index")->with(["editCustomerId" => $cid,"editEnquiryId" => $eid]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) { //customer update
        try {
            $originalValues = Customer::where('id', $id)->get();
            $originalContactValues = CustomersContact::where('customer_id', $id)->get();
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);
            
            if (empty($input)) {
                $input = Input::all();
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $validationRules = Customer::validationRules();
                $validationMessages = Customer::validationMessages();
                if (!empty($input['customerData'])) {
                    $validator = Validator::make($input['customerData'], $validationRules, $validationMessages);
                    if ($validator->fails()) {
                        $result = ['success' => false, 'message' => $validator->messages()];
                        return json_encode($result, true);
                    }
                }
            } else {
                $loggedInUserId = $input['customerData']['loggedInUserId'];
            }
            
            unset($input['customerData']['loggedInUserId']);
            unset($input['customerData']['id']);            

            $validationRules = Customer::validationRules();
            $validationMessages = Customer::validationMessages();
            if (!empty($input['customerData'])) {
                $validator = Validator::make($input['customerData'], $validationRules, $validationMessages);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    return json_encode($result, true);
                }
            } else {
                $loggedInUserId = $input['customerData']['loggedInUserId'];
                unset($input['customerData']['loggedInUserId']);
                unset($input['customerData']['id']);
            }
            
            $input['customerData']['birth_date'] = date('Y-m-d', strtotime($input['customerData']['birth_date']));
            $input['customerData']['marriage_date'] = date('Y-m-d', strtotime($input['customerData']['marriage_date']));
            $input['customerData']['created_date'] = date('Y-m-d', strtotime($input['customerData']['created_date']));
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['customerData'] = array_merge($input['customerData'], $update);
            
            $updateCustomer = Customer::where('id', $id)->update($input['customerData']); //insert data into employees table
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $input['customerData']);
            $implodeArr = implode(",", array_keys($getResult));
            if ($updateCustomer == 1) {
                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input['customerData'] = array_merge($input['customerData'], $create);
                $input['customerData']['main_record_id'] = $id;
                $input['customerData']['record_type'] = 2;
                $input['customerData']['column_names'] = $implodeArr;
                $input['customerData']['record_restore_status'] = 1;
                CustomersLog::create($input['customerData']);
            }
            if (!empty($input['customerContacts'])) {
                $i = 0;
                foreach ($input['customerContacts'] as $contacts) {
                    unset($contacts['$hashKey']);
                    unset($contacts['$$hashKey']);
                    unset($contacts['index']);
                    $contacts['mobile_optin_status'] = $contacts['mobile_verification_status'] = $contacts['landline_optin_status'] = $contacts['landline_verification_status'] = $contacts['landline_alerts_status'] = $contacts['email_optin_status'] = $contacts['email_verification_status'] = 0;
                    $contacts['mobile_optin_info'] = $contacts['mobile_verification_details'] = $contacts['mobile_alerts_inactivation_details'] = $contacts['landline_optin_info'] = $contacts['landline_verification_details'] = $contacts['landline_alerts_inactivation_details'] = $contacts['email_optin_info'] = $contacts['email_verification_details'] = $contacts['email_alerts_inactivation_details'] = NULL;
                    $contacts['mobile_alerts_status'] = $contacts['landline_alerts_status'] = $contacts['email_alerts_status'] = 1;
                    $contacts['mobile_verification_timestamp'] = $contacts['mobile_alerts_inactivation_timestamp'] = $contacts['landline_verification_timestamp'] = $contacts['landline_alerts_inactivation_timestamp'] = $contacts['email_verification_timestamp'] = $contacts['email_alerts_inactivation_timestamp'] = "0000-00-00 00:00:00";

                    if (preg_match("/^(\+\d{1,4}-)\d{10}+$/", $contacts['mobile_number'])) {
                        if (!empty($contacts['mobile_number'])) {
                            $mobileNumber = explode("-", $contacts['mobile_number']);
                            $calling_code = (int) $mobileNumber[0];
                            $contacts['mobile_calling_code'] = !empty($mobileNumber[1]) ? $calling_code : "";
                            $contacts['mobile_number'] = !empty($mobileNumber[1]) ? (int) $mobileNumber[1] : "";
                            
                        }
                        if (!empty($contacts['landline_number'])) {
                            $landlineNumber = explode("-", $contacts['landline_number']);
                            $landline_calling_code = (int) $landlineNumber[0];
                            $contacts['landline_calling_code'] = !empty($landlineNumber[1]) ? $landline_calling_code : "";
                            $contacts['landline_number'] = !empty($landlineNumber[1]) ? (int) $landlineNumber[1] : "";
                        }
                    }
                    $checkMobileNumber = CustomersContact::where(['customer_id' => $id, "mobile_number" => $contacts['mobile_number']])->get();
                    
                    if (!empty($contacts['id'])) {//for existing mobile number
                        $contacts['updated_date'] = date('Y-m-d', strtotime($contacts['created_date']));
                        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
                        $contacts = array_merge($contacts, $update);
                        $updateContact = CustomersContact::where('id', $contacts['id'])->update($contacts); //insert data into customer_contacts table

                        if ($updateContact == 1) {
                            if (count($checkMobileNumber) == 0) {
                                $contacts['record_type'] = 1;
                            } else {
                                $getResult = array_diff_assoc($originalContactValues[$i]['attributes'], $contacts);
                                $contacts['main_record_id'] = $originalContactValues[$i]['attributes']['id'];
                                unset($getResult['created_date']);
                                $implodeArr = implode(",", array_keys($getResult));
                                $contacts['record_type'] = 2;
                                $contacts['column_names'] = $implodeArr;
                            }
                            $contacts['record_restore_status'] = 1;
                            CustomersContactsLog::create($contacts); //insert data into customer_contacts_logs table
                        }
                    } else {//for new mobile number
                        $contacts['customer_id'] = $id;
                        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                        $contacts = array_merge($contacts, $create);
                        CustomersContact::create($contacts); //insert data into customer_contacts table
                    }
                    
                    $i++;
                }
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
            return json_encode($result);
        }
        $result = ["success" => true, "customerId" => $id];
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

    public function getCustomerDetails() {
        try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $customerMobileNo = !empty($request['data']['customerMobileNo']) ? $request['data']['customerMobileNo'] : "0";
            $customerEmailId = !empty($request['data']['customerEmailId']) ? $request['data']['customerEmailId'] : "0";
            $searchData = !empty($customerMobileNo) ? $customerMobileNo : $customerEmailId;

            $getCustomerContacts = DB::select('CALL proc_get_customer_contacts("' . $customerMobileNo . '","' . $customerEmailId . '")');
            if (count($getCustomerContacts) > 0) {
                $getCustomerPersonalDetails = Customer::where('id', '=', $getCustomerContacts[0]->customer_id)->get();
                unset($getCustomerPersonalDetails[0]['pan_number']);
                unset($getCustomerPersonalDetails[0]['aadhar_number']);
                unset($getCustomerPersonalDetails[0]['image_file']);

                $getCustomerEnquiryDetails = DB::select('CALL proc_get_customer_open_enquiries(' . $getCustomerContacts[0]->customer_id .')');
                $getCustomerEnquiryDetails = json_decode( json_encode($getCustomerEnquiryDetails), true);

                if (count($getCustomerEnquiryDetails) == 0 || isset($request['data']['showCustomer'])) {
                    $result = ['success' => true, 'customerPersonalDetails' => $getCustomerPersonalDetails, 'customerContactDetails' => $getCustomerContacts, 'flag' => 0];
                } else {
                    $result = ['success' => true, 'customerPersonalDetails' => $getCustomerPersonalDetails, 'customerContactDetails' => $getCustomerContacts[0], 'CustomerEnquiryDetails' => $getCustomerEnquiryDetails, 'flag' => 1];
                }
            } else {
                $result = ['success' => false, "message" => "No record found"];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }
    
    public function getEnquiryDetails() {
        try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $enquiryId = !empty($request['data']['enquiryId']) ? $request['data']['enquiryId'] : "0";
            $customerId = !empty($request['data']['customerId']) ? $request['data']['customerId'] : "0";
            $getEnquiryDetails = DB::select('CALL proc_get_enquiry_details(' . $customerId . ',' . $enquiryId . ')');
            if(count($getEnquiryDetails) > 0){
                $getEnquiryDetails = json_decode(json_encode($getEnquiryDetails),true);
                $getCityID = lstEnquiryLocations::select("city_id")->where('id', '=', $getEnquiryDetails[0]['enquiry_locations'])->get();                
                $getCustomerPersonalDetails = Customer::where('id', '=', $getEnquiryDetails[0]['customer_id'])->get();
                $getCustomerContacts = CustomersContact::where('customer_id', '=', $getEnquiryDetails[0]['customer_id'])->get();

                if (count($getCustomerContacts) > 0) {
                    unset($getCustomerPersonalDetails[0]['pan_number']);
                    unset($getCustomerPersonalDetails[0]['aadhar_number']);
                    unset($getCustomerPersonalDetails[0]['image_file']);
                }

                if (count($getEnquiryDetails) != 0) {
                    $projectDetails = array();
                    for($i=0; $i < count($getEnquiryDetails); $i++){
                        $projectDetails[$i]['id'] = $getEnquiryDetails[$i]['enqdetails_id'];
                        $projectDetails[$i]['project_id'] = $getEnquiryDetails[$i]['project_id'];
                        $projectDetails[$i]['block_id'] = $getEnquiryDetails[$i]['block_id'];
                        $projectDetails[$i]['sub_block_id'] = $getEnquiryDetails[$i]['sub_block_id'];
                        $projectDetails[$i]['project_name'] = $getEnquiryDetails[$i]['project_name'];
                        $projectDetails[$i]['blocks'] = $getEnquiryDetails[$i]['block_name'];
                        $projectDetails[$i]['subblocks'] = $getEnquiryDetails[$i]['block_sub_type'];
                    }
                    $result = ['success' => true, 'customerPersonalDetails' => $getCustomerPersonalDetails, 'customerContactDetails' => $getCustomerContacts, "enquiryDetails" => $getEnquiryDetails, "projectDetails" => $projectDetails, "city_id" => $getCityID[0]["city_id"]];
                }
            }else{
                $result = ['success' => false];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }
    public function getCustomerDataWithId() {
        try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $data = Customer::where('id', $request['data']['customerId'])->get();
            $data['get_customer_contacts'] = CustomersContact::where('customer_id', $request['data']['customerId'])->get();
            if (count($data) > 0) {
                $result = ['success' => true, 'customerPersonalDetails' => $data];
            } else {
                $result = ['success' => false, "message" => "No record found"];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }

    public function checkMobileExist() {
        try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $mobileNumber = $request['data']['mobileNumber'];
            if (!empty($mobileNumber)) {
                $explodeMobileNumber = explode("-", $mobileNumber);
                $mobileNumber = (int) $explodeMobileNumber[1];
            }
            $checkMobile = CustomersContact::select('customer_id', 'mobile_number')->where('mobile_number', $mobileNumber)->first();

            if (empty($checkMobile) || $checkMobile['customer_id'] == $request['data']['customerId']) {
                $result = ['success' => true];
            } else if (!empty($checkMobile)) { //Mobile number already exist
                $result = ['success' => false];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }
    
    public function getEnquiryHistory(){
        try{
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);
            $enquiryId = $input['enquiryId'];
            $historyList = DB::table('enquiry_followups as ef')
                        ->leftjoin('employees as e', 'e.id', '=', 'ef.followup_by_employee_id')
                        ->leftjoin('laravel_developement_master_edynamics.mlst_enquiry_sales_statuses as mess', 'mess.id', '=', 'ef.sales_status_id')
                        ->leftjoin('laravel_developement_master_edynamics.mlst_enquiry_sales_categories as mesc', 'mesc.id', '=', 'ef.sales_category_id')
                        ->select('ef.*',DB::raw('DATE_FORMAT(ef.followup_date_time, "%d-%m-%Y at %h:%i %p") as last_followup_date'),DB::raw('DATE_FORMAT(ef.next_followup_date, "%d-%m-%Y") as next_followup_date'),DB::raw('DATE_FORMAT(ef.next_followup_time, "%h:%i %p") as next_followup_time'),
                            'e.first_name','e.last_name','mess.sales_status','mesc.enquiry_category')
                        ->where('ef.enquiry_id',$enquiryId)
                        ->orderBy('ef.id','asc  ')
                        ->get();

            if($historyList){
                $result = ['success' => true , 'records'=>$historyList];
            }else{
                $result = ['success' => false , 'records'=>$historyList];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }
    // insert new enquiry 
    public function saveEnquiry() {
        try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);

            if (empty($request['enquiryData']['loggedInUserId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['enquiryData']['loggedInUserId'];
            }
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $customerInfo = Customer::select('source_id','subsource_id','source_description')->where('id', $request['customer_id'])->get();

            /*  insert enquiry  */
            $request['enquiryData'] = array_merge($request['enquiryData'], $create);
            $request['enquiryData']['customer_id'] = $request['customer_id'];
            $request['enquiryData']['client_id'] = 1;
            $request['enquiryData']['sales_employee_id'] = $loggedInUserId;

            if (!empty($request['enquiryData']['sales_channel_id'])) {
                $request['enquiryData']['sales_channel_id'] = $request['enquiryData']['sales_channel_id'];
            }else {
                $request['enquiryData']['sales_channel_id'] = 3;
            }
            $request['enquiryData']['sales_source_id'] = $customerInfo[0]['source_id'];
            $request['enquiryData']['sales_subsource_id'] = $customerInfo[0]['subsource_id'];
            $request['enquiryData']['sales_source_description'] = $customerInfo[0]['source_description'];
            $request['enquiryData']['sales_enquiry_date'] = date('Y-m-d', strtotime($request['enquiryData']['sales_enquiry_date']));
            if (!empty($request['enquiryData']['property_possession_date'])) {
                $request['enquiryData']['property_possession_date'] = date('Y-m-d', strtotime($request['enquiryData']['property_possession_date']));
            }
            if (!empty($request['enquiryData']['enquiry_locations'])) {
                $request['enquiryData']['enquiry_locations'] = implode(',', array_map(function($el) {
                    return $el['id'];
                }, $request['enquiryData']['enquiry_locations']));
            }
            $next_followup_date = $request['enquiryData']['next_followup_date'];
            $next_followup_time = date('H:i:s', strtotime($request['enquiryData']['next_followup_time']));

            unset($request['enquiryData']['project_id'],$request['enquiryData']['block_id'],$request['enquiryData']['sub_block_id'],$request['enquiryData']['enquiry_category_id'],$request['enquiryData']['city_id'],$request['enquiryData']['csrfToken'],$request['enquiryData']['next_followup_date'],$request['enquiryData']['next_followup_time']);
            $insertEnquiry = Enquiry::create($request['enquiryData']);

            if ($insertEnquiry) {
                /* insert enquiry details */
                if (!empty($request['projectEnquiryDetails'])) {
                    foreach ($request['projectEnquiryDetails'] as $projectDetail) {
                        $projectDetail = array_merge($projectDetail, $create);
                        $projectDetail['enquiry_id'] = $insertEnquiry->id;
                        EnquiryDetail::create($projectDetail);
                    }
                } 

                /* fill  follow up details */
                $request['followupDetails']['enquiry_id'] = $insertEnquiry->id;
                $request['followupDetails']['followup_date_time'] = date('Y-m-d H:i:s');
                $request['followupDetails']['followup_by_employee_id'] = $request['enquiryData']['followup_by_employee_id'];
                $request['followupDetails']['followup_entered_through'] = "0";
                $request['followupDetails']['remarks'] = $request['enquiryData']['remarks'];
                $request['followupDetails']['call_recording_log_type'] = $request['followupDetails']['call_recording_id'] = 
                $request['followupDetails']['finance_category_id'] = $request['followupDetails']['finance_subcategory_id']= 
                $request['followupDetails']['finance_status_id'] = $request['followupDetails']['finance_substatus_id'] = 0;
                $request['followupDetails']['next_followup_date'] = $next_followup_date;   

                if (isset($next_followup_time)) {
                    $request['followupDetails']['next_followup_time'] = $next_followup_time;
                } else {
                    $request['followupDetails']['next_followup_time'] = date('H:i:s');
                }            
                $checkEnquiryExist = Enquiry::selectRaw('max(id) as maxenqid')->where('customer_id',$request['customer_id'])->get();
                if(!empty($checkEnquiryExist[0]['maxenqid'])){         
                    EnquiryFollowup::where('id',$checkEnquiryExist[0]['maxenqid'])->update(['actual_followup_date_time' => date('Y-m-d H:m:s')]);
                }            
                $request['followupDetails']['actual_followup_date_time'] = "0000-00-00 00:00:00";            
                $request['followupDetails']['sales_category_id'] = $request['enquiryData']['sales_category_id'];
                $request['followupDetails']['sales_subcategory_id'] = $request['followupDetails']['sales_status_id'] = 
                $request['followupDetails']['sales_substatus_id'] = 1;

                $request['followupDetails'] = array_merge($request['followupDetails'], $create);
                EnquiryFollowup ::create($request['followupDetails']); 

                $result = ['success' => true, 'message' => 'Record Inserted Successfully.'];
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong'];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }
    public function updateEnquiry() {
        try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);

            if (empty($request['enquiryData']['loggedInUserId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['enquiryData']['loggedInUserId'];
            }

            unset($request['enquiryData']['project_id'],$request['enquiryData']['block_id'],$request['enquiryData']['sub_block_id'],
                    $request['enquiryData']['enquiry_category_id'],$request['enquiryData']['city_id'],$request['enquiryData']['csrfToken'],
                    $request['enquiryData']['next_followup_date'],$request['enquiryData']['next_followup_time'],
                    $request['enquiryData']['project_name'],$request['enquiryData']['block_name'],$request['enquiryData']['block_sub_type'],
                    $request['enquiryData']['followup_by_employee_id'],$request['enquiryData']['remarks'],$request['enquiryData']['enqdetails_id']);

            /*  update enquiry  */
            if (!empty($request['enquiryData']['sales_channel_id'])) {
                $request['enquiryData']['sales_channel_id'] = $request['enquiryData']['sales_channel_id'];
            }else {
                $request['enquiryData']['sales_channel_id'] = 3;
            }
            if (!empty($request['enquiryData']['property_possession_date'])) {
                $request['enquiryData']['property_possession_date'] = date('Y-m-d', strtotime($request['enquiryData']['property_possession_date']));
            }
            if (!empty($request['enquiryData']['enquiry_locations'])) {
                $request['enquiryData']['enquiry_locations'] = implode(',', array_map(function($el) {
                            return $el['id'];
                        }, $request['enquiryData']['enquiry_locations']));
            }
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $request['enquiryData'] = array_merge($request['enquiryData'], $update);

            unset($request['enquiryData']['project_id'],$request['enquiryData']['block_id'],$request['enquiryData']['sub_block_id'],
                    $request['enquiryData']['enquiry_category_id'],$request['enquiryData']['city_id'],$request['enquiryData']['csrfToken'],
                    $request['enquiryData']['next_followup_date'],$request['enquiryData']['next_followup_time'],
                    $request['enquiryData']['project_name'],$request['enquiryData']['block_name'],$request['enquiryData']['block_sub_type'],
                    $request['enquiryData']['followup_by_employee_id'],$request['enquiryData']['remarks'],$request['enquiryData']['enqdetails_id']);

            Enquiry::where('id', $request['enquiryData']['id'])->update($request['enquiryData']);

            $result = ['success' => true, 'message' => 'Record updated Successfully.'];
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }

    /* get all listing controler data */

    public function getEmployees() {
        $getEmployees = Employee::select('id', 'first_name', 'last_name', 'designation_id')->get();
        if (!empty($getEmployees)) {
            $result = ['success' => true, 'records' => $getEmployees];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getFinanceEmployees() {
        try{
            $getEmployees = Employee::select('id', 'first_name', 'last_name', 'designation_id', 'department_id')->where("department_id", 'like', '%,11%')
                            ->orWhere("department_id", 'like', '%11%')
                            ->orWhere("department_id", 'like', '%11,%')->get();
            if (!empty($getEmployees)) {
                $result = ['success' => true, 'records' => $getEmployees];
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong'];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }

    public function getEnquiryCity() {
        $getcity = lstEnquiryLocations::select('*')->with('getCityName')->groupBy('city_id')->get();
        if (!empty($getcity)) {
            $result = ['success' => true, 'records' => $getcity];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getAllLocations() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $getlocations = lstEnquiryLocations::where('city_id', $request['city_id'])->select('id', 'country_id', 'state_id', 'city_id', 'location')->get();
        if (!empty($getlocations)) {
            $result = ['success' => true, 'records' => $getlocations];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    /*********************** ENQUIRY LISTING *************************/
    
    public function getTotalEnquiries() { // get all enquiries
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];
        
        $getCustomerEnquiryDetails = DB::select('CALL proc_get_total_enquiries('.$loggedInUserId .')');
        $getCustomerEnquiryDetails = json_decode( json_encode($getCustomerEnquiryDetails), true);
            
        /*$getCustomerEnquiryDetails = Enquiry::whereIn('sales_status_id', [1, 2])->with('getEnquiryCategoryName', 'getEnquiryDetails', 'getFollowupDetails', 'channelName', 'customerDetails', 'customerContacts')->get();
        foreach ($getCustomerEnquiryDetails as $enqDetails) {
            $getLocationName = array();
            $arr = (explode(",", $enqDetails->enquiry_locations));
            $loc = LstEnquiryLocation::select('location')->whereIn("id", $arr)->get();
            for ($i = 0; $i < count($loc); $i++) {
                $getLocationName[] = $loc[$i]->location;
            }
            $implodeLoc = implode(",", $getLocationName);
            $enqDetails['enquiry_locations'] = $implodeLoc;
        }*/
        if (count($getCustomerEnquiryDetails) != 0) {
            $result = ['success' => true, 'records' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'records' => 'No Records Found'];
        }
        return json_encode($result);
    }

    public function getLostEnquiries() {// get lost enquiries
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];
        
        $getCustomerEnquiryDetails = DB::select('CALL proc_get_lost_enquiries('.$loggedInUserId .')');
        $getCustomerEnquiryDetails = json_decode( json_encode($getCustomerEnquiryDetails), true);
        
        //$getCustomerEnquiryDetails = Enquiry::where([['sales_status_id', '=', 4]])->with('getEnquiryCategoryName', 'getEnquiryDetails', 'getFollowupDetails', 'channelName', 'customerDetails', 'customerContacts')->get();
        if (count($getCustomerEnquiryDetails) != 0) {
            $result = ['success' => true, 'records' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'records' => 'No Records Found'];
        }
        return json_encode($result);
    }

    public function getClosedEnquiries() {// get booked enquiries
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];
        
        $getCustomerEnquiryDetails = DB::select('CALL proc_get_closed_enquiries('.$loggedInUserId .')');
        $getCustomerEnquiryDetails = json_decode( json_encode($getCustomerEnquiryDetails), true);
        
        //$getCustomerEnquiryDetails = Enquiry::where([['sales_status_id', '=', 3]])->with('getEnquiryCategoryName', 'getEnquiryDetails', 'getFollowupDetails', 'channelName', 'customerDetails', 'customerContacts')->get();
        if (count($getCustomerEnquiryDetails) != 0) {
            $result = ['success' => true, 'records' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'records' => 'No Records Found'];
        }
        return json_encode($result);
    }

    public function getTodaysFollowups() {// Todays Followups 
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];
        
        $getCustomerEnquiryDetails = DB::select('CALL proc_get_today_followups('.$loggedInUserId .')');
        $getCustomerEnquiryDetails = json_decode( json_encode($getCustomerEnquiryDetails), true);
        /*$date = date('Y-m-d');
        $empId = Auth::guard('admin')->user()->id;
        $salesStatusId = implode(",", array(1, 2));
        $getCustomerEnquiryDetails = EnquiryFollowup::select("*", DB::raw('MAX(id) AS id'))->where('next_followup_date', '=', $date)->with(['getEnquiryFromFollowup' => function($q) use ($salesStatusId, $empId) {
                        $q->whereIn('sales_status_id', [$salesStatusId]);
                        $q->whereIn('sales_employee_id', [$empId]);
                    }])->groupBy("enquiry_id")->get();   */        

        if (count($getCustomerEnquiryDetails) != 0) {
            $result = ['success' => true, 'records' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    
    public function getPreviousFollowups() {// Previous Followups 
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];
        
        $getCustomerEnquiryDetails = DB::select('CALL proc_get_previous_followups('.$loggedInUserId .')');
        $getCustomerEnquiryDetails = json_decode( json_encode($getCustomerEnquiryDetails), true);
        
        /*$date = date('Y-m-d');
        $empId = Auth::guard('admin')->user()->id;
        $getCustomerEnquiryDetails = EnquiryFollowup::select("*", DB::raw('MAX(id) AS id'))->whereDate('followup_date_time', '=', $date)->with(['getEnquiryFromFollowup' => function($q) use ($empId) {
                        $q->whereIn('sales_employee_id', [$empId]);
                    }])->groupBy("enquiry_id")->get();*/
        if (count($getCustomerEnquiryDetails) != 0) {
            $result = ['success' => true, 'records' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
        
    public function getPendingFollowups() {// Pending Followups 
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];
        
        $getCustomerEnquiryDetails = DB::select('CALL proc_get_pending_followups('.$loggedInUserId .')');
        $getCustomerEnquiryDetails = json_decode( json_encode($getCustomerEnquiryDetails), true);
        
        /*$date = date('Y-m-d');
        $empId = Auth::guard('admin')->user()->id;
        $salesStatusId = implode(",", array(1, 2));
        $getCustomerEnquiryDetails = EnquiryFollowup::select("*", DB::raw('MAX(id) AS id'))->where('next_followup_date', '<', $date)->with(['getEnquiryFromFollowup' => function($q) use ($salesStatusId, $empId) {
                        $q->whereIn('sales_status_id', [$salesStatusId]);
                        $q->whereIn('sales_employee_id', [$empId]);
                    }])->groupBy("enquiry_id")->get();*/
        if (count($getCustomerEnquiryDetails) != 0) {
            $result = ['success' => true, 'records' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    
    /********************** TEAM ENQUIRIES *****************************/
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
    
    public function getTeamTotalEnquiries() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];

        $this->allusers = array();
        $this->getTeamIds($loggedInUserId);
        $alluser = $this->allusers;
        $empTeamIds = implode(',', $alluser);
       
        $enquiries = DB::select('CALL proc_get_total_enquiries("' . $empTeamIds . '")');

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    
    public function getTeamlostEnquiries() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];

        $this->allusers = array();
        $this->getTeamIds($loggedInUserId);
        $alluser = $this->allusers;
        $empTeamIds = implode(',', $alluser);
      
        $enquiries = DB::select('CALL proc_get_lost_enquiries("' . $empTeamIds . '")');

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    
    public function getTeamClosedEnquiries() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];

        $this->allusers = array();
        $this->getTeamIds($loggedInUserId);
        $alluser = $this->allusers;
        $empTeamIds = implode(',', $alluser);

        $enquiries = DB::select('CALL proc_get_closed_enquiries("' . $empTeamIds . '")');

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    
    public function getTeamTodayFollowups() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];

        $this->allusers = array();
        $this->getTeamIds($loggedInUserId);
        $alluser = $this->allusers;
        $empTeamIds = implode(',', $alluser);

        $enquiries = DB::select('CALL proc_get_today_followups("'.$empTeamIds.'")');

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    
    public function getTeamPendingFollowups() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];

        $this->allusers = array();
        $this->getTeamIds($loggedInUserId);
        $alluser = $this->allusers;
        $empTeamIds = implode(',', $alluser);
        
        $enquiries = DB::select('CALL proc_get_pending_followups("' . $empTeamIds . '")');
        
        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    
    public function getTeamPreviousFollowups() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        
        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];

        $this->allusers = array();
        $this->getTeamIds($loggedInUserId);
        $alluser = $this->allusers;
        $empTeamIds = implode(',', $alluser);
        
        $enquiries = DB::select('CALL proc_get_previous_followups("' . $empTeamIds . '")');

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    
    public function updateCustomer($id) {
        return view('MasterSales::updateCustomer')->with('id', $id);
    }
}
