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
use App\Modules\MasterSales\Models\EnquiryDetail;
use App\Modules\MasterSales\Models\EnquiryFollowup;
use Validator;
use DB;
use Auth;
use App\Classes\CommonFunctions;
use App\Modules\MasterSales\Models\Enquiry;
use App\Modules\EnquiryLocations\Models\lstEnquiryLocations;

class MasterSalesController extends Controller {

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
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
            //echo json_encode($input);exit;
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
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $customerMobileNo = !empty($request['data']['customerMobileNo']) ? $request['data']['customerMobileNo'] : "0";
        $customerEmailId = !empty($request['data']['customerEmailId']) ? $request['data']['customerEmailId'] : "0";
        $getCustomerContacts = DB::select('CALL proc_get_customer_contacts("' . $customerMobileNo . '","' . $customerEmailId . '")');
        if (count($getCustomerContacts) > 0) {
            $getCustomerPersonalDetails = Customer::where('id', '=', $getCustomerContacts[0]->customer_id)->get();
               unset($getCustomerPersonalDetails[0]['pan_number']);
               unset($getCustomerPersonalDetails[0]['aadhar_number']);
               unset($getCustomerPersonalDetails[0]['image_file']);
            // $getCustomerEnquiryDetails = Enquiry::where('customer_id', '=', $getCustomerContacts[0]->customer_id)->orderBy('id', 'desc')->first();

            $getCustomerEnquiryDetails = Enquiry::where([['customer_id', '=', $getCustomerContacts[0]->customer_id], ['sales_status_id', '=', 2]])->with('getEnquiryCategoryName', 'getEnquiryDetails', 'getFollowupDetails', 'channelName')->get();
            if (count($getCustomerEnquiryDetails) == 0 || isset($request['data']['showCustomer'])) {
                $result = ['success' => true, 'customerPersonalDetails' => $getCustomerPersonalDetails, 'customerContactDetails' => $getCustomerContacts, 'flag' => 0];
            } else {
                $result = ['success' => true, 'customerPersonalDetails' => $getCustomerPersonalDetails, 'customerContactDetails' => $getCustomerContacts[0], 'CustomerEnquiryDetails' => $getCustomerEnquiryDetails, 'flag' => 1];
            }

            return json_encode($result);
        } else {
            $result = ['success' => false, "message" => "No record found"];
            return json_encode($result);
        }
    }

    public function checkMobileExist() {
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
        return json_encode($result);
    }

    public function showEnquiry($id) {
        $customer = Customer::select("id", "first_name", "last_name")->where("id", $id)->get();
        return view("MasterSales::enquiry")->with(["firstName" => $customer[0]["first_name"], "lastName" => $customer[0]["last_name"], "customerId" => $id]);
    }

    // insert new enquiry 
    public function saveEnquiryData() {
        //echo 'Hi priti';exit;
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (empty($request)) {
            $request = Input::all();
        }
        if (empty($request['enquiryData']['loggedInUserId'])) {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        } else {
            $loggedInUserId = $request['enquiryData']['loggedInUserId'];
        }
       
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
       print_r($request);exit;  
        /* fill  follow up details */
        $request['followupDetails']['remarks'] = $request['enquiryData']['remarks'];
        $request['followupDetails']['next_followup_date'] = date('Y-m-d', strtotime($request['enquiryData']['next_followup_date']));
        $request['followupDetails']['followup_by_employee_id'] = 1;
        $request['followupDetails']['enquiry_id'] = $request['enquiryData']['remarks'];
        //$request['followupDetails']['enquiry_category_id'] = $request['enquiryData']['enquiry_category_id'];
        $request['followupDetails']['enquiry_category_id'] = 1;
        $request['followupDetails']['finance_category_id'] = 0;
        $request['followupDetails']['client_id'] = 1;
        $request['followupDetails']['followup_channel_id'] = 3;
        /* fill  follow up details */
        unset($request['enquiryData']['project_id']);
        unset($request['enquiryData']['block_id']);
        unset($request['enquiryData']['sub_block_id']);
        unset($request['enquiryData']['enquiry_category_id']);
        //unset($request['enquiryData']['other_requirement']);
        unset($request['enquiryData']['city_id']);
        unset($request['enquiryData']['csrfToken']);
        unset($request['enquiryData']['next_followup_date']);
        //print_r($request['followupDetails']);
        /*  insert enquiry  */
        $request['enquiryData'] = array_merge($request['enquiryData'], $create);
        $request['enquiryData']['customer_id'] = $request['customer_id'];
        $request['enquiryData']['client_id'] = 1;
        $request['enquiryData']['sales_employee_id'] = 1;
        $request['enquiryData']['sales_channel_id'] = 3;
        $request['enquiryData']['sales_source_id'] = 1;
        
        // $request['enquiryData']['max_budget'] = 1;
        $request['enquiryData']['sales_enquiry_date'] = date('Y-m-d', strtotime($request['enquiryData']['sales_enquiry_date']));
        if (!empty($request['enquiryData']['property_possession_date'])) {
            $request['enquiryData']['property_possession_date'] = date('Y-m-d', strtotime($request['enquiryData']['property_possession_date']));
        }
        if (!empty($request['enquiryData']['enquiry_locations'])) {
            //  $request['enquiryData']['enquiry_locations'] = $request['enquiryData']['enquiry_locations'];
            //} else {
            $request['enquiryData']['enquiry_locations'] = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $request['enquiryData']['enquiry_locations']));
        }
        //print_r($request['enquiryData']);exit;
        $insertEnquiry = Enquiry::create($request['enquiryData']);
        if ($insertEnquiry) {
            /* insert enquiry details */
            if (!empty($request['projectEnquiryDetails'])) {
                foreach ($request['projectEnquiryDetails'] as $projectDetail) {
                    $projectDetail = array_merge($projectDetail, $create);
                    $projectDetail['enquiry_id'] = $insertEnquiry->id;
                    $createEnquiryDetail = EnquiryDetail::create($projectDetail);
                }
            } else {
                
            }
            /* insert follow up details */
            $request['followupDetails'] = array_merge($request['followupDetails'], $create);
            $request['followupDetails']['enquiry_id'] = $insertEnquiry->id;
            $createFollowup = EnquiryFollowup ::create($request['followupDetails']);
            $result = ['success' => true, 'message' => 'Enquiry Inserted Successfully.'];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
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
        $getEmployees = Employee::select('id', 'first_name', 'last_name', 'designation_id', 'department_id')->whereIn("department_id", [11])->get();
        if (!empty($getEmployees)) {
            $result = ['success' => true, 'records' => $getEmployees];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getEnquiryCity() {
        $getcity = lstEnquiryLocations::select('*')->with('getCityName')->groupBy('city_id')->get();
        // print_r($getcity);exit;  id":13,"country_id":2,"state_id":22,"city_id":2763,"location":
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
    /* End // get all listing controler data */
    
    public function totalEnquiries() {
        return view("MasterSales::totalEnquiries");
    }

    // get all enquiries
    public function getAllEnquiries() {
        $getCustomerEnquiryDetails = Enquiry::where([['sales_status_id', '=', 2]])->with('getEnquiryCategoryName', 'getEnquiryDetails', 'getFollowupDetails', 'channelName','customerDetails','customerContacts')->get();
        // echo json_encode($getCustomerEnquiryDetails);exit;
        if (count($getCustomerEnquiryDetails)) {
            $result = ['success' => true, 'CustomerEnquiryDetails' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'CustomerEnquiryDetails' => 'No Records Found'];
        }
        return json_encode($result);
    }
    
    public function showLostEnquiry()
    {
        return view("MasterSales::lostEnquiries");
    }

    // get all lost enquiries
    public function getLostEnquiries()
    {
        $getCustomerEnquiryDetails = Enquiry::where([['sales_status_id', '=', 4]])->with('getEnquiryCategoryName', 'getEnquiryDetails', 'getFollowupDetails', 'channelName','customerDetails','customerContacts')->get();
         if (count($getCustomerEnquiryDetails)) {
            $result = ['success' => true, 'CustomerEnquiryDetails' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'CustomerEnquiryDetails' => 'No Records Found'];
        }
        return json_encode($result);
    }
    
    public function showCloseEnquiry()
    {
        return view("MasterSales::closeEnquiries");
    }
    // get all close enquiries
    public function getCloseEnquiries()
    {
        $getCustomerEnquiryDetails = Enquiry::where([['sales_status_id', '=', 3]])->with('getEnquiryCategoryName', 'getEnquiryDetails', 'getFollowupDetails', 'channelName','customerDetails','customerContacts')->get();
         if (count($getCustomerEnquiryDetails)) {
            $result = ['success' => true, 'CustomerEnquiryDetails' => $getCustomerEnquiryDetails];
        } else {
            $result = ['success' => false, 'CustomerEnquiryDetails' => 'No Records Found'];
        }
        return json_encode($result);
    }
    
    public function getEnquiryHistory()
    {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);  
        $getFollowupDetails = EnquiryFollowup::where([['enquiry_id', '=', $request['enquiryId']]])->get();
        //print_r($getFollowupDetails);exit;
        if($getFollowupDetails)
        {
            $result = ['success' => true, 'records' => $getFollowupDetails];
        }
        else
        {
            $result = ['success' => true, 'records' => 'No record Found'];
        }
        return json_encode($result);
    }
    

}