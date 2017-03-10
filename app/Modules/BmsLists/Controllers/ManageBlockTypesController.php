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
use App\Models\LstBlockTypes;

class ManageBlockTypesController extends Controller {

    public function index() {
        return view("BmsLists::blocktypes");
    }

    public function manageBlockTypes() {
       
$getBlockname = LstBlockTypes::join('project_types', 'project_types.project_type_id', '=', 'lst_block_types.project_type_id')
            ->select('lst_block_types.id', 'lst_block_types.block_name', 'project_types.project_type_id as project_id','project_types.project_type_name as project_name')
            ->get();
        if (!empty($getBlockname)) {
            $result = ['success' => true, 'records' => $getBlockname];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function createBlockTypes() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $cnt = LstBlockTypes::where(['block_name' => $request['block_name']])->get()->count();
        if ($cnt > 0) { 
            $result = ['success' => false, 'errormsg' => 'Block stages already exists'];
            return json_encode($result);
        } else {
            $getResult = LstBlockTypes::create($request);
            $result = ['success' => true, 'result' => $getResult];
            return json_encode($result);
        }
    }

    public function updateBlockTypes() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = LstBlockTypes::where(['block_name' => $request['block_name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Block name already exists'];
            return json_encode($result);
        } else {
            $result = LstBlockTypes::where('block_id', $request['block_id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
