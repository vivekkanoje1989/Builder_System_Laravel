<?php

namespace App\Modules\ManageCountry\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageCountry\Models\MlstCountries;
use DB;
use App\Classes\CommonFunctions;
use Auth;

class ManageCountryController extends Controller {

    public function index() {

        return view("ManageCountry::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function manageCountry() {
        $getCountry = MlstCountries::all();

        $countryDetails = array();
        for ($i = 0; $i < count($getCountry); $i++) {
            $countryData['id'] = $getCountry[$i]['id'];
            $countryData['name'] = $getCountry[$i]['name'];
            $countryData['sortname'] = $getCountry[$i]['sortname'];
            $countryData['phonecode'] = $getCountry[$i]['phonecode'];

            $countryDetails[] = $countryData;
        }
        if (!empty($countryDetails)) {
            $result = ['success' => true, 'records' => $countryDetails, 'totalCount' => count($getCountry)];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'records' => $countryDetails, 'totalCount' => count($getCountry), 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

//    public function filteredData() {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
//        $filterData = $request['filterData'];
//        $ids = [];
//
//        if (empty($request['employee_id'])) { // For Web
//            $loggedInUserId = Auth::guard('admin')->user()->id;
//
//            $filterData["name"] = !empty($filterData["name"]) ? $filterData["name"] : "";
//        } else { // For App
//            $request["getProcName"] = ManageCountryController::$procname;
//            $loggedInUserId = $request['employee_id'];
//
//            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//                $loggedInUserId = implode(',', array_map(function($el) {
//                            return $el['id'];
//                        }, $filterData['empId']));
//            }
//            $filterData["name"] = !empty($filterData["name"]) ? $filterData["name"] : "";
//            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
//        }
//        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//            $loggedInUserId = implode(',', array_map(function($el) {
//                        return $el['id'];
//                    }, $filterData['empId']));
//        }
////        $getCountries = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["name"] . '","' . $request['pageNumber'] . '","' . $request['itemPerPage'] . '")');
//        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
//        if ($filterData["name"] != "") {
//
//            $getCountries = MlstCountries::orderBy('id', 'DESC')
//                    ->where('name', $filterData["name"])
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//            $enqCnt = count($getCountries);
//        } else {
//            $getCountry = MlstCountries::all();
//            $enqCnt = count($getCountry);
//            $getCountries = MlstCountries::take($request['itemPerPage'])->offset($startFrom)->get();
//        }
//
//        $i = 0;
//        if (!empty($getCountries)) {
//            foreach ($getCountries as $getInboundLog) {
//                $getCountries[$i]->name = $getInboundLog->name;
//                $i++;
//            }
//        }
//
//        if (!empty($getCountries)) {
//            $result = ['success' => true, 'records' => $getCountries, 'totalCount' => $enqCnt];
//        } else {
//            $result = ['success' => false, 'records' => $getCountries, 'totalCount' => $enqCnt];
//        }
//        return json_encode($result);
//    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstCountries::where(['name' => $request['name']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['countryData'] = array_merge($request, $create);
            $result = MlstCountries::create($input['countryData']);
            $last3 = MlstCountries::latest('id')->first();
            $input['countryData']['main_record_id'] = $last3->id;
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstCountries::where(['name' => $request['name']])
                        ->where('id', '!=', $id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Country already exists'];
            return json_encode($result);
        } else {

            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['countryData'] = array_merge($request, $create);
            $result = MlstCountries::where('id', $request['id'])->update($input['countryData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
