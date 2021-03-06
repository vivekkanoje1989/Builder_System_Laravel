<?php

namespace App\Modules\EnquiryLocations\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\ManageCity\Models\MlstCities;
use Illuminate\Http\Request;
use App\Modules\ManageCountry\Models\MlstCountries;
use App\Modules\ManageStates\Models\MlstStates;
use DB;
use App\Classes\CommonFunctions;
use Auth;
use Excel;
use App\Modules\EnquiryLocations\Models\lstEnquiryLocations;

class EnquiryLocationsController extends Controller {

    public function index() {
        return view("EnquiryLocations::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function enquiryLocation() {
        $getLocations = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
                ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
                ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
                ->select('lst_enquiry_locations.location', 'lst_enquiry_locations.id', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.id as city_id','mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
                ->where('lst_enquiry_locations.deleted_status', '!=', 1)
                ->get();
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (in_array('01402', $array)) {
            $deleteBtn = 1;
        } else {
            $deleteBtn = '';
        }
        if (!empty($getLocations)) {
            $result = ['success' => true, 'records' => $getLocations, 'exportData' => $export,'delete'=>$deleteBtn, 'totalCount' => count($getLocations)];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
    
    
    
     public function deleteEnquiryLocation() {
         $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['enquiryLocationData'] = array_merge($request, $create);
        $enqLocation= lstEnquiryLocations::where('id', $request['id'])->update($input['enquiryLocationData']);
        $result = ['success' => true, 'result' => $enqLocation];
        return json_encode($result);
        
    }

    public function enquiryLocationExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getLocations = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
                    ->select('lst_enquiry_locations.location', 'lst_enquiry_locations.id', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
                    ->get();
            $getCount = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
                    ->select('lst_enquiry_locations.location', 'lst_enquiry_locations.id', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
                    ->get()
                    ->count();
            $getLocations = json_decode(json_encode($getLocations), true);

            $manageLocations = array();
            $j = 1;
            for ($i = 0; $i < count($getLocations); $i++) {
                $getLocationsData['Sr. No.'] = $j++;
                $getLocationsData['City'] = $getLocations[$i]['city_name'];
                $getLocationsData['Location'] = $getLocations[$i]['location'];
                $manageLocations[] = $getLocationsData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Enquiry Location Details', function($excel) use($manageLocations) {
                    $excel->sheet('sheet1', function($sheet) use($manageLocations) {
                        $sheet->fromArray($manageLocations);
                    });
                })->download('csv');
            }
        }
    }

//    public function filteredData() {
//        $postdata = file_get_contents("php://input");
//        $request = json_decode($postdata, true);
//        $filterData = $request['filterData'];
//
//        if (empty($request['employee_id'])) { // For Web
//            $loggedInUserId = Auth::guard('admin')->user()->id;
//
//            $filterData["location"] = !empty($filterData["location"]) ? $filterData["location"] : "";
//            $filterData["city_name"] = !empty($filterData["city_name"]) ? $filterData["city_name"] : "";
//        } else { // For App
//            $request["getProcName"] = ManageStatesController::$procname;
//            $loggedInUserId = $request['employee_id'];
//
//            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//                $loggedInUserId = implode(',', array_map(function($el) {
//                            return $el['id'];
//                        }, $filterData['empId']));
//            }
//            $filterData["location"] = !empty($filterData["location"]) ? $filterData["location"] : "";
//            $filterData["city_name"] = !empty($filterData["city_name"]) ? $filterData["city_name"] : "";
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
//        if ($filterData["location"] != "") {
//            $getLocations = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
//                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
//                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
//                    ->select('lst_enquiry_locations.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
//                    ->where('lst_enquiry_locations.location', $filterData["location"])
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//
//            $getLocation = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
//                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
//                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
//                    ->select('lst_enquiry_locations.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
//                    ->where('lst_enquiry_locations.location', $filterData["location"])
//                    ->get();
//            $enqCnt = count($getLocation);
//        } else if ($filterData["city_name"] != "") {
//            $getLocations = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
//                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
//                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
//                    ->select('lst_enquiry_locations.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
//                    ->where('mlst_cities.name', $filterData["city_name"])
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//
//            $getLocation = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
//                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
//                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
//                    ->select('lst_enquiry_locations.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
//                    ->where('mlst_cities.name', $filterData["city_name"])
//                    ->get();
//            $enqCnt = count($getLocation);
//        } else if ($filterData["location"] != "" || $filterData["city_name"] != "") {
//            $getLocations = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
//                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
//                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
//                    ->select('lst_enquiry_locations.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
//                    ->where('mlst_cities.name', $filterData["city_name"])
//                    ->where('lst_enquiry_locations.location', $filterData["location"])
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//
//            $getLocation = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
//                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
//                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
//                    ->select('lst_enquiry_locations.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
//                    ->where('mlst_cities.name', $filterData["city_name"])
//                    ->where('lst_enquiry_locations.location', $filterData["location"])
//                    ->get();
//            $enqCnt = count($getLocation);
//        } else {
//            $getLocation = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
//                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
//                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
//                    ->select('lst_enquiry_locations.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
//                    ->get();
//            $getLocations = lstEnquiryLocations::join('laravel_developement_master_edynamics.mlst_cities as mlst_cities', 'mlst_cities.id', '=', 'lst_enquiry_locations.city_id')
//                    ->join('laravel_developement_master_edynamics.mlst_states as mlst_states', 'mlst_states.id', '=', 'lst_enquiry_locations.state_id')
//                    ->join('laravel_developement_master_edynamics.mlst_countries as mlst_countries', 'mlst_countries.id', '=', 'lst_enquiry_locations.country_id')
//                    ->select('lst_enquiry_locations.*', 'mlst_states.country_id', 'mlst_states.id as state_id', 'mlst_cities.name as city_name', 'mlst_states.name as state_name', 'mlst_countries.name as country_name')
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->get();
//            $enqCnt = count($getLocation);
//        }
//
//        $i = 0;
//        if (!empty($getLocations)) {
//            foreach ($getLocations as $getInboundLog) {
//                $getLocations[$i]->location = $getInboundLog->location;
//                $getLocations[$i]->city_name = $getInboundLog->city_name;
//                $i++;
//            }
//        }
//        if (!empty($getLocations)) {
//            $result = ['success' => true, 'records' => $getLocations, 'totalCount' => $enqCnt];
//        } else {
//            $result = ['success' => false, 'records' => $getLocations, 'totalCount' => $enqCnt];
//        }
//        return json_encode($result);
//    }

    public function manageStates() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getStates = MlstStates::where('country_id', $request['country_id'])
                ->select('id', 'name')
                ->get();
        if (!empty($getStates)) {
            $result = ['success' => true, 'records' => $getStates];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function manageCity() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCity = MlstCities::where('state_id', $request['state_id'])
                ->select('id', 'name')
                ->get();
        if (!empty($getCity)) {
            $result = ['success' => true, 'records' => $getCity];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

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

        $cnt = lstEnquiryLocations::where(['location' => $request['location']])
                        ->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Location already exists'];
            return json_encode($result);
        } else {

            $getCity = MlstCities::where('id', $request['city_id'])
                    ->select('name')
                    ->first();

            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['cityData'] = array_merge($request, $create);
            $result = lstEnquiryLocations::create($input['cityData']);
            $last3 = lstEnquiryLocations::latest('id')->first();
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id, 'city' => $getCity['name']];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = lstEnquiryLocations::where(['location' => $request['location']])
                        ->where('id', '!=', $id)
                        ->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Location already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['locationData'] = array_merge($request, $update);
            $result = lstEnquiryLocations::where('id', $id)->update($input['locationData']);
            $getCity = MlstCities::where('id', $request['city_id'])
                    ->select('name')
                    ->first();
            $result = ['success' => true, 'result' => $result, 'city' => $getCity['name']];
            return json_encode($result);
        }
    }

}
