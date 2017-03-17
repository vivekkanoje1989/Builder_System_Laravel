<?php

namespace App\Modules\ManageProjectTypes\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageProjectTypes\Models\ProjectTypes;
use DB;
use App\Classes\CommonFunctions;

class ManageProjectTypesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ManageProjectTypes::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = ProjectTypes::where(['project_type_name' => $request['project_type_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Project type already exists'];
            return json_encode($result);
        } else {

            $create = CommonFunctions::insertMainTableRecords();
            $input['projectTypeData'] = array_merge($request, $create);
            $result = ProjectTypes::create($input['projectTypeData']);
            $last3 = ProjectTypes::latest('project_type_id')->first();
            $input['projectTypeData']['project_type_id'] = $last3->project_type_id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->project_type_id];
            return json_encode($result);
        }
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
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = ProjectTypes::where(['project_type_name' => $request['project_type_name'], 'project_type_id' => $request['project_type_id']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Project type already exists'];
            return json_encode($result);
        } else {

            $update = CommonFunctions::insertLogTableRecords();
            $input['ProjectTypesData'] = array_merge($request, $update);

            $originalValues = ProjectTypes::where('project_type_id', $request['project_type_id'])->get();
            $result = ProjectTypes::where('project_type_id', $request['project_type_id'])->update($input['ProjectTypesData']);

            $last = DB::table('project_types_logs')->latest('project_type_id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::table('project_types_logs')->where('project_type_id', $last->project_type_id)->update(['column_names' => $implodeArr]);
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
