<?php

namespace App\Modules\ProjectPaymentStages\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ProjectPaymentStages\Models\ProjectStages;
use App\Modules\ManageProjectTypes\Models\LstProjectTypes;
use DB;
use App\Classes\CommonFunctions;

class ProjectPaymentStagesController extends Controller {

    public function index() {
        return view("ProjectPaymentStages::index");
    }

    public function manageProjectPaymentStages() {
        $getDiscountname = ProjectStages::all();
       
        if (!empty($getDiscountname)) {
            $result = ['success' => true, 'records' => $getDiscountname];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageProjectTypes() {
        $getTypes = LstProjectTypes::all();

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

        $cnt = ProjectStages::where(['project_stages' => $request['project_stages']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Project payment stages already exists'];
            return json_encode($result);
        } else {

            $create = CommonFunctions::insertMainTableRecords();
            $input['projectStagesData'] = array_merge($request, $create);
            $input['projectStagesData']['project_type_id'];

            $result = ProjectStages::create($input['projectStagesData']);

            $last3 = ProjectStages::latest('id')->first();
            $input['projectStagesData']['id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = ProjectStages::where(['project_stages' => $request['project_stages']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Project payment stage already exists'];
            return json_encode($result);
        } else {
            $result = ProjectStages::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
