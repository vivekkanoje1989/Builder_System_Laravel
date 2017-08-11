<?php

namespace App\Modules\CloudTelephony\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
//use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Auth;
use App\Models\CtBillingSetting;
use App\Models\EmployeesDevice;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use File;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Classes\CommonFunctions;

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

    public function manageLists() {

        //$authUser = \Auth()->guard('admin')->user();
        //print_r($authUser);exit;

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageLists = [];
        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
            $manageLists = DB::select('CALL proc_manage_ctbillingsettings(1,' . $request["id"] . ')');
            //echo "here"; print_r($manageLists);exit;
        } else if ($request['id'] === "") {
            $manageLists = DB::select('CALL proc_manage_ctbillingsettings(0,0)');
        }

        if ($manageLists) {
            $result = ['success' => true, "records" => ["data" => $manageLists, "total" => count($manageLists), 'per_page' => count($manageLists), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageLists)]];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
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
