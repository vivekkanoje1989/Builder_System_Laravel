<?php namespace App\Modules\MasterSales\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Modules\MasterSales\Models\Customer;
use App\Modules\MasterSales\Models\CustomersContact;
use App\Modules\MasterSales\Models\CustomersContactsLog;
use Validator;
use App\Classes\CommonFunctions;
class MasterSalesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            return view("MasterSales::index");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            return view("MasterSales::create");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            $input = Input::all();
            $validationRules = Customer::validationRules();
            $validationMessages = Customer::validationMessages();
            
            if(!empty($input['customerData'])){
                $validator = Validator::make($input['customerData'], $validationRules, $validationMessages);
                if ($validator->fails()) {
                    $result = ['success' => false, 'message' => $validator->messages()];
                    echo json_encode($result,true);
                    exit;
                }
            }
            echo "<pre>";print_r($input);exit;
            /*************************** EMPLOYEE PHOTO UPLOAD **********************************
            $imgRules = array(
                'image_file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:1000',
            );
            $validatePhotoUrl = Validator::make($input, $imgRules);
            if ($validator->fails()) {
                $result = ['success' => false, 'message' => $validator->messages()];
                echo json_encode($result);
                exit;
            }
            else{
                $fileName = time().'.'.$input['image_file']->getClientOriginalExtension();
                $input['image_file']->move(base_path()."/common/customer_photo/", $fileName);
            }
            /*************************** CUSTPMER PHOTO UPLOAD **********************************/
            $input['customerData']['birth_date'] =  date('Y-m-d', strtotime($input['customerData']['birth_date']));
            $input['customerData']['marriage_date'] =  date('Y-m-d', strtotime($input['customerData']['marriage_date']));
            
            $create = CommonFunctions::insertMainTableRecords();
            $input['customerData'] = array_merge($input['customerData'],$create);
            
//            echo "<pre>";print_r($input);exit;
            
            $createCustomer = Customer::create($input['customerData']); //insert data into employees table

            if( !empty($input['customerContacts'])){
                foreach($input['customerContacts'] as $contacts){
                    $contacts['customer_id'] = $createCustomer->id; 
                    if (!empty($contacts['mobile_number'])) {
                        $mobileNumber = explode("-", $contacts['mobile_number']);
                        $calling_code = (int) $mobileNumber[0];                        
                        $contacts['mobile_calling_code'] = !empty($mobileNumber[1]) ? $calling_code : '';
                        $contacts['mobile_number'] = $mobileNumber[1];
                    }
                    if (!empty($contacts['landline_number'])) {
                        $landlineNumber = explode("-", $contacts['landline_number']);
                        $landline_calling_code = (int) $landlineNumber[0];
                        $contacts['landline_calling_code'] =!empty($landlineNumber[1]) ?  $landline_calling_code : '';
                        $contacts['landline_number'] = (!empty($landlineNumber[1])) ? $landlineNumber[1] : '';
                    }
                    $contacts = array_merge($contacts,$create);
                    CustomersContact::create($contacts); //insert data into customer_contacts table
                    CustomersContactsLog::create($contacts); //insert data into customer_contacts_logs table
                }
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
		//
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
        
        public function getCustomerDetails()
	{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);            
            $customerMobileNo = !empty($request['data']['customerMobileNo']) ? $request['data']['customerMobileNo'] : "";
            $customerEmailId = !empty($request['data']['customerEmailId']) ? $request['data']['customerEmailId'] : "";
            
            $getCustomerContacts = CustomersContact::select('c2.*')
                    ->join('customers_contacts AS c2', 'customers_contacts.customer_id', '=', 'c2.customer_id')
                    ->where("customers_contacts.mobile_number", "=", "$customerMobileNo")
                    ->orwhere("customers_contacts.email_id", "=", "$customerEmailId")
                    ->get();
            if(count($getCustomerContacts) > 0)
            {
                $getCustomerPersonalDetails = Customer::where('id', '=', $getCustomerContacts[0]->customer_id)->get(); 
                $result = ['success' => true, 'customerPersonalDetails' => $getCustomerPersonalDetails ,'customerContactDetails' => $getCustomerContacts];
                return json_encode($result);
            }
            else{
                $result = ['success' => false, "message" => "No record found"];
                return json_encode($result);
            }
	}
        
}
