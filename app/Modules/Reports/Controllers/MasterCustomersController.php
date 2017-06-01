<?php

namespace App\Modules\MasterSales\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Modules\MasterSales\Models\Customer;
use App\Modules\MasterSales\Models\CustomersContact;
use Validator;
use DB;
use Auth;
use App\Classes\CommonFunctions;

class MasterCustomersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("MasterSales::customerindex");
    }

    public function show($type) {
        if ($type == 1) {
            return view("MasterSales::customerindex");
        } else {
            return view("MasterSales::ownerindex");
        }
    }

    public function manageCustomers() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageCustomers = [];

        if (!empty($request['customerId']) && $request['customerId'] !== "0") { // for edit
            $manageCustomers = DB::table('customers')->where('id', $request['customerId'])->get();
        } else if ($request['customerId'] == "0") {
            $result = ['success' => true, 'message' => 'New Page to create customer'];
            return json_encode($result);
        } else {
            $manageCustomers = DB::table('customers')->where('customer_type', $request['customerType'])->get();
            ;
        }
        if (!empty($manageCustomers)) {
            foreach ($manageCustomers as $index => $customer) {
                $contact_info = DB::table('customers_contacts')
                        ->leftjoin('lmsauto_master_final.mlst_states as state', 'customers_contacts.state_id', '=', 'state.id')
                        ->leftjoin('lmsauto_master_final.mlst_cities as city', 'customers_contacts.city_id', '=', 'city.id')
                        ->select('customers_contacts.*', 'state.name as state_name', 'city.name as city_name')
                        ->where('customer_id', $customer->id)
                        ->get();
                $manageCustomers[$index]->contact_info = $contact_info;
            }
            $result = ['success' => true, "records" => ["data" => $manageCustomers, "total" => count($manageCustomers), 'per_page' => count($manageCustomers), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageCustomers)]];
            echo json_encode($result);
            exit;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function create($customerType) {
        return view("MasterSales::create")->with("customerType", $customerType);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $input = Input::all();
        $validationRules = Customer::validationRules();
        $validationMessages = Customer::validationMessages();
        if (!empty($input['customerData'])) {
            $validator = Validator::make($input['customerData'], $validationRules, $validationMessages);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                echo json_encode($result, true);
                exit;
            }
        }
        /*         * ************************* EMPLOYEE PHOTO UPLOAD ********************************* */
        /* if( !empty($input['image_file'])){
          $originalName = $input['image_file']->getClientOriginalName();
          if ($originalName !== 'fileNotSelected') {
          $imgRules = array(
          'image_file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
          );
          $validateEmpPhotoUrl = Validator::make($input, $imgRules);
          if ($validateEmpPhotoUrl->fails()) {
          $result = ['success' => false, 'message' => $validator->messages()];
          echo json_encode($result);
          exit;
          } else {
          $fileName = time() . '.' . $input['image_file']->getClientOriginalExtension();
          $input['image_file']->move(base_path() . "/common/customer_photo/", $fileName);
          }
          //$project_path = "http://localhost/working_consultant";
          $input['customerData']['image_file'] = $fileName;
          }
          } */
        /*         * ************************* CUSTPMER PHOTO UPLOAD ********************************* */
        $input = Customer::doAction($input);
