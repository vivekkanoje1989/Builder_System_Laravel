<?php

namespace App\Modules\ManageBlockTypes\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageBlockTypes\Models\LstBlockTypes;
use App\Modules\ManageProjectTypes\Models\ProjectTypes;
use DB;
use App\Classes\CommonFunctions;
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

        $getBlockname = LstBlockTypes::join('project_types', 'project_types.project_type_id', '=', 'lst_block_types.project_type_id')
                ->select('lst_block_types.id', 'lst_block_types.block_name', 'project_types.project_type_id as project_id', 'project_types.project_type_name as project_name')
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
      $getTypes = ProjectTypes::all();

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
       
        $cnt = LstBlockTypes::where(['block_name' => $request['block_name']])->get()->count();
        if ($cnt > 0) {  
            $result = ['success' => false, 'errormsg' => 'Block name already exists'];
            return json_encode($result);
        } else {
            
              $create = CommonFunctions::insertMainTableRecords();
              $input['BlockTypesData'] = array_merge($request,$create);
              $result = LstBlockTypes::create($input['BlockTypesData']);
              $last3 = LstBlockTypes::latest('id')->first();
              $result = ['success' => true, 'result' => $result,'lastinsertid'=>$last3->id];
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
       
        $getCount = LstBlockTypes::where(['block_name' => $request['block_name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Block name already exists'];
            return json_encode($result);
        } else {
             
            $update = CommonFunctions::insertLogTableRecords();
            $input['BlockTypesData'] = array_merge($request,$update);
            $originalValues = LstBlockTypes::where('id', $request['id'])->get();
            $result = LstBlockTypes::where('id', $request['id'])->update($input['BlockTypesData']);
            
            $last = DB::table('lst_block_types_logs')->latest('id')->first();
            $getResult = array_diff_assoc($originalValues[0]['attributes'], $request);
            $implodeArr =  implode(",",array_keys($getResult));
            $result =  DB::table('lst_block_types_logs')->where('id',$last->id)->update(['column_names'=>$implodeArr]);
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
