<?php

namespace App\Modules\BmsLists\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\BlockStages;

class BlockStagesController extends Controller {

    public function index() {
        return view("BmsLists::blockstages");
    }

    public function manageBlockStages() {
        $getBlockstage = BlockStages::all();

        if (!empty($getBlockstage)) {
            $result = ['success' => true, 'records' => $getBlockstage];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function createBlockStages() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $cnt = BlockStages::where(['block_stages' => $request['block_stages']])->get()->count();
        if ($cnt > 0) { 
            $result = ['success' => false, 'errormsg' => 'Block stages already exists'];
            return json_encode($result);
        } else {
            $getResult = LstBlockStages::create($request);
            $result = ['success' => true, 'result' => $getResult];
            return json_encode($result);
        }
    }

    public function updateBlockStage() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = BlockStages::where(['block_stages' => $request['block_stages']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Block stages already exists'];
            return json_encode($result);
        } else {
            $result = LstBlockStages::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
