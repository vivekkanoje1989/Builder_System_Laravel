<?php

namespace App\Modules\ManageStates\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageStates\Models\MlstStates;
use App\Classes\CommonFunctions;
use App\Modules\ManageCountry\Models\MlstCountries;
use DB;
use Auth;

class ManageStatesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ManageStates::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function manageStates() {

        $getState = MlstStates::join('mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
                ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
                ->get();

        if (!empty($getState)) {
            $result = ['success' => true, 'records' => $getState, 'totalCount' => count($getState)];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

//    public function filteredData() {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
//        $filterData = $request['filterData'];
//
//        $ids = [];
//        if (empty($request['employee_id'])) { // For Web
//            $loggedInUserId = Auth::guard('admin')->user()->id;
//
//            $filterData["name"] = !empty($filterData["name"]) ? $filterData["name"] : "";
//            $filterData["country_name"] = !empty($filterData["country_name"]) ? $filterData["country_name"] : "";
//        } else { // For App
//            $request["getProcName"] = ManageStatesController::$procname;
//            $loggedInUserId = $request['employee_id'];
//
//            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//                $loggedInUserId = implode(',', array_map(function($el) {
//                            return $el['id'];
//                        }, $filterData['empId']));
//            }
//            $filterData["name"] = !empty($filterData["name"]) ? $filterData["name"] : "";
//            $filterData["country_name"] = !empty($filterData["country_name"]) ? $filterData["country_name"] : "";
//            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
//        }
////        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
////            $loggedInUserId = implode(',', array_map(function($el) {
////                        return $el['id'];
////                    }, $filterData['empId']));
////        }
////        $getStates = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["name"] . '","' . $filterData["country_name"] . '","' . $request['pageNumber'] . '","' . $request['itemPerPage'] . '")');
//
//        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
//      
//        if ($filterData["country_name"] != "") {
//            $getStates = MlstStates::join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
//                    ->where('mlst_countries.name', $filterData["country_name"])
//                    ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//            // print_r($getStates);exit;
//            $getState = MlstStates::join('mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
//                    ->where('mlst_countries.name', $filterData["country_name"])
//                    ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
//                    ->get();
//
//            $enqCnt = count($getState);
//        } else if ($filterData["name"] != "") {
//            $getStates = MlstStates::join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
//                    ->where('mlst_states.name', $filterData["name"])
//                    ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//            // print_r($getStates);exit;
//            $getState = MlstStates::join('mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
//                    ->where('mlst_states.name', $filterData["name"])
//                    ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
//                    ->get();
//
//            $enqCnt = count($getState);
//        } else if ($filterData["name"] != "" || $filterData["country_name"] != "") {
//            $getStates = MlstStates::join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
//                    ->where('mlst_countries.name', $filterData["country_name"])
//                    ->orWhere('mlst_states.name', $filterData["name"])
//                    ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//            // print_r($getStates);exit;
//            $getState = MlstStates::join('mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
//                    ->where('mlst_countries.name', $filterData["country_name"])
//                    ->orWhere('mlst_states.name', $filterData["name"])
//                    ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
//                    ->get();
//
//            $enqCnt = count($getState);
//        } else {
//            $getState = MlstStates::join('mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
//                    ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
//                    ->get();
//            $enqCnt = count($getState);
//            $getStates = MlstStates::join('mlst_countries', 'mlst_states.country_id', '=', 'mlst_countries.id')
//                    ->select('mlst_states.id', 'mlst_states.name', 'mlst_states.country_id', 'mlst_countries.name as country_name')
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//        }
//
//        $i = 0;
//        if (!empty($getStates)) {
//            foreach ($getStates as $getInboundLog) {
//                $getStates[$i]->name = $getInboundLog->name;
//                $getStates[$i]->country_name = $getInboundLog->country_name;
//                $i++;
//            }
//        }
//
//        if (!empty($getStates)) {
//            $result = ['success' => true, 'records' => $getStates, 'totalCount' => $enqCnt];
//        } else {
//            $result = ['success' => false, 'records' => $getStates, 'totalCount' => $enqCnt];
//        }
//        return json_encode($result);
//    }

    public function manageCountry() {
        $getCountry = MlstCountries::all();

        if (!empty($getCountry)) {
            $result = ['success' => true, 'records' => $getCountry];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstStates::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'State name already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['stateData'] = array_merge($request, $create);
            $result = MlstStates::create($input['stateData']);
            $last3 = MlstStates::latest('id')->first();

            $getCountry = MlstCountries::where('id', '=', $request['country_id'])
                    ->select('name')
                    ->first();
            $input['stateData']['main_record_id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id, 'country_name' => $getCountry->name];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstStates::where(['name' => $request['name'], 'country_id' => $request['country_id']])
                        ->where('id', '!=', $id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {

            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['stateData'] = array_merge($request, $create);

            $getCountry = MlstCountries::where('id', '=', $request['country_id'])
                    ->select('name')
                    ->first();
            $result = MlstStates::where('id', $request['id'])->update($input['stateData']);
            $result = ['success' => true, 'result' => $result, 'country_name' => $getCountry->name];
            return json_encode($result);
        }
    }

}
