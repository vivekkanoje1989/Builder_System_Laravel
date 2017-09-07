<?php

namespace App\Modules\Alerts\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Excel;
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

    public function edit($id) {
        return view("Alerts::defaultalertscreate")->with(array('alertId' => $id));
    }

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
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        }else{
              $export = '';
        }
        if ($manageAlerts) {
            $result = ['success' => true, "records" => ["data" => $manageAlerts, 'exportData' => $export, "total" => count($manageAlerts), 'per_page' => count($manageAlerts), "current_page" => 1, "last_page" => 1, "next_page_url" => null, "prev_page_url" => null, "from" => 1, "to" => count($manageAlerts)]];
            echo json_encode($result);
        }
    }

    public function defaultTemplatesExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {

            $loggedInUserId = Auth::guard('admin')->user()->id;
            $getCount = DB::table('laravel_developement_master_edynamics.mlst_bmsb_templates_defaults as td')
                            ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_templates_events as te', 'td.templates_event_id', '=', 'te.id')
                            ->select('td.*', 'te.event_name', 'te.module_names')
                            ->get()->count();
            $manageAlerts = DB::table('laravel_developement_master_edynamics.mlst_bmsb_templates_defaults as td')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_templates_events as te', 'td.templates_event_id', '=', 'te.id')
                    ->select('td.*', 'te.event_name', 'te.module_names')
                    ->get();
            $defaultAlerts = array();
            $j = 1;
            $manageAlerts = json_decode(json_encode($manageAlerts), true);
            for ($i = 0; $i < count($manageAlerts); $i++) {
                $defaultAlert['Sr No'] = $j++;
                $defaultAlert['Template For'] = $manageAlerts[$i]['event_name'];
                $defaultAlert['Email Subject'] = $manageAlerts[$i]['email_subject'];
                $status = $manageAlerts[$i]['template_for'];
                if ($status == 1) {
                    $defaultAlert['Template To'] = 'Customer';
                } else {
                    $defaultAlert['Template To'] = 'Employee';
                }

                $defaultAlerts[] = $defaultAlert;
            }
            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Default Template Data', function($excel) use($defaultAlerts) {
                    $excel->sheet('sheet1', function($sheet) use($defaultAlerts) {
                        $sheet->fromArray($defaultAlerts);
                    });
                })->download('xls');
            }
        }
    }

}
