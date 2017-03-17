<?php

namespace App\Modules\ProjectPaymentStages\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ProjectPaymentStages\Models\ProjectStages;
use App\Modules\ManageProjectTypes\Models\ProjectTypes;
use DB;
use App\Classes\CommonFunctions;

class ProjectPaymentStagesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
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
        $getTypes = ProjectTypes::all();

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
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = ProjectStages::where(['project_stages' => $request['project_stages']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Project payment stage already exists'];
            return json_encode($result);
        } else {

            $update = CommonFunctions::insertLogTableRecords();
            $input['ProjectTypesData'] = array_merge($request, $update);
            $originalValues = ProjectStages::where('id', $request['id'])->get();
            $result = ProjectStages::where('id', $request['id'])->update($input['ProjectTypesData']);

            $last = DB::table('project_stages_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::table('project_stages_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
            $result = ['success' => true, 'result' => $result];

            return json_encode($result);
        }
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
