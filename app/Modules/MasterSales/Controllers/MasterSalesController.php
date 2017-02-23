<?php namespace App\Modules\MasterSales\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Modules\MasterSales\Models\Customer;
use App\Modules\MasterSales\Models\CustomersContact;
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
            
//            if(!empty($input['customerData'])){
//                $validator = Validator::make($input['customerData'], $validationRules, $validationMessages);
//                if ($validator->fails()) {
//                    $result = ['success' => false, 'message' => $validator->messages()];
//                    echo json_encode($result,true);
//                    exit;
//                }
//            }
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
//            echo "<pre>";print_r($input);exit;
            $create = CommonFunctions::insertMainTableRecords();
            $input['customerData'] = array_merge($input['customerData'],$create);
            $createCustomer = Customer::create($input['customerData']); //insert data into employees table

            if( !empty($input['customerContacts'])){
                foreach($input['customerContacts'] as $contacts){
                    $contacts['customer_id'] = $createCustomer->id; 
                    if (!empty($contacts['mobile_number'])) {
                        $mobileNumber = explode("-", $contacts['mobile_number']);
                        $calling_code = (int) $mobileNumber[0];
                        $contacts['mobile_number'] = $mobileNumber[1];
                        $contacts['calling_code'] = !empty($contacts['mobile_number']) ? $calling_code : '';
                    }
                    if (!empty($contacts['landline_number'])) {
                        $landlineNumber = explode("-", $contacts['landline_number']);
                        $landline_calling_code = (int) $landlineNumber[0];
                        $contacts['landline_calling_code'] =!empty($landlineNumber[1]) ?  $landline_calling_code : '';
                        $contacts['landline_number'] = (!empty($landlineNumber[1])) ? $landlineNumber[1] . $landlineNumber[2] : '';
                    }
                    $contacts = array_merge($contacts,$create);
                    CustomersContact::create($contacts); //insert data into employees table
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
            echo "<pre>";print_r($request);exit;
	}
        
}
