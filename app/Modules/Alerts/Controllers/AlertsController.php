<?php
namespace App\Modules\Alerts\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\TemplatesSetting;
use App\Models\TemplatesSettingsLog;
use App\Models\TemplatesCustom;
use App\Models\backend\Employee;

class AlertsController extends Controller {

    public function index() {
        return view("Alerts::index");
    }

    public function edit($id) {
        return view("Alerts::alertupdate")->with(array('alertId' => $id, 'customerType' => 1));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $result = ['success' => true, 'records' => $request];
        echo json_encode($result);
    }

    public function updateAlerts() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $request['alertData']['updated_date'] = date('Y-m-d');
        $request['alertData']['updated_by'] = Auth::guard('admin')->user()->id;
        $request['alertData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
        $request['alertData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
        $request['alertData']['updated_mac_id'] = CommonFunctions::getMacAddress();
        unset($request['alertData']['event_name']);
        unset($request['alertData']['module_names']);
        unset($request['alertData']['id']);
        $request['alertData']['email_cc_employees'] = TemplatesSetting::getIds($request['alertData']['email_cc_employees']);
        $request['alertData']['sms_cc_employees'] = TemplatesSetting::getIds($request['alertData']['sms_cc_employees']);
        $request['alertData']['email_bcc_employees'] = TemplatesSetting::getIds($request['alertData']['email_bcc_employees']);
        $originalValues = TemplatesSetting::where('id', $request['id'])->get();
        $AlertUpdate = TemplatesSetting::where('id', $request['id'])->update($request['alertData']);
        $last = TemplatesSettingsLog::latest('id')->first();
        $getResult = array_diff_assoc($originalValues[0]['attributes'], $request['alertData']);
        $implodeArr = implode(",", array_keys($getResult));
        $result = TemplatesSettingsLog::where('id', $last->id)->update(['column_names' => $implodeArr]);
        $data = ['success' => true, 'message' => 'Alerts Updated Succesfully'];
        return json_encode($data);
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

    public function manageAlerts() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageAlerts = [];

        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
            $manageAlerts = DB::table('templates_settings as ts')
                    ->leftjoin('templates_events as te', 'ts.templates_event_id', '=', 'te.id')
                    ->select('ts.*', 'te.event_name', 'te.module_names')
                    ->where('ts.id', '=', $request['id'])
                    ->get();
        } else if ($request['id'] === "") { // for index
            $manageAlerts = DB::table('templates_settings as ts')
                    ->leftjoin('templates_events as te', 'ts.templates_event_id', '=', 'te.id')
                    ->select('ts.*', 'te.event_name', 'te.module_names')
                    ->where('ts.client_id', '=', 1)
                    ->get();
            /* ->leftjoin(DB::raw('(SELECT login_date_time,employee_id FROM employees_login_logs ORDER BY id DESC limit 1) AS employees_login_logs'), 'employees.id', '=', 'employees_login_logs.employee_id') */
        }
        if ($manageAlerts) {
            $result = ['success' => true, "records" => ["data" => $manageAlerts, "total" => count($manageAlerts), 'per_page' => count($manageAlerts), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageAlerts)]];
            echo json_encode($result);
        }
    }

    public function changeSmsStatus() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (!empty($request['id'])) {
            $val = $request['val'];
            TemplatesSetting::where('id', $request['id'])->update(['sms_status' => $val]);

            $result = ['success' => true, "successMsg" => "SMS Setting has been changed."];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'errorMsg' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
        }
    }

    public function changeEmailStatus() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (!empty($request['id'])) {
            $val = $request['val'];
            TemplatesSetting::where('id', $request['id'])->update(['email_status' => $val]);

            $result = ['success' => true, "successMsg" => "Email Setting has been changed."];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'errorMsg' => 'Something went wrong. Please check internet connection or try again'];
            echo json_encode($result);
        }
    }

    public function getTemplatesEvents() {
        $templatesEvents = DB::table('templates_events')->get();
        if (!empty($templatesEvents)) {
            $result = ['success' => true, 'records' => $templatesEvents];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getEmailConfig() {
        $configEmail = DB::table('email_configuration')->get();
        if (!empty($configEmail)) {
            $result = ['success' => true, 'records' => $configEmail];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getEmployees() {
        $employees = Employee::select('id', 'email')->get();
        if (!empty($employees)) {
            $result = ['success' => true, 'records' => $employees];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getEmployeesToEdit() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $empId = $request['data']['empId'];
        $arr = explode(",", $empId);
        $getemps = Employee::whereIn('id', $arr)->select('id', 'email')->get();
        if (!empty($getemps)) {
            $result = ['success' => true, 'records' => $getemps];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
            return json_encode($result);
        }
    }

    public function changeTemplateStatus() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $templateSettingData = TemplatesSetting::select('client_id')->where('id', '=', $request['id'])->get();
        $client_id = $templateSettingData[0]->client_id;
        $templatecustomData = TemplatesCustom::select('*')->where('client_id', '=', $client_id)->get();
        $val = $request['val'];
        if (count($templatecustomData)) {
            $templateSettingData = TemplatesSetting::where('id', '=', $request['id'])->update(array('template_category' => $val));
            $result = ['success' => true, "successMsg" => "Alerts category has been changed."];
        } else {
            $result = ['success' => false, 'errorMsg' => 'Templete is not present.PLease add template and then change the settings'];
        }
        echo json_encode($result);
    }

}
