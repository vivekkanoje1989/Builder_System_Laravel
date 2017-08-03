<?php

namespace App\Modules\ManageLocation\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\ManageLocation\Models\MlstLocationTypes;
use DB;
use App\Classes\CommonFunctions;
use Auth;
use App\Models\LstEnquiryLocation;

class ManageLocationController extends Controller {

    public function index() {
        return view("ManageLocation::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function manageLocation() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
            if ($request['filterFlag'] == 1) {
                ManageStatesController::$procname = "proc_manage_states";
                return $this->filteredData();
                exit;
            }
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
        }

        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        $getLocations = LstEnquiryLocation::orderBy('id', 'DESC')
                ->take($request['itemPerPage'])->offset($startFrom)
                ->get();
        

        $getLocation = LstEnquiryLocation::all();
        if (!empty($getLocation)) {
            $result = ['success' => true, 'records' => $getLocations, 'totalCount' => count($getLocation)];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    
     public function filteredData() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $filterData = $request['filterData'];
        $ids = [];

        if (empty($request['employee_id'])) { // For Web
            $loggedInUserId = Auth::guard('admin')->user()->id;

            $filterData["location"] = !empty($filterData["location"]) ? $filterData["location"] : "";
        } else { // For App
            $request["getProcName"] = ManageCountryController::$procname;
            $loggedInUserId = $request['employee_id'];

            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
                $loggedInUserId = implode(',', array_map(function($el) {
                            return $el['id'];
                        }, $filterData['empId']));
            }
            $filterData["location"] = !empty($filterData["location"]) ? $filterData["location"] : "";
            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        }
        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
            $loggedInUserId = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $filterData['empId']));
        }
//        $getCountries = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["name"] . '","' . $request['pageNumber'] . '","' . $request['itemPerPage'] . '")');
        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        if ($filterData["location"] != "") {

            $getLocations = LstEnquiryLocation::orderBy('id', 'DESC')
                    ->where('location', $filterData["location"])
                    ->take($request['itemPerPage'])->offset($startFrom)
                    ->get();
              $enqCnt = count($getLocations);
        } else {
            $getLocation = LstEnquiryLocation::all();
             $enqCnt = count($getLocation);
            $getLocations = LstEnquiryLocation::take($request['itemPerPage'])->offset($startFrom)->get();
        }

        $i = 0;
        if (!empty($getLocations)) {
            foreach ($getLocations as $getInboundLog) {
                $getLocations[$i]->location = $getInboundLog->location;
                $i++;
            }
        }

        if (!empty($getLocations)) {
            $result = ['success' => true, 'records' => $getLocations, 'totalCount' => $enqCnt];
        } else {
            $result = ['success' => false, 'records' => $getLocations, 'totalCount' => $enqCnt];
        }
        return json_encode($result);
    }
    
    
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);


        $cnt = LstEnquiryLocation::where(['location' => $request['location_type']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'State already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['locationData'] = array_merge($request, $create);
            $result = LstEnquiryLocation::create($input['locationData']);
            $last3 = LstEnquiryLocation::latest('id')->first();
            $input['locationData']['main_record_id'] = $last3->id;

            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = LstEnquiryLocation::where(['location' => $request['location_type']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Location already exists'];
            return json_encode($result);
        } else {

            $result = LstEnquiryLocation::where('id', $request['id'])->update($request);
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
