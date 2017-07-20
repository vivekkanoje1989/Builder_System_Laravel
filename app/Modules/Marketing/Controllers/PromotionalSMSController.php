<?php namespace App\Modules\Marketing\Controllers;

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

class PromotionalSMSController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view("Marketing::index");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

        /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//$postdata = file_get_contents("php://input");
               // $request = json_decode($postdata, true);
                $input = Input::all();
                $smsbody = $input['promotionalsmsData']['sms_body'];
                $smstype = $input['promotionalsmsData']['sms_type'];
                
                if($input['promotionalsmsData']['send_sms_type'] == 1){ 
                    $mobile = $input['promotionalsmsData']['smsnumbers'];
                    //$smsresult = Gupshup::sendSMS($smsbody, $mobile, $smstype);
                    $loggedInUserId = 1;
                    $customer = "Yes";
                    $customerId = 0;
                    $isInternational = 0; //0 OR 1
                    $sendingType = $smstype; //always 0 for T_SMS
                    $smsType = "P_SMS";
                    $result = Gupshup::sendSMS($smsbody, $mobile, $loggedInUserId, $customer, $customerId, $isInternational,$sendingType, $smsType);
                    $decodeResult = json_decode($result,true);
                   // return $decodeResult["success"];
                    if($decodeResult["success"] == true){
                        $result = ['success' => true, 'message' => "SMS Send Successfully"];
                        echo json_encode($result);
                    }else{
                        $result = ['success' => false, 'message' => "SMS Not Send, Please Try Again..."];
                        echo json_encode($result);
                    }
                }elseif($input['promotionalsmsData']['send_sms_type'] == 2){
                    if(!empty($input['promotionalsmsData']['mobilenumbers'])){
                        if(!empty($input['promotionalsmsData']['mobilenumbers'])){
                        $wfileName = 'bulk_sms_file'.date('Ymd').'.'.$input['promotionalsmsData']['mobilenumbers']->getClientOriginalExtension();
                        $input['promotionalsmsData']['mobilenumbers']->move(base_path()."/common/tunes/", $wfileName);
                        $file = base_path()."/common/tunes/".$wfileName;
                        }
                        $mobile = '';
                        //$smsresult = CommonFunctions::sendBULKSMS($smsbody, $smstype, $file);
                        $data = ["fileName" => $wfileName,"filePath" => $file, "sendingType" => 1, "textSmsBody" => $smsbody, "smsType" => "bulk_sms"];
                        $result = Gupshup::sendBulkSMS($data);
                        $decodeResult = json_decode($result,true);
                        //return $decodeResult["message"];

                        if($decodeResult["success"] == true){
                            $result = ['success' => true, 'message' => "SMS Send Successfully"];
                            echo json_encode($result);
                        }else{
                            $result = ['success' => false, 'message' => "SMS Not Send, Please Try Again..."];
                            echo json_encode($result);
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
        
        
          protected function guard() {
            return Auth::guard('admin');
        }

}
