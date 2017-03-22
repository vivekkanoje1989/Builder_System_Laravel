<?php

namespace App\Modules\ManageProjectTypes\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageProjectTypes\Models\LstProjectTypes;
use DB;
use App\Classes\CommonFunctions;

class ManageProjectTypesController extends Controller {

    public function index() {
        return view("ManageProjectTypes::index");
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

        $cnt = LstProjectTypes::where(['project_type' => $request['project_type']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Project type already exists'];
            return json_encode($result);
        } else {

            $create = CommonFunctions::insertMainTableRecords();
            $input['projectTypeData'] = array_merge($request, $create);
            $result = LstProjectTypes::create($input['projectTypeData']);
            $last3 = LstProjectTypes::latest('id')->first();
            $input['projectTypeData']['id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }
    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = LstProjectTypes::where(['project_type' => $request['project_type'], 'id' => $request['id']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Project type already exists'];
          return json_encode($result);
        } else {
            $result = LstProjectTypes::where('id', $request['id'])->update( $request);
            $result = ['success' => true, 'result' => $result];
          return json_encode($result);
        }
    }
}
