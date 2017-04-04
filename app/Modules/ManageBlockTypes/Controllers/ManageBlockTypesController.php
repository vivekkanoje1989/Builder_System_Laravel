<?php

namespace App\Modules\ManageBlockTypes\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageBlockTypes\Models\MlstBlockTypes;
use App\Modules\ManageProjectTypes\Models\MlstProjectTypes;
use DB;
use App\Classes\CommonFunctions;
use Auth;
class ManageBlockTypesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ManageBlockTypes::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manageBlockTypes() {

        $getBlockname = MlstBlockTypes::join('new_builder_master.mlst_project_types', 'mlst_project_types.id', '=', 'mlst_block_types.project_type_id')
                ->select('mlst_block_types.id', 'mlst_block_types.block_name', 'mlst_project_types.id as project_id', 'mlst_project_types.project_type as project_name')
                ->get();
        if (!empty($getBlockname)) {
            $result = ['success' => true, 'records' => $getBlockname];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function manageProjectTypes()
    {
      $getTypes = MlstProjectTypes::all();

        if(!empty($getTypes))
        {
            $result = ['success' => true, 'records' => $getTypes];
            return json_encode($result);
        }
        else
        {
            $result = ['success' => false,'message' => 'Something went wrong'];
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
       
        $cnt = MlstBlockTypes::where(['block_name' => $request['block_name']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'Block name already exists'];
            return json_encode($result);
        } else {
              $loggedInUserId = Auth::guard('admin')->user()->id;
              $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
              $input['BlockTypesData'] = array_merge($request,$create);
              $result = MlstBlockTypes::create($input['BlockTypesData']);
              $last3 = MlstBlockTypes::latest('id')->first();
              $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id];
           return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $getCount = MlstBlockTypes::where(['block_name' => $request['block_name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Block name already exists'];
            return json_encode($result);
        } else {
             
            $result = MlstBlockTypes::where('id', $request['id'])->update($request);
            
            $result = ['success' => true, 'result' => $result];
         return json_encode($result);
        }
    }
}
