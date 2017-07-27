<?php

namespace App\Modules\MasterSales\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
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
use App\Models\Project;
use App\Classes\Gupshup;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\S3;

class MasterSalesController extends Controller {

    public static $procname;
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
            return response()->json($result);
        }
        $result = ["success" => true, "customerId" => $createCustomer->id];
        return response()->json($result);
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

    public function addEnquiryDetailRow() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $request = array_merge($request, $create);
        $recInserted = EnquiryDetail::create($request);
        if (1) {
            $result = ['success' => true, "enqId" => $recInserted->id];
        } else {
            $result = ['success' => false];
        }
        return response()->json($result);
    }

    public function delEnquiryDetailRow() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        EnquiryDetail::where('id', $request['enquiryDetailId'])->delete();
        $result = ['success' => true];
        return response()->json($result);
    }

    public function editCustomer($cid) {
        return view("MasterSales::index")->with(["editCustomerId" => $cid]);
    }

    public function editEnquiry($cid, $eid) {
        return view("MasterSales::index")->with(["editCustomerId" => $cid, "editEnquiryId" => $eid]);
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
            return response()->json($result);
        }
        $result = ["success" => true, "customerId" => $id];
        return response()->json($result);
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
        try {
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

                $getCustomerEnquiryDetails = DB::select('CALL proc_get_customer_open_enquiries(' . $getCustomerContacts[0]->customer_id . ')');
                $getCustomerEnquiryDetails = json_decode(json_encode($getCustomerEnquiryDetails), true);

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
        return response()->json($result);
    }

    public function getEnquiryDetails() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $enquiryId = !empty($request['data']['enquiryId']) ? $request['data']['enquiryId'] : "0";
            $customerId = !empty($request['data']['customerId']) ? $request['data']['customerId'] : "0";
            $getEnquiryDetails = DB::select('CALL proc_get_enquiry_details(' . $customerId . ',' . $enquiryId . ')');
            if (count($getEnquiryDetails) > 0) {
                $getEnquiryDetails = json_decode(json_encode($getEnquiryDetails), true);
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
                    for ($i = 0; $i < count($getEnquiryDetails); $i++) {
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
            } else {
                $result = ['success' => false];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function getCustomerDataWithId() {
        try {
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
        return response()->json($result);
    }

    public function checkMobileExist() {
        try {
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
        return response()->json($result);
    }

    public function getEnquiryHistory() {
        try {
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);
            $enquiryId = $input['enquiryId'];
            $historyList = DB::table('enquiry_followups as ef')
                    ->leftjoin('employees as e', 'e.id', '=', 'ef.followup_by_employee_id')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_enquiry_sales_statuses as mess', 'mess.id', '=', 'ef.sales_status_id')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_enquiry_sales_categories as mesc', 'mesc.id', '=', 'ef.sales_category_id')
                    ->select('ef.*', DB::raw('DATE_FORMAT(ef.followup_date_time, "%d-%m-%Y at %h:%i %p") as last_followup_date'), DB::raw('DATE_FORMAT(ef.next_followup_date, "%d-%m-%Y") as next_followup_date'), DB::raw('DATE_FORMAT(ef.next_followup_time, "%h:%i %p") as next_followup_time'), 'e.first_name', 'e.last_name', 'mess.sales_status', 'mesc.enquiry_category')
                    ->where('ef.enquiry_id', $enquiryId)
                    ->orderBy('ef.id', 'asc  ')
                    ->get();

            if ($historyList) {
                $result = ['success' => true, 'records' => $historyList];
            } else {
                $result = ['success' => false, 'records' => $historyList];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    // insert new enquiry 
    public function saveEnquiry() {
        try {
//            $validationRules = Enquiry::validationRules();
//            $validationMessages = Enquiry::validationMessages();
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
//            $userAgent = $_SERVER['HTTP_USER_AGENT'];
//            if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
//                $validator = Validator::make($request['enquiryData'], $validationRules, $validationMessages);
//                if ($validator->fails()) {
//                    $result = ['success' => false, 'message' => $validator->messages()];
//                    return json_encode($result, true);
//                }
//            }
            if (empty($request['enquiryData']['loggedInUserId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['enquiryData']['loggedInUserId'];
            }
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $customerInfo = Customer::select('source_id', 'subsource_id', 'source_description')->where('id', $request['customer_id'])->get();

            /*  insert enquiry  */
            $request['enquiryData'] = array_merge($request['enquiryData'], $create);
            $request['enquiryData']['customer_id'] = $request['customer_id'];
            $request['enquiryData']['client_id'] = 1;
            $request['enquiryData']['sales_employee_id'] = $loggedInUserId;

            if (!empty($request['enquiryData']['sales_channel_id'])) {
                $request['enquiryData']['sales_channel_id'] = $request['enquiryData']['sales_channel_id'];
            } else {
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

            unset($request['enquiryData']['project_id'], $request['enquiryData']['block_id'], $request['enquiryData']['sub_block_id'], $request['enquiryData']['enquiry_category_id'], $request['enquiryData']['city_id'], $request['enquiryData']['csrfToken'], $request['enquiryData']['next_followup_date'], $request['enquiryData']['next_followup_time']);
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
                $request['followupDetails']['call_recording_log_type'] = $request['followupDetails']['call_recording_id'] = $request['followupDetails']['finance_category_id'] = $request['followupDetails']['finance_subcategory_id'] = $request['followupDetails']['finance_status_id'] = $request['followupDetails']['finance_substatus_id'] = 0;
                $request['followupDetails']['next_followup_date'] = $next_followup_date;

                if (isset($next_followup_time)) {
                    $request['followupDetails']['next_followup_time'] = $next_followup_time;
                } else {
                    $request['followupDetails']['next_followup_time'] = date('H:i:s');
                }
                $checkEnquiryExist = Enquiry::selectRaw('max(id) as maxenqid')->where('customer_id', $request['customer_id'])->get();
                if (!empty($checkEnquiryExist[0]['maxenqid'])) {
                    EnquiryFollowup::where('id', $checkEnquiryExist[0]['maxenqid'])->update(['actual_followup_date_time' => date('Y-m-d H:m:s')]);
                }
                $request['followupDetails']['actual_followup_date_time'] = "0000-00-00 00:00:00";
                $request['followupDetails']['sales_category_id'] = $request['enquiryData']['sales_category_id'];
                $request['followupDetails']['sales_subcategory_id'] = $request['followupDetails']['sales_status_id'] = $request['followupDetails']['sales_substatus_id'] = 1;

                $request['followupDetails'] = array_merge($request['followupDetails'], $create);
                EnquiryFollowup ::create($request['followupDetails']);

                $result = ['success' => true, 'message' => 'Record Inserted Successfully.'];
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong'];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function updateEnquiry() {
        try {
            $validationRules = Enquiry::validationRules();
            $validationMessages = Enquiry::validationMessages();
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);

             $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
                $validator = Validator::make($request['enquiryData'], $validationRules, $validationMessages);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    return json_encode($result, true);
                }
            }
            if (empty($request['enquiryData']['loggedInUserId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['enquiryData']['loggedInUserId'];
            }

            unset($request['enquiryData']['project_id'], $request['enquiryData']['block_id'], $request['enquiryData']['sub_block_id'], $request['enquiryData']['enquiry_category_id'], $request['enquiryData']['city_id'], $request['enquiryData']['csrfToken'], $request['enquiryData']['next_followup_date'], $request['enquiryData']['next_followup_time'], $request['enquiryData']['project_name'], $request['enquiryData']['block_name'], $request['enquiryData']['block_sub_type'], $request['enquiryData']['followup_by_employee_id'], $request['enquiryData']['remarks'], $request['enquiryData']['enqdetails_id'], $request['enquiryData']['loggedInUserId']);

            /*  update enquiry  */
            if (!empty($request['enquiryData']['sales_channel_id'])) {
                $request['enquiryData']['sales_channel_id'] = $request['enquiryData']['sales_channel_id'];
            } else {
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

//            unset($request['enquiryData']['project_id'],$request['enquiryData']['block_id'],$request['enquiryData']['sub_block_id'],
//                    $request['enquiryData']['enquiry_category_id'],$request['enquiryData']['city_id'],$request['enquiryData']['csrfToken'],
//                    $request['enquiryData']['next_followup_date'],$request['enquiryData']['next_followup_time'],
//                    $request['enquiryData']['project_name'],$request['enquiryData']['block_name'],$request['enquiryData']['block_sub_type'],
//                    $request['enquiryData']['followup_by_employee_id'],$request['enquiryData']['remarks'],$request['enquiryData']['enqdetails_id'],$request['enquiryData']['loggedInUserId']);

            $update = Enquiry::where('id', $request['enquiryData']['id'])->update($request['enquiryData']);

            if (!empty($request['projectEnquiryDetails'])) {
                foreach ($request['projectEnquiryDetails'] as $projectDetail) {
                    $getProjectId = EnquiryDetail::select("id")->where(['enquiry_id' => $request['enquiryData']['id'], 'project_id' => $projectDetail['project_id'], 'block_id' => $projectDetail['block_id'], 'sub_block_id' => $projectDetail['sub_block_id']])->get();
                    if (empty($getProjectId[0]['id'])) {
                        $projectDetail['enquiry_id'] = $request['enquiryData']['id'];
                        EnquiryDetail::create($projectDetail);
                    }
                }
            }

            if ($update) {
                $result = ['success' => true, 'message' => 'Record updated Successfully.'];
            } else {
                $result = ['success' => false, 'message' => 'Record not updated.'];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    /* get all listing controler data */

    public function getEmployees() {
        $getEmployees = Employee::select('id', 'first_name', 'last_name', 'designation_id')->get();
        if (!empty($getEmployees)) {
            $result = ['success' => true, 'records' => $getEmployees];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return response()->json($result);
    }

    public function getFinanceEmployees() {
        try {
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
        return response()->json($result);
    }

    public function getEnquiryCity() {
        $getcity = lstEnquiryLocations::select('*')->with('getCityName')->groupBy('city_id')->get();
        if (!empty($getcity)) {
            $result = ['success' => true, 'records' => $getcity];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return response()->json($result);
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
        return response()->json($result);
    }

    public function getDataForTodayRemark() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $getRemarkDetails = DB::select('CALL proc_get_today_remark(' . $request['enquiryId'] . ')');
            $decodeRemarkDetails = json_decode(json_encode($getRemarkDetails), true);
            $projectId = $blockId = $emailId = array();
            if (!empty($decodeRemarkDetails[0]['project_block_id'])) {
                $explodeComma = explode(",", $decodeRemarkDetails[0]['project_block_id']);
                if (!empty($explodeComma)) {
                    foreach ($explodeComma as $value) {
                        $explodeDash = explode("-", $value);
                        $projectId[] = $explodeDash[0];
                        $blockId[] = $explodeDash[1];
                    }
                }
            }

            if (!empty($decodeRemarkDetails[0]['customer_mobile_no'])) {
                $mobileNumber = explode(",", $decodeRemarkDetails[0]['customer_mobile_no']);
                $mobileNumber = array_unique($mobileNumber);
            }
            if (!empty($decodeRemarkDetails[0]['customer_email_id'])) {
                $emailId = explode(",", $decodeRemarkDetails[0]['customer_email_id']);
                $emailId = array_values(array_filter($emailId));
                $emailId = array_unique($emailId);
            }
            $getProjects = Project::select("id", "project_name")->whereIn('id', $projectId)->get();
            $getBlocks = MlstBmsbBlockType::select("id", "block_name")->whereIn('id', $blockId)->get();

            $decodeRemarkDetails['selectedProjects'] = $getProjects;
            $decodeRemarkDetails['selectedBlocks'] = $getBlocks;
            $decodeRemarkDetails['mobileNumber'] = $mobileNumber;
            $decodeRemarkDetails['emailId'] = $emailId;
            if (count($decodeRemarkDetails) != 0) {
                $result = ['success' => true, 'data' => $decodeRemarkDetails];
            } else {
                $result = ['success' => false, 'errorMsg' => 'Something went wrong'];
            }
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function insertTodayRemark() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $input = $request['data'];
            $enquiryId = $input['enquiry_id'];
            $followupId = $input['followupId'];
            $customerId = $input['customerId'];
            if (!empty($input['title_id']) && !empty($input['first_name']) && !empty($input['last_name'])) {
                $titleId = $input['title_id'];
                $firstName = $input['first_name'];
                $lastName = $input['last_name'];
            }
            if (!empty($input['source_id']) && !empty($input['subsource_id']) && !empty($input['source_description'])) {
                $sourceId = $input['source_id'];
                $subSourceId = $input['subsource_id'];
                $sourceDescription = $input['source_description'];
            }

            if (!empty($input)) {
                $todayDate = date('Y-m-d H:i:s');
                EnquiryFollowup::where('id', $followupId)->update(["actual_followup_date_time" => $todayDate]);
                $input['next_followup_date'] = date('Y-m-d', strtotime($input['next_followup_date']));
                $input['next_followup_time'] = date('H:i:s', strtotime($input['next_followup_time']));
                $input['actual_followup_date_time'] = "0000-00-00 00:00:00";
                if ($input['textRemark'] !== '') {
                    $input['remarks'] = $input['textRemark'];
                    $msg = 'Remark inserted successfully';
                } else if ($input['msgRemark'] !== '') {
                    $input['remarks'] = $input['msgRemark'];

                    $implodeMobileNo = implode(",", $input['mobileNumber']);
                    $mobileNo = $implodeMobileNo;
                    $customer = "No";
                    $isInternational = 0; //0 OR 1
                    $sendingType = 0; //always 0 for T_SMS
                    $smsType = "T_SMS";
                    $smsBody = $input['msgRemark'];
                    $result = Gupshup::sendSMS($smsBody, $mobileNo, $loggedInUserId, $customer, $customerId, $isInternational, $sendingType, $smsType);
                    $decodeResult = json_decode($result, true);
                    $msg = $decodeResult["message"];
                } else {
                    $input['remarks'] = $input['email_content'];
                    $implodeEmailId = implode(",", $input['email_id_arr']);
                    $userName = "support@edynamics.co.in";
                    $password = "edsupport@2016#";
                    $mailBody = $input['email_content'];
                    $companyName = config('global.companyName');
                    $subject = $input['subject'];
                    $data = ['mailBody' => $mailBody, "fromEmail" => "support@edynamics.co.in", "fromName" => $companyName, "subject" => $subject, "to" => $implodeEmailId, "cc" => ""];
                    $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
                    if ($sentSuccessfully)
                        $msg = "Email sent successfully";
                    else {
                        $msg = "Email not sent successfully";
                    }
                }
                unset($input['followupId'], $input['customerId'], $input['title_id'], $input['first_name'], $input['last_name'], $input['source_id'], $input['subsource_id'], $input['source_description'], $input['textRemark'], $input['msgRemark'], $input['email_content'], $input['subject']);

                $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
                $input = array_merge($input, $create);
                $insertFollowup = EnquiryFollowup::create($input);
            }
            if (!empty($request['custInfo'])) {
                Customer::where('id', $customerId)->update(["title_id" => $titleId, "first_name" => $firstName, "last_name" => $lastName]);
            }
            if (!empty($request['sourceInfo'])) {
                Customer::where('id', $customerId)->update(["source_id" => $sourceId, "subsource_id" => $subSourceId, "source_description" => $sourceDescription]);
                Enquiry::where('id', $enquiryId)->update(["sales_source_id" => $sourceId, "sales_subsource_id" => $subSourceId, "sales_source_description" => $sourceDescription]);
            }
            if ($insertFollowup) {
                $result = ['success' => true, 'message' => $msg];
            } else {
                $result = ['success' => false, 'message' => 'Remark not inserted'];
            }
        } catch (Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function filteredData() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $filterData = $request['filterData'];
        //  print_r($request);exit;
        if (empty($request['empId'])) { // For Web
            $loggedInUserId = Auth::guard('admin')->user()->id;
            if ($request['teamType'] == 1) {
                $this->getTeamIds($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;
            }

            if (!empty($filterData["category_id"])) {
                $category = explode("_", $filterData["category_id"]);
            }
            if (!empty($filterData["source_id"])) {
                $source = explode("_", $filterData["source_id"]);
            }
            if (!empty($filterData["status_id"])) {
                $status = explode("_", $filterData["status_id"]);
            }
            if (!empty($filterData["city_id"])) {
                $city = explode("_", $filterData["city_id"]);
            }
//             if (!empty($filterData["lostReason_id"])) {
//                $reason = explode("_", $filterData["lostReason_id"]);
//            }
            $filterData["category_id"] = !empty($filterData["category_id"]) ? $category[0] : "";
            $filterData["source_id"] = !empty($filterData['source_id']) ? $source[0] : "";
            $filterData['status_id'] = !empty($filterData['status_id']) ? $status[0] : "";
            $filterData['city_id'] = !empty($filterData['status_id']) ? $city[0] : "";
            //$filterData["lostReason_id"] = !empty($filterData['lostReason_id']) ? $reason[0] : "";
        } else { // For App
            $request["getProcName"] = MasterSalesController::$procname;
            $loggedInUserId = $request['empId'];
            if (!empty($request['teamType']) && $request['teamType'] == 1) {
                $this->getTeamIds($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;
            }

            $filterData["category_id"] = !empty($filterData["category_id"]) ? $filterData["category_id"] : "";
            $filterData["source_id"] = !empty($filterData['source_id']) ? $filterData["source_id"] : "";
            $filterData["status_id"] = !empty($filterData['status_id']) ? $filterData["status_id"] : "";
            // $filterData["lostReason_id"] = !empty($filterData['lostReason_id']) ? $filterData['status_id'] : "";
        }
        //$filterData["project_id"] = !empty($filterData['project_id']) ? implode(',', array_column($filterData['project_id'], 'id')) : "";

        $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        $filterData["fname"] = !empty($filterData['fname']) ? $filterData['fname'] : "";
        $filterData["lname"] = !empty($filterData['lname']) ? $filterData['lname'] : "";
        $filterData["emailId"] = !empty($filterData['emailId']) ? $filterData['emailId'] : "";
        $filterData["mobileNubmer"] = !empty($filterData['mobileNubmer']) ? $filterData['mobileNubmer'] : "";
        $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
        $filterData["toDate"] = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
        $filterData["subcategory_id"] = !empty($filterData['subcategory_id']) ? implode(',', array_column($filterData['subcategory_id'], 'id')) : "";
        $filterData["subsource_id"] = !empty($filterData['subsource_id']) ? implode(',', array_column($filterData['subsource_id'], 'id')) : "";
        $filterData["project_id"] = !empty($filterData['project_id']) ? implode(',', array_column($filterData['project_id'], 'id')) : "";
        $filterData["enquiry_locations"] = !empty($filterData['enquiry_locations']) ? implode(',', array_column($filterData['enquiry_locations'], 'id')) : "";
        $filterData["parking_required"] = (!empty($filterData['parking_required']) || isset($filterData['parking_required'])) ? $filterData['parking_required'] : "";
        $filterData["loan_required"] = (!empty($filterData['loan_required']) || isset($filterData['loan_required'])) ? $filterData['loan_required'] : "";
        $filterData["site_visited"] = !empty($filterData['site_visited']) ? $filterData['site_visited'] : "";
        $filterData["channel_id"] = !empty($filterData['channel_id']) ? $filterData['channel_id'] : "";
        $filterData["maxbudget"] = !empty($request['maxBudget']) ? $request['maxBudget'] : 0;
        $filterData["minbudget"] = !empty($request['minBudget']) ? $request['minBudget'] : 0;
        $filterData["mobileNumber"] = !empty($filterData['mobileNumber']) ? $filterData['mobileNumber'] : "";
        $filterData["verifiedMobNo"] = !empty($filterData['verifiedMobNo']) ? $filterData['verifiedMobNo'] : "";
        $filterData["verifiedEmailId"] = !empty($filterData['verifiedEmailId']) ? $filterData['verifiedEmailId'] : "";
        //print_r($filterData);exit;
        $getEnquiryDetails = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["fname"] . '","' . $filterData["lname"] . '","' .
                        $filterData["emailId"] . '","' . $filterData["mobileNumber"] . '","' . $filterData["fromDate"] . '","' . $filterData["toDate"] . '","' .
                        $filterData["category_id"] . '","' . $filterData["subcategory_id"] . '","' . $filterData["source_id"] . '","' . $filterData["subsource_id"] . '","' .
                        $filterData["parking_required"] . '","' . $filterData["loan_required"] . '","' . $filterData["project_id"] . '","' . $filterData["enquiry_locations"] . '","' .
                        $filterData["channel_id"] . '","' . $filterData['minbudget'] . '","' . $filterData['maxbudget'] . '","' . $filterData["verifiedMobNo"] . '","' . $filterData["verifiedEmailId"] . '",' . $request['pageNumber'] . ',' . $request['itemPerPage'] . ')');
        //print_r($getEnquiryDetails);exit;
        $cnt = DB::select('select FOUND_ROWS() totalCount');
        $getEnquiryDetails = json_decode(json_encode($getEnquiryDetails), true);

        if (count($getEnquiryDetails) != 0) {
            $result = ['success' => true, 'records' => $getEnquiryDetails, 'totalCount' => $cnt[0]->totalCount];
        } else {
            $result = ['success' => false, 'records' => 'No Records Found'];
        }
        return response()->json($result);
    }

    /*     * ********************* ENQUIRY LISTING ************************ */

    public function totalEnquiry($type) {
        return view("MasterSales::totalEnquiries")->with("type", $type);
    }

    public function getTotalEnquiries() { // get all enquiries
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            if ($request['teamType'] == 0) { // total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
            } else { // team total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
                $this->allusers = array();
                $this->getTeamIds($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = implode(',', $alluser);
            }
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            $getTotalEnquiryDetails = DB::select('CALL proc_get_total_enquiries("' . $loggedInUserId . '","","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0,' . $startFrom . ',' . $request['itemPerPage'] . ')');
            $cnt = DB::select('select FOUND_ROWS() as totalCount');
            $getTotalEnquiryDetails = json_decode(json_encode($getTotalEnquiryDetails), true);
            if (count($getTotalEnquiryDetails) != 0) {
                $result = ['success' => true, 'records' => $getTotalEnquiryDetails, 'totalCount' => $cnt[0]->totalCount];
            } else {
                $result = ['success' => false, 'records' => 'No Records Found'];
            }
        } catch (Exception $ex) {
            $result = ['success' => false, 'status' => 412, 'message' => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function showTodaysFollowups($type) {
        return view("MasterSales::todaysfollowups")->with("type", $type);
    }

    public function getTodaysFollowups() {// Todays Followups 
        try {

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);

            if ($request['teamType'] == 0) { // total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
            } else { // team total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
                $this->allusers = array();
                $this->getTeamIds($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = implode(',', $alluser);
            }
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            $getTodaysFollowups = DB::select('CALL proc_get_today_followups("' . $loggedInUserId . '","","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0,' . $startFrom . ',' . $request['itemPerPage'] . ')');
            $cnt = DB::select('select FOUND_ROWS() as totalCount');
            $getTodaysFollowups = json_decode(json_encode($getTodaysFollowups), true);

            if (count($getTodaysFollowups) != 0) {
                $result = ['success' => true, 'records' => $getTodaysFollowups, 'totalCount' => $cnt[0]->totalCount];
            } else {
                $result = ['success' => false, 'records' => 'No record Found'];
            }
        } catch (Exception $ex) {
            $result = ['success' => false, 'status' => 412, 'message' => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function lostEnquiries($type) {
        return view("MasterSales::lostenquiries")->with("type", $type);
    }

    public function getLostEnquiries() {// get lost enquiries
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);

            if ($request['teamType'] == 0) { // total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
            } else { // team total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
                $this->allusers = array();
                $this->getTeamIds($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = implode(',', $alluser);
            }
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            $getlostEnquiryDetails = DB::select('CALL proc_get_lost_enquiries("' . $loggedInUserId . '","","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0,' . $startFrom . ',' . $request['itemPerPage'] . ')');
            $cnt = DB::select('select FOUND_ROWS() as totalCount');
            $getlostEnquiryDetails = json_decode(json_encode($getlostEnquiryDetails), true);

            if (count($getlostEnquiryDetails) != 0) {
                $result = ['success' => true, 'records' => $getlostEnquiryDetails, 'totalCount' => $cnt[0]->totalCount];
            } else {
                $result = ['success' => false, 'records' => 'No Records Found'];
            }
        } catch (Exception $ex) {
            $result = ['success' => false, 'status' => 412, 'message' => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function bookedEnquiries($type) {
        return view("MasterSales::bookedenquiry")->with("type", $type);
    }

    public function getBookedEnquiries() {// get booked enquiries
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            if ($request['teamType'] == 0) { // total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
            } else { // team total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
                $this->allusers = array();
                $this->getTeamIds($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = implode(',', $alluser);
            }
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            $getbookedEnquiryDetails = DB::select('CALL proc_get_booked_enquiries("' . $loggedInUserId . '","","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0,' . $startFrom . ',' . $request['itemPerPage'] . ')');
            $cnt = DB::select('select FOUND_ROWS() as totalCount');
            $getbookedEnquiryDetails = json_decode(json_encode($getbookedEnquiryDetails), true);

            if (count($getbookedEnquiryDetails) != 0) {
                $result = ['success' => true, 'records' => $getbookedEnquiryDetails, 'totalCount' => $cnt[0]->totalCount];
            } else {
                $result = ['success' => false, 'records' => 'No Records Found'];
            }
        } catch (Exception $ex) {
            $result = ['success' => false, 'status' => 412, 'message' => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function showPreviousFollowups($type) {
        return view("MasterSales::previousFollowup")->with("type", $type);
    }

    public function previousFollowups() {// Previous Followups 
        try {

            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);

            if ($request['teamType'] == 0) { // total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
            } else { // team total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
                $this->allusers = array();
                $this->getTeamIds($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = implode(',', $alluser);
            }
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];

            $getCustomerEnquiryDetails = DB::select('CALL proc_get_previous_followups("' . $loggedInUserId . '","","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0,' . $startFrom . ',' . $request['itemPerPage'] . ')');
            $cnt = DB::select('select FOUND_ROWS() as totalCount');
            $getCustomerEnquiryDetails = json_decode(json_encode($getCustomerEnquiryDetails), true);
            if (count($getCustomerEnquiryDetails) != 0 && !empty($getCustomerEnquiryDetails[0]['id'])) {
                $result = ['success' => true, 'records' => $getCustomerEnquiryDetails, 'totalCount' => $cnt[0]->totalCount];
            } else {
                $result = ['success' => false, 'records' => 'No record Found'];
            }
        } catch (Exception $ex) {
            $result = ['success' => false, 'status' => 412, 'message' => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function showPendingFollowups($type) {
        return view("MasterSales::pendingFollowup")->with("type", $type);
    }

    public function getPendingFollowups() {// Pending Followups 
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);

            if ($request['teamType'] == 0) { // total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
            } else { // team total
                if (empty($request['empId']))
                    $loggedInUserId = Auth::guard('admin')->user()->id;
                else
                    $loggedInUserId = $request['empId'];
                $this->allusers = array();
                $this->getTeamIds($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = implode(',', $alluser);
            }
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            $getpendingfollowups = DB::select('CALL proc_get_pending_followups("' . $loggedInUserId . '","","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0,' . $startFrom . ',' . $request['itemPerPage'] . ')');
            $cnt = DB::select('select FOUND_ROWS() as totalCount');
            $getpendingfollowups = json_decode(json_encode($getpendingfollowups), true);

            if (count($getpendingfollowups) != 0) {
                $result = ['success' => true, 'records' => $getpendingfollowups, 'totalCount' => $cnt[0]->totalCount];
            } else {
                $result = ['success' => false, 'records' => 'No record Found'];
            }
        } catch (Exception $ex) {
            $result = ['success' => false, 'status' => 412, 'message' => $ex->getMessage()];
        }
        return response()->json($result);
    }

    /*     * ******************** TEAM ENQUIRIES **************************** */

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

        if (empty($request['loggedInUserID']))
            $loggedInUserId = Auth::guard('admin')->user()->id;
        else
            $loggedInUserId = $request['loggedInUserID'];

        $this->allusers = array();
        $this->getTeamIds($loggedInUserId);
        $alluser = $this->allusers;
        $empTeamIds = implode(',', $alluser);
        $enquiries = DB::select('CALL proc_get_total_enquiries(\'"' . $empTeamIds . '"\',"","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0)');
        $enquiries = json_decode(json_encode($enquiries), true);

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return response()->json($result);
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

        $enquiries = DB::select('CALL proc_get_lost_enquiries(\'"' . $empTeamIds . '"\',"","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0)');
        $enquiries = json_decode(json_encode($enquiries), true);

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return response()->json($result);
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

        $enquiries = DB::select('CALL proc_get_closed_enquiries(\'"' . $empTeamIds . '"\',"","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0)');
        $enquiries = json_decode(json_encode($enquiries), true);

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return response()->json($result);
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

        $enquiries = DB::select('CALL proc_get_today_followups(\'"' . $empTeamIds . '"\',"","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0)');
        $enquiries = json_decode(json_encode($enquiries), true);

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return response()->json($result);
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

        $enquiries = DB::select('CALL proc_get_pending_followups(\'"' . $empTeamIds . '"\',"","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0)');
        $enquiries = json_decode(json_encode($enquiries), true);

        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return response()->json($result);
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

        $enquiries = DB::select('CALL proc_get_previous_followups(\'"' . $empTeamIds . '"\',"","","","","0000-00-00","0000-00-00","","","","","","","","","",0,0,0,0)');
        $enquiries = json_decode(json_encode($enquiries), true);

        if (count($enquiries) > 0 && !empty($enquiries[0]['id'])) {
            $result = ['success' => true, 'records' => $enquiries];
        } else {
            $result = ['success' => false, 'records' => 'No record Found'];
        }
        return response()->json($result);
    }

    public function exportToExcel() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $data = $request['result'];

        $reportName = $request['reportName'];
        $currentDate = date('_d_m_Y_h_A');
        $fileName = $reportName . $currentDate . "_by_" . Auth::guard('admin')->user()->first_name . "_" . Auth::guard('admin')->user()->last_name;

        $getS3Url = config('global.s3Path');
        ob_end_clean();
        Excel::create($fileName, function($excel) use ($data, $reportName) {
            $excel->sheet($reportName, function($sheet) use ($data, $reportName) {
                $sheet->mergeCells('A1:P1');
                $sheet->setHeight("1", 45);
                $sheet->cells('A1:P1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontColor('#315AD7');
                    $cells->setBackground('#D6D6D6');
                    $cells->setBorder('thick', 'thick', 'thick', 'thick'); // Set all borders (top, right, bottom, left)
                    $cells->setFont(array(
                        'family' => 'Calibri',
                        'size' => '25',
                    ));
                });

                $sheet->mergeCells('A2:P2');

                $title = str_replace('_', ' ', $reportName);
                $sheet->row(1, array('BMS BUILDER - ' . $title));

                // setting column names for data - you can of course set it manually
                $sheet->appendRow(["Sr.No", "Date of enquiry", "Customer Details", "Mobile Numbers", "Landline Number",
                    "Email Ids", "Project Details", "Enquiry Category", "Last Followup By", "Last Followup Remarks",
                    "Next Followup", "Enquiry Status", "Enquiry Source", "Enquiry Sub Source", "Enquiry Source Description", "Enquiry Owner"]); // column names
                $sheet->row(3, function ($row) {
                    $row->setAlignment('center');
                    $row->setBackground('#f9c955');
                    $row->setFont(array(
                        'family' => 'Calibri',
                        'size' => '12',
                    ));
                });

                $i = 1;
                // putting users data as next rows
                foreach ($data as $user) {
                    $srno = ["srno" => $i++];
                    $getFilterData = [$user["sales_enquiry_date"], $user["customer_fname"] . " " . $user["customer_lname"],
                        $user["group_mobile_number"], $user["group_landline_number"], $user["group_email_id"], $user["project_block_name"],
                        $user["enquiry_category"], $user["last_followup_date"],
                        $user["remarks"], $user["next_followup_date"] . " " . $user["next_followup_time"],
                        $user["sales_status"], $user["sales_source_id"], $user["sales_subsource_id"],
                        $user["sales_source_description"], $user["owner_fname"] . " " . $user["owner_lname"]];

                    $user = array_merge($srno, $getFilterData);
                    $sheet->appendRow($user);
                }
            });
        })->save('XLS', "downloads/");

        $file_url = 'http://localhost/Builder_System_Laravel/public/downloads/' . $fileName . ".xls";

        $result = ['success' => true, 'sheetName' => $fileName . ".xls", "fileUrl" => $file_url];
        return response()->json($result);
    }

    public function updateCustomer($id) {
        return view('MasterSales::updateCustomer')->with('id', $id);
    }

}
