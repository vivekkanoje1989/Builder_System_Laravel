<?php

namespace App\Modules\BmsConsumption\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use App\Models\SmsLog;

class BmsConsumptionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("BmsConsumption::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    public function smsConsumption() {
        return view("BmsConsumption::smsConsumption");
    }

    public function smsReport() {
        return view("BmsConsumption::smsReport")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function smsLogs() {
        return view("BmsConsumption::smsLogs")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }
    
    public function smsLogDetails($id) {
        return view("BmsConsumption::smsLogDetails")->with('transactionId',$id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function allSmsLogs() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
            if ($request['filterFlag'] == 1) {
                BmsConsumptionController::$procname = "proc_sms_logs";
                return $this->filteredData();
                exit;
            }
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
        }
         $getSmsLoglist = array();
        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        $getSmsLogs = SmsLog::where('employee_id', $emp_id)->groupBy('externalId1')->get();
        $getCountSms = count($getSmsLogs);
    
      $getSmsLog = [];
      $getSmsLog = array();
         for($i=0; $i < $getCountSms;$i++) {
            
              $getSmsLog[] = $getSmsLogs[$i]['status'];
              
//              $getSmsLogs['mobile_number ']= $getSmsLogs[$i]['mobile_number '];
//              $getSmsLogs['sent_date_time ']= $getSmsLogs[$i]['sent_date_time '];
//              $getSmsLogs['sms_body ']= $getSmsLogs[$i]['sms_body '];
             
         }
//        print_r($getSmsLog);
        if (!empty($getSmsLogs)) {
            $result = ['success' => true, 'records' => $getSmsLogs, 'totalCount' => $getCountSms];
        } else {
            $result = ['success' => false, 'records' => $getSmsLogs, 'totalCount' => $getCountSms];
        }
        return json_encode($result);
    }

    public function store() {
        //
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

}
