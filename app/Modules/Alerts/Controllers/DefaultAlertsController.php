<?php

namespace App\Modules\Alerts\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\TemplatesDefault;
use App\Models\TemplatesDefaultsLog;
use App\Models\TemplatesCustom;
use App\Models\backend\Employee;
use App\Modules\Projects\Models\Project;

class DefaultAlertsController extends Controller {

    public function index() {
        return view("Alerts::defaultalertsindex");
    }

    /*
      public function store()
      {
      $postdata = file_get_contents("php://input");
      $request = json_decode($postdata, true);
      $create = CommonFunctions::insertMainTableRecords();
      $request['defaultAlertData'] = array_merge($request['defaultAlertData'],$create);
      //echo "<pre>";print_r($request['defaultAlertData']);die;
      $result = TemplatesDefault::create($request['defaultAlertData']);
      if($result){
      $result = ['success' => true, 'message' => 'Dafault alerts created successfully.'];
      }
      else{
      $result = ['success' => false, 'message' => 'Something went wrong. Please check internet connection or try again'];
      }
      echo json_encode($result);
      } */

    public function edit($id) {
        return view("Alerts::defaultalertscreate")->with(array('alertId' => $id));
    }

    /*
      public function create()
      {
      return view("Alerts::defaultalertscreate");
      }
      public function update($id)
      {
      $postdata = file_get_contents("php://input");
      $request = json_decode($postdata, true);
      $result = ['success' => true, 'records' => $request];
      echo json_encode($result);
      }
      public function updateDefaultAlerts() {
      $postdata = file_get_contents('php://input');
      $request = json_decode($postdata, true);
      $request['defaultAlertData']['updated_date'] = date('Y-m-d');
      $request['defaultAlertData']['updated_by'] = Auth::guard('admin')->user()->id;
      $request['defaultAlertData']['updated_IP'] = $_SERVER['REMOTE_ADDR'];
      $request['defaultAlertData']['updated_browser'] = $_SERVER['HTTP_USER_AGENT'];
      $request['defaultAlertData']['updated_mac_id'] = CommonFunctions::getMacAddress();
      unset($request['defaultAlertData']['event_name']);
      unset($request['defaultAlertData']['module_names']);
      $originalValues = TemplatesDefault::where('id', $request['id'])->get();
      $CustomAlertUpdate=TemplatesDefault::where('id',$request['id'])->update($request['defaultAlertData']);
      $last = TemplatesDefaultsLog::latest('id')->first();
      $getResult = array_diff_assoc($originalValues[0]['attributes'],$request['defaultAlertData']);
      $implodeArr =  implode(",",array_keys($getResult));
      $result =  DB::table('templates_defaults_logs')->where('id',$last->id)->update(['column_names'=>$implodeArr]);
      $data = ['success' => true, 'successMsg' => 'Default alerts updated succesfully'];
      return json_encode($data);

      }
     * 
     */

//    public function manageDafaultAlerts() {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
//        $manageAlerts = [];
//
//        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
//            $manageAlerts = DB::table('templates_defaults as td')
//                    ->leftjoin('templates_events as te', 'td.templates_event_id', '=', 'te.id')
//                    ->select('td.*', 'te.event_name', 'te.module_names')
//                    ->where('td.id', '=', $request['id'])
//                    ->get();
//        } else if ($request['id'] === "") { // for index
//            $manageAlerts = DB::table('templates_defaults as td')
//                    ->leftjoin('templates_events as te', 'td.templates_event_id', '=', 'te.id')
//                    ->select('td.*', 'te.event_name', 'te.module_names')
//                    ->get();
//            /* ->leftjoin(DB::raw('(SELECT login_date_time,employee_id FROM employees_login_logs ORDER BY id DESC limit 1) AS employees_login_logs'), 'employees.id', '=', 'employees_login_logs.employee_id') */
//        }
//        if ($manageAlerts) {
//            $result = ['success' => true, "records" => ["data" => $manageAlerts, "total" => count($manageAlerts), 'per_page' => count($manageAlerts), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageAlerts)]];
//            echo json_encode($result);
//        }
//    }

    public function manageDafaultAlerts() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $manageAlerts = [];
        $master = config('global.masterdatabase');
        if (!empty($request['id']) && $request['id'] !== "0") { // for edit
            $manageAlerts = DB::table('laravel_developement_master_edynamics.mlst_bmsb_templates_defaults as td')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_templates_events as te', 'td.templates_event_id', '=', 'te.id')
                    ->select('td.*', 'te.event_name', 'te.module_names')
                    ->where('td.id', '=', $request['id'])
                    ->get();
           
            $client_id = config('global.client_id');
            $client = \App\Models\ClientInfo::where('id', $client_id)->first();
            $project = Project::where('id', $client->project_id)->first();
           
//             $project = \App\Models\MlstBmsbBlockType::where('id', $client->project_id)->first();
//            $model_data = \App\Models\MlstLmsaModel::where('brand_id', $client->brand_id)->orderBy('id', 'DESC')->first();
//            if (empty($model_data)) {
//                $model_name = "";
//            } else {
//                $model_name = $model_data->model_name;
//                $displayImage = config('global.s3Path') . '/model_images/' . $model_data->display_image;
//            }
//print_r($client);
//            $brandlogo = config('global.s3Path') . '/brand_logo/' . $brand->brand_logo;
            $logo = config('global.s3Path') . 'client/' . $client_id . '/' . $client->company_logo;
           
//            $car_image = "https://s3-ap-south-1.amazonaws.com/lms-auto-common/images/car.png";
            $loc_image = "https://s3-ap-south-1.amazonaws.com/lms-auto-common/images/loc2.png";
            $search = array('[#companyMarketingName#]', '[#showroomGoogleMap#]', '[#companyAddress#]', '[#companyLogo#]', '[#brandLogo#]', '[#brandColor#]', '[#brandName#]', '[#locimg#]', '[#vehicleimg#]', '[#companyGoogleMap#]');
     
//               $replace = array(ucwords($client->marketing_name), '', $client->address, $logo, $brandlogo, $displayImage, $brand->brand_color, $brand->brand_name, $loc_image, $car_image, '#');
            $replace = array(ucwords($client->marketing_name), '', $client->address, $logo, $loc_image, '#');
      
            $manageAlerts[0]->email_body = str_replace($search, $replace, $manageAlerts[0]->email_body); //email
            $manageAlerts[0]->sms_body = str_replace($search, $replace, $manageAlerts[0]->sms_body);
        } else if ($request['id'] === "") {

            $manageAlerts = DB::table('laravel_developement_master_edynamics.mlst_bmsb_templates_defaults as td')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_templates_events as te', 'td.templates_event_id', '=', 'te.id')
                    ->select('td.*', 'te.event_name', 'te.module_names')
                    ->get();
        }
        if ($manageAlerts) {
            $result = ['success' => true, "records" => ["data" => $manageAlerts, "total" => count($manageAlerts), 'per_page' => count($manageAlerts), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageAlerts)]];
            echo json_encode($result);
        }
    }

}
