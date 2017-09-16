<?php

namespace App\Modules\ProjectPaymentStages\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ProjectPaymentStages\Models\LstDlProjectStages;
use App\Modules\ManageProjectTypes\Models\MlstBmsbProjectTypes;
use DB;
use App\Classes\CommonFunctions;
use Auth;
use Excel;

class ProjectPaymentStagesController extends Controller {

    public function index() {
        return view("ProjectPaymentStages::index");
    }

    public function manageProjectPaymentStages() {
        $getProjectPayment = LstDlProjectStages::select('stage_name', 'project_type_id', 'fix_stage', 'id')->where('deleted_status', '!=', 1)->get();
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (in_array('01402', $array)) {
            $deleteBtn = 1;
        } else {
            $deleteBtn = '';
        }
        if (!empty($getProjectPayment)) {
            $result = ['success' => true, 'records' => $getProjectPayment, 'exportData' => $export,'delete'=>$deleteBtn];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
    
     public function deleteProjectStages() {
         $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['projectstageData'] = array_merge($request, $create);
        $projectstages = LstDlProjectStages::where('id', $request['id'])->update($input['projectstageData']);
        $result = ['success' => true, 'result' => $projectstages];
        return json_encode($result);
    }

    

    public function projectPaymentStagesExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
           $getProjectPayment = LstDlProjectStages::select('stage_name', 'project_type_id', 'fix_stage', 'id')->get();
            $getCount = LstDlProjectStages::select('stage_name', 'project_type_id', 'fix_stage', 'id')->get()->count();
            $getProjectPayment = json_decode(json_encode($getProjectPayment), true);

            $manageProjectPayment = array();
            $j = 1;
            for ($i = 0; $i < count($getProjectPayment); $i++) {
                $manageProjectPaymentData['Sr No.'] = $j++;
                $manageProjectPaymentData['Project Stages'] = $getProjectPayment[$i]['stage_name'];
                $manageProjectPayment[] = $manageProjectPaymentData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Project Stages Details', function($excel) use($manageProjectPayment) {
                    $excel->sheet('sheet1', function($sheet) use($manageProjectPayment) {
                        $sheet->fromArray($manageProjectPayment);
                    });
                })->download('xls');
            }
        }
    }

    public function manageProjectTypes() {
        $getTypes = MlstBmsbProjectTypes::all();

        if (!empty($getTypes)) {
            $result = ['success' => true, 'records' => $getTypes];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = LstDlProjectStages::where(['stage_name' => $request['stage_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Project payment stages already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['projectStagesData'] = array_merge($request, $create);
            $input['projectStagesData']['project_type_id'];

            $result = LstDlProjectStages::create($input['projectStagesData']);

            $last3 = LstDlProjectStages::latest('id')->first();
            $input['projectStagesData']['id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = LstDlProjectStages::where(['stage_name' => $request['stage_name']])
                        ->where('id', '!=', $id)
                        ->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Project payment stage already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['projectPaymentData'] = array_merge($request, $update);
            $result = LstDlProjectStages::where('id', $request['id'])->update($input['projectPaymentData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
