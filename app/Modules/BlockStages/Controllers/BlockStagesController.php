<?php

namespace App\Modules\BlockStages\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\BlockStages\Models\LstDlBlockStages;
use App\Modules\ManageProjectTypes\Models\MlstProjectTypes;
use DB;
use App\Classes\CommonFunctions;
use Auth;
class BlockStagesController extends Controller {

    public function index() {
        return view("BlockStages::index");
    }

    public function manageBlockStages() {
        $getBlockstage = LstDlBlockStages::all();
//echo "<pre>";print_r($getBlockstage);exit;
        if (!empty($getBlockstage)) {
            $result = ['success' => true, 'records' => $getBlockstage];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageProjectTypes() {

        $getTypes = MlstProjectTypes::all();
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

        $cnt = LstDlBlockStages::where(['block_stage_name' => $request['block_stage_name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Block stage name already exists'];
            return json_encode($result);
        } else {
            
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['blockStagesData'] = array_merge($request, $create);

            $result = LstDlBlockStages::create($input['blockStagesData']);
            $last3 = LstDlBlockStages::latest('id')->first();
            $input['blockStagesData']['id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = LstDlBlockStages::where(['block_stage_name' => $request['block_stage_name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Block stage name already exists'];
            return json_encode($result);
        } else {

             $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::insertLogTableRecords($loggedInUserId);
            $input['blockStagesData'] = array_merge($request, $update);
            $originalValues = LstDlBlockStages::where('id', $request['id'])->get();
            $result = LstDlBlockStages::where('id', $request['id'])->update($input['blockStagesData']);
            $last = DB::table('lst_dl_block_stages_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr = implode(",", array_keys($getResult));
            $result = DB::table('lst_dl_block_stages_logs')->where('id', $last->id)->update(['column_names' => $implodeArr]);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

  
}