//            if(!empty($input['customerData']['birth_date'])){
//                $input['customerData']['birth_date'] =  date('Y-m-d', strtotime($input['customerData']['birth_date']));
//            }else{
//                $input['customerData']['birth_date'] = "0000-00-00";
//            }
//            
//            if(!empty($input['customerData']['marriage_date'])){
//                $input['customerData']['marriage_date'] =  date('Y-m-d', strtotime($input['customerData']['marriage_date']));
//            }else{
//                $input['customerData']['marriage_date'] = "";
//            }
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['customerData'] = array_merge($input['customerData'], $create);
        //print_r($input['customerData']['marriage_date']);exit;
        $createCustomer = Customer::create($input['customerData']); //insert data into customer table

        if (!empty($input['customerContacts'])) {
            foreach ($input['customerContacts'] as $contacts) {
                $contacts['customer_id'] = $createCustomer->id;
                if (!empty($contacts['mobile_number'])) {
                    $mobileNumber = explode("-", $contacts['mobile_number']);
                    $calling_code = (int) $mobileNumber[0];
                    $contacts['mobile_number'] = $mobileNumber[1];
                    $contacts['mobile_calling_code'] = !empty($contacts['mobile_number']) ? $calling_code : '';
                }
                if (!empty($contacts['landline_number'])) {
                    $landlineNumber = explode("-", $contacts['landline_number']);
                    $landline_calling_code = (int) $landlineNumber[0];
                    $contacts['landline_calling_code'] = !empty($landlineNumber[1]) ? $landline_calling_code : '';
                    $contacts['landline_number'] = (!empty($landlineNumber[1])) ? $landlineNumber[1] : '';
                }
                $contacts = array_merge($contacts, $create);
                CustomersContact::create($contacts); //insert data into employees table
            }
        }
        $result = ['success' => true, 'message' => 'Customer Added Successfully'];
        return json_encode($result);
    }

    public function edit($id, $customerType) {
        return view("MasterSales::create")->with(array('customerId' => $id, 'customerType' => $customerType));
    }

    public function update($id) {
        $originalValues = Customer::where('id', $id)->get();
        $validationMessages = Customer::validationMessages();
        $validationRules = Customer::validationRules();
        
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if(empty($input)){
            $input = Input::all();
        }
        $validator = Validator::make($input['customerData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
        if(empty($input['customerData']['loggedInUserId'])){
                $loggedInUserId = Auth::guard('admin')->user()->id;
        }else{
                $loggedInUserId = $input['customerData']['loggedInUserId'];
        }
        $input = Customer::doAction($input);
        $input['customerData']['birth_date'] = date('Y-m-d', strtotime($input['customerData']['birth_date']));
        $input['customerData']['marriage_date'] = date('Y-m-d', strtotime($input['customerData']['marriage_date']));
        $input['customerData']['updated_date'] = date('Y-m-d');
        $input['customerData']['updated_by'] = $loggedInUserId;
        $input['customerData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
        $input['customerData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $input['customerData']['updated_mac_id'] = CommonFunctions::getMacAddress();

        unset($input['customerData']['contact_info']);
        unset($input['customerData']['personal_mobile_no1']);
        unset($input['customerData']['office_mobile_no']);
        unset($input['customerData']['personal_mobile_no2']);
        unset($input['customerData']['landline_no']);
        unset($input['customerData']['password']);
        unset($input['customerData']['id']);
        unset($input['customerData']['loggedInUserId']);
        unset($input['customerData']['customerId']);
        
        $customerUpdate = Customer::where('id', $id)->update($input['customerData']);

        if (!empty($input['customerContacts'])) {
            $last = DB::table('customers_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $input['customerData']);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::table('customers_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
            if (!empty($input['customerContacts'])) {
                $contacts_ids = [];
                foreach ($input['customerContacts'] as $contacts) {
                    $contacts['customer_id'] = $id;
                    if (!empty($contacts['mobile_number'])) {
                        if (strpos($contacts['mobile_number'], '-') !== false) {
                            $mobileNumber = explode("-", $contacts['mobile_number']);
                            $calling_code = (int) $mobileNumber[0];
                            $contacts['mobile_number'] = $mobileNumber[1];
                            $contacts['mobile_calling_code'] = !empty($contacts['mobile_number']) ? $calling_code : '';
                        }else{
                            $calling_code = "91";
                            $contacts['mobile_number'] = $contacts['mobile_number'];
                            $contacts['mobile_calling_code'] = !empty($contacts['mobile_number']) ? $calling_code : '';
                        }
                    }
                    if (!empty($contacts['landline_number'])) {
                        if (strpos($contacts['landline_number'], '-') !== false) {
                            $landlineNumber = explode("-", $contacts['landline_number']);
                            $landline_calling_code = (int) $landlineNumber[0];
                            $contacts['landline_calling_code'] = !empty($landlineNumber[1]) ? $landline_calling_code : '';
                            $contacts['landline_number'] = (!empty($landlineNumber[1])) ? $landlineNumber[1] : '';
                        }else{
                            $landline_calling_code = "91";
                            $contacts['landline_number'] = $contacts['landline_number'];
                            $contacts['mobile_calling_code'] = !empty($contacts['landline_number']) ? $landline_calling_code : '';
                        }
                    }
                    $contacts['updated_date'] = date('Y-m-d');
                    $contacts['updated_by'] = $loggedInUserId;
                    $contacts['updated_IP'] = $_SERVER['REMOTE_ADDR'];
                    $contacts['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
                    $contacts['updated_mac_id'] = CommonFunctions::getMacAddress();
                    if (!empty($contacts['id'])) {
                        $customers_contact_id = $contacts['id'];
                        $originalContactValues = CustomersContact::where('id', $customers_contact_id)->get();
                        unset($contacts['id']);
                        unset($contacts['state_name']);
                        unset($contacts['city_name']);
                        unset($contacts['$hashKey']);
                        //echo "<pre>";print_r($contacts);die;
                        $customerUpdate = CustomersContact::where('id', $customers_contact_id)->update($contacts);
                        $last = DB::table('customers_contacts_logs')->latest('id')->first();
                        $getResult = array_diff_assoc($originalContactValues[0]['attributes'], $contacts);
                        $implodeArr = implode(",", array_keys($getResult));
                        $result = DB::table('customers_contacts_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
                    } else {
                        $contacts['created_date'] = date('Y-m-d');
                        $contacts['created_by'] = $loggedInUserId;
                        $contacts['created_IP'] = $_SERVER['REMOTE_ADDR'];
                        $contacts['created_browser'] = $_SERVER['HTTP_USER_AGENT'];
                        $contacts['created_mac_id'] = CommonFunctions::getMacAddress();
                        $customerContact = CustomersContact::create($contacts); //insert data into employees table
                        $customers_contact_id = $customerContact->id;
                    }
                    $contacts_ids[] = $customers_contact_id;
                }

                //delete contacts if any contact is deleted at the time of update. 
            }

            if (!empty($contacts_ids)) {
                DB::table('customers_contacts')->where('customer_id', $id)
                        ->whereNotIn('id', $contacts_ids)->delete();
            } else {
                DB::table('customers_contacts')->where('customer_id', $id)->delete();
            }
            $result = ['success' => true, 'message' => 'Customer Updated Succesfully'];
            echo json_encode($result);
        } else {

            $result = ['success' => false, 'message' => 'Error Occures while Updating the record'];
            echo json_encode($result);
        }
    }

    public function destroy($id) {
        //
    }

    public function getCustomerDetails() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        echo "<pre>";
        print_r($request);
        exit;
    }

//    public function checkMobileExist() {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
//        $mobileNumber = $request['data']['mobileNumber'];
//        if (!empty($mobileNumber)) {
//            $explodeMobileNumber = explode("-", $mobileNumber);
//            $mobileNumber = (int) $explodeMobileNumber[1];
//        }
//        
//        
//        if (!empty($request['data']['customerId'])) {
//            $checkMobile = CustomersContact::select('mobile_number')->where('mobile_number', $mobileNumber)->where('customer_id', '<>', $request['data']['customerId'])->get();
//        } else {
//            $checkMobile = CustomersContact::select('mobile_number')->where('mobile_number', $mobileNumber)->get();
//        }
//        $checkMobile = json_decode($checkMobile);
//        if (!empty($checkMobile[0]->mobile_number)) {
//            $result = ['success' => false];
//            return json_encode($result);
//        } else {
//            $result = ['success' => true];
//            return json_encode($result);
//        }
//    }
    
    
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
//echo "<pre>";print_r($checkMobile);exit;
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

}
