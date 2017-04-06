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

class ProjectPaymentStagesController extends Controller {

    public function index() {
        return view("ProjectPaymentStages::index");
    }

    public function manageProjectPaymentStages() {
        $getDiscountname = LstDlProjectStages::all();

        if (!empty($getDiscountname)) {
            $result = ['success' => true, 'records' => $getDiscountname];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
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
