<?php

namespace App\Modules\CustomAlerts\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplatesCustom;
use App\Models\TemplatesCustomsLog;
use App\Classes\CommonFunctions;
use DB;
use Auth;
use Excel;

class CustomAlertsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("CustomAlerts::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("CustomAlerts::customalertcreate");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $last = TemplatesCustom::latest('id')->first();
        if (!empty($last)) {
            $sr_no = $last->sr_no + 1;
        } else {
            $sr_no = 1;
        }
        $request['customAlertData']['sr_no'] = $sr_no;
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $request['customAlertData'] = array_merge($request['customAlertData'], $create);
        $result = TemplatesCustom::create($request['customAlertData']);
        if ($result) {
            $result = ['success' => true, 'message' => 'Custom Template created successfully.'];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
        }
        echo json_encode($result);
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
        return view("CustomAlerts::customalertcreate")->with(array('alertId' => $id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        
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

    public function manageCustomAlerts() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $master = config('global.masterdatabase');

        $manageAlerts = [];

        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
            $manageAlerts = TemplatesCustom::select('*')->where('id', '=', $request['id'])->get();
        } else if ($request['id'] === "") { // for index
            $manageAlerts = DB::table('templates_customs as tc')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_templates_events as te', 'tc.template_event_id', '=', 'te.id')
                    ->select('tc.*', 'te.event_name')
                    ->where('tc.client_id', '=', 1)
                    ->where('tc.deleted_status', '!=', 1)->get();
        }
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        }else{
              $export = '';
        }
        if (in_array('01402', $array)) {
            $deleteBtn = 1;
        } else {
            $deleteBtn = '';
        }
        if ($manageAlerts) {
            $result = ['success' => true, "records" => ["data" => $manageAlerts, 'exportData' => $export,'delete'=>$deleteBtn, "total" => count($manageAlerts), 'per_page' => count($manageAlerts), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageAlerts)]];
        }else{
            $result = ['success' => false, "records" => ["data" => $manageAlerts, 'exportData' => $export,'delete'=>$deleteBtn, "total" => count($manageAlerts), 'per_page' => count($manageAlerts), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageAlerts)]];
        }
        return json_encode($result);
    }

    
     public function deleteCustomTemplate() {
         $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['customData'] = array_merge($request, $create);
        $customTemplates = TemplatesCustom::where('id', $request['id'])->update($input['customData']);
        $result = ['success' => true, 'result' => $customTemplates];
        return json_encode($result);
        
    }
    public function updateCustomAlerts() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $request['customAlertData']['updated_date'] = date('Y-m-d');
        $request['customAlertData']['updated_by'] = Auth::guard('admin')->user()->id;
        $request['customAlertData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
        $request['customAlertData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $request['customAlertData']['updated_mac_id'] = CommonFunctions::getMacAddress();
        $originalValues = TemplatesCustom::where('id', $request['id'])->get();
        //echo "<pre>";print_r($request);die;
        $CustomAlertUpdate = TemplatesCustom::where('id', $request['id'])->update($request['customAlertData']);
        $last = TemplatesCustomsLog::latest('id')->first();
        $getResult = array_diff_assoc($originalValues[0]['attributes'], $request['customAlertData']);
        $implodeArr = implode(",", array_keys($getResult));
        $result = DB::table('templates_customs_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
        $data = ['success' => true, 'message' => 'Custom Template updated succesfully'];
        return json_encode($data);
    }

    public function customTemplatesExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getCount = DB::table('templates_customs as tc')
                            ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_templates_events as te', 'tc.template_event_id', '=', 'te.id')
                            ->select('tc.*', 'te.event_name')
                            ->where('tc.client_id', '=', 1)
                            ->get()->count();
            $manageAlerts = DB::table('templates_customs as tc')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_templates_events as te', 'tc.template_event_id', '=', 'te.id')
                    ->select('tc.*', 'te.event_name')
                    ->where('tc.client_id', '=', 1)
                    ->get();
            $customAlerts = array();
            $j = 1;
            $manageAlerts = json_decode(json_encode($manageAlerts), true);
            for ($i = 0; $i < count($manageAlerts); $i++) {
                $customAlert['Sr No'] = $j++;
                $customAlert['Template For'] = $manageAlerts[$i]['friendly_name'];
                $customAlert['Email Subject'] = $manageAlerts[$i]['email_subject'];
                $customAlert['Sms Body'] =   str_replace('&nbsp;','',strip_tags(preg_replace( "/\r|\n/", "",$manageAlerts[$i]['sms_body'])));
                $customAlerts[] = $customAlert;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Default Template Data', function($excel) use($customAlerts) {
                    $excel->sheet('sheet1', function($sheet) use($customAlerts) {
                        $sheet->fromArray($customAlerts);
                    });
                })->download('csv');
            }
        }
    }

}
