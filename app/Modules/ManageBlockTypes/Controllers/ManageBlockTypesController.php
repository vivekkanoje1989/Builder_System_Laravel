<?php

namespace App\Modules\ManageBlockTypes\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageBlockTypes\Models\MlstBmsbBlockTypes;
use App\Modules\ManageProjectTypes\Models\MlstBmsbProjectTypes;
use DB;
use App\Classes\CommonFunctions;
use Auth;

class ManageBlockTypesController extends Controller {

    public function index() {
        return view("ManageBlockTypes::index");
    }

    public function manageBlockTypes() {

        $getBlockname = MlstBmsbBlockTypes::join('laravel_developement_master_edynamics.mlst_bmsb_project_types', 'mlst_bmsb_project_types.id', '=', 'mlst_bmsb_block_types.project_type_id')
                ->select('mlst_bmsb_block_types.id', 'mlst_bmsb_block_types.block_name', 'mlst_bmsb_project_types.id as project_id', 'mlst_bmsb_project_types.project_type as project_name')
                ->get();
        if (!empty($getBlockname)) {
            $result = ['success' => true, 'records' => $getBlockname];
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

        $cnt = MlstBmsbBlockTypes::where(['block_name' => $request['block_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Block name already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['BlockTypesData'] = array_merge($request, $create);
            $result = MlstBmsbBlockTypes::create($input['BlockTypesData']);
            $last3 = MlstBmsbBlockTypes::latest('id')->first();
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstBmsbBlockTypes::where(['block_name' => $request['block_name']])
                ->where('id', '!=', $id)
                ->get()
                ->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Block name already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['blockTypesData'] = array_merge($request, $update);
            $result = MlstBmsbBlockTypes::where('id', $request['id'])->update($input['blockTypesData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
