<?php

namespace App\Modules\BloodGroups\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\BloodGroups\Models\MlstBloodGroups;
use App\Classes\CommonFunctions;
use Auth;
use DB;
use Excel;

class BloodGroupsController extends Controller {

    public function index() {
        return view("BloodGroups::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function manageBloodGroups() {
        $getBloodGroups = MlstBloodGroups::where('deleted_status', '!=', 1)->get();

        $bloodGrps = array();
        for ($i = 0; $i < count($getBloodGroups); $i++) {
            $bloodGrp['id'] = $getBloodGroups[$i]['id'];
            $bloodGrp['blood_group'] = $getBloodGroups[$i]['blood_group'];
            $bloodGrps[] = $bloodGrp;
        }
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (!empty($bloodGrps)) {
            $result = ['success' => true, 'records' => $bloodGrps,'exportData'=>$export, 'totalCount' => count($getBloodGroups)];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }
    
    
     public function deleteBloodgrp() {
         $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['bloodGrpData'] = array_merge($request, $create);
        $bloodGrps = MlstBloodGroups::where('id', $request['id'])->update($input['bloodGrpData']);
        $result = ['success' => true, 'result' => $bloodGrps];
        return json_encode($result);
        
    }

    public function bloodGroupExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $getBloodGroups = MlstBloodGroups::select('blood_group')->get();
            $getCount = MlstBloodGroups::select('blood_group')->get()->count();
            $getBloodGroups = json_decode(json_encode($getBloodGroups), true);
          
            $manageBloodGroups = array();
            $j = 1;
            for ($i = 0; $i < count($getBloodGroups); $i++) {
                 $blogData['Sr No.'] = $j++;
                $blogData['Blood Group'] = $getBloodGroups[$i]['blood_group'];
                $manageBloodGroups[] = $blogData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Blood Group Details', function($excel) use($manageBloodGroups) {
                    $excel->sheet('sheet1', function($sheet) use($manageBloodGroups) {
                        $sheet->fromArray($manageBloodGroups);
                    });
                })->download('xls');
            }
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
//            $filterData["blood_group"] = !empty($filterData["blood_group"]) ? $filterData["blood_group"] : "";
//        } else { // For App
//            $request["getProcName"] = BloodGroupsController::$procname;
//            $loggedInUserId = $request['employee_id'];
//
//            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//                $loggedInUserId = implode(',', array_map(function($el) {
//                            return $el['id'];
//                        }, $filterData['empId']));
//            }
//            $filterData["blood_group"] = !empty($filterData["blood_group"]) ? $filterData["blood_group"] : "";
//            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
//        }
//        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//            $loggedInUserId = implode(',', array_map(function($el) {
//                        return $el['id'];
//                    }, $filterData['empId']));
//        }
//        $getBloodGrps = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["blood_group"] . '","' . $request['pageNumber'] . '","' . $request['itemPerPage'] . '")');
//
//        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
//        $enqCnt = $enqCnt[0]->totalCount;
//        $i = 0;
//        if (!empty($getBloodGrps)) {
//            foreach ($getBloodGrps as $getInboundLog) {
//                $getBloodGrps[$i]->blood_group = $getInboundLog->blood_group;
////                
//                $i++;
//            }
//        }
//
//
//        if (!empty($getBloodGrps)) {
//            $result = ['success' => true, 'records' => $getBloodGrps, 'totalCount' => $enqCnt];
//        } else {
//            $result = ['success' => false, 'records' => $getBloodGrps, 'totalCount' => $enqCnt];
//        }
//        return json_encode($result);
//    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = MlstBloodGroups::where(['blood_group' => $request['blood_group']])->get()->count();
        if ($cnt > 0) {  //exists blood group
            $result = ['success' => false, 'errormsg' => 'Blood group already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['bloodGroupData'] = array_merge($request, $create);
            $bloodgroup = MlstBloodGroups::create($input['bloodGroupData']);
            $last3 = MlstBloodGroups::latest('id')->first();
            $result = ['success' => true, 'result' => $bloodgroup, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $getCount = MlstBloodGroups::where(['blood_group' => $request['blood_group']])->where('id', '!=', $id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Blood group already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['bloodData'] = array_merge($request, $update);
            $result = MlstBloodGroups::where('id', $id)->update($input['bloodData']);
            $result = ['success' => true, 'result' => $result];

            return json_encode($result);
        }
    }

}
