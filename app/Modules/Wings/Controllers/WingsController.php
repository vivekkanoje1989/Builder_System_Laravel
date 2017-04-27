<?php

namespace App\Modules\Wings\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Wings\Models\ProjectWing;
use App\Modules\Projects\Models\Project;
use Validator;
use App\Classes\CommonFunctions;
use Auth;
use DB;

class WingsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("Wings::index")->with('id', -1);
    }

    public function getWingList() {
        // $list = Project::with('wings')->find(1)->toArray();
        // echo json_encode($list);exit;
        //$list = ProjectWing::where('id',1)->select('*',DB::raw('DATE_FORMAT(created_at,"%d/%m/%Y") as created_at'))->get();
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if ($input['id'] === -1) {
            $list = ProjectWing::select("*")->with('projectName','stationaryName','companyName')->get();
            //print_r($list);exit;
            
            
        } else {
            $list = ProjectWing::where('id', $input['id'])->get();
        }
        if (!empty($list)) {
            $result = ['success' => true, 'records' => $list];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'No Wings Records'];
            return json_encode($result);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view("Wings::create")->with('id', 0);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $validationMessages = ProjectWing::validationMessages();
        $validationRules = ProjectWing::validationRules();
        $validator = Validator::make($input['wingData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result, true);
            exit;
        }
        if (!empty($input['wingData']['loggedInUserId'])) {
            $loggedInUserId = $input['wingData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['wingData'] = array_merge($input['wingData'], $create);
        $createWings = ProjectWing::create($input['wingData']);
        if ($createWings) {
            $result = ['success' => true, 'message' => 'Wing Created Successfully'];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Wing Not Created'];
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
        return view("Wings::create")->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $validationMessages = ProjectWing::validationMessages();
        $validationRules = ProjectWing::validationRules();
        $validator = Validator::make($input['wingData'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result, true);
            exit;
        }
        if (!empty($input['wingData']['loggedInUserId'])) {
            $loggedInUserId = $input['wingData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['wingData'] = array_merge($input['wingData'], $update);
        $updateWings = ProjectWing::where('id',$id)->update($input['wingData']);
        $result = ['success' => true, 'message' => 'Wing Updated Successfully'];
        return json_encode($result);
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
