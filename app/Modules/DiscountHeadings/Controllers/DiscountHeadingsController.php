<?php

namespace App\Modules\DiscountHeadings\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\DiscountHeadings\Models\LstDlDiscounts;
use DB;
use App\Classes\CommonFunctions;
use Auth;

class DiscountHeadingsController extends Controller {

    public function index() {
        return view("DiscountHeadings::index")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function manageDiscountHeadings() {
        $getDiscountname = LstDlDiscounts::select('discount_name', 'status', 'id')->get();
     
        if (!empty($getDiscountname)) {
            $result = ['success' => true, 'records' => $getDiscountname, 'totalCount' => count($getDiscountname)];
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
//        $ids = [];
//        if (empty($request['employee_id'])) { // For Web
//            $loggedInUserId = Auth::guard('admin')->user()->id;
//            $filterData["discount_name"] = !empty($filterData["discount_name"]) ? $filterData["discount_name"] : "";
//
//            $filterData["status"] = !empty($filterData["status"]) ? $filterData["status"] : "";
//        } else { // For App
//            $request["getProcName"] = ManageCountryController::$procname;
//            $loggedInUserId = $request['employee_id'];
//
//            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//                $loggedInUserId = implode(',', array_map(function($el) {
//                            return $el['id'];
//                        }, $filterData['empId']));
//            }
//            $filterData["discount_name"] = !empty($filterData["discount_name"]) ? $filterData["discount_name"] : "";
//            $filterData["status"] = !empty($filterData["status"]) ? $filterData["status"] : "";
//            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
//        }
//        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
//            $loggedInUserId = implode(',', array_map(function($el) {
//                        return $el['id'];
//                    }, $filterData['empId']));
//        }
//
////        $getCountries = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["name"] . '","' . $request['pageNumber'] . '","' . $request['itemPerPage'] . '")');
//        if ($filterData["status"] == 'active') {
//            $filterData["status"] = '1';
//        } else if ($filterData["status"] == 'inactive') {
//            $filterData["status"] = '0';
//        }
//
//        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
//
//        if ($filterData["discount_name"] != "") {
//            $getCountries = LstDlDiscounts::where('discount_name', $filterData["discount_name"])
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->orderBy('id', 'DESC')
//                    ->get();
//            $getCountry = LstDlDiscounts::where('discount_name', $filterData["discount_name"])
//                    ->orderBy('id', 'DESC')
//                    ->get();
//            $enqCnt = count($getCountry);
//        } else if ($filterData["status"] != "") {
//            $getCountries = LstDlDiscounts::where('status', $filterData["status"])
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->orderBy('id', 'DESC')
//                    ->get();
//            $getCountry = LstDlDiscounts::where('status', $filterData["status"])
//                    ->orderBy('id', 'DESC')
//                    ->get();
//            $enqCnt = count($getCountry);
//        } else if ($filterData["discount_name"] != "" || $filterData["status"] != '') {
//            $getCountries = LstDlDiscounts::where('discount_name', $filterData["discount_name"])
//                    ->where('status', $filterData["status"])
//                    ->take($request['itemPerPage'])->offset($startFrom)
//                    ->orderBy('id', 'DESC')
//                    ->get();
//            $getCountry = LstDlDiscounts::where('discount_name', $filterData["discount_name"])
//                    ->where('status', $filterData["status"])
//                    ->orderBy('id', 'DESC')
//                    ->get();
//            $enqCnt = count($getCountry);
//        } else {
//            $getCountry = LstDlDiscounts::all();
//            $enqCnt = count($getCountry);
//            $getCountries = LstDlDiscounts::take($request['itemPerPage'])->offset($startFrom)->get();
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
        $cnt = LstDlDiscounts::where(['discount_name' => $request['discount_name']])->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Discount heading already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['discountData'] = array_merge($request, $create);
            $result = LstDlDiscounts::create($input['discountData']);
            $last3 = LstDlDiscounts::latest('id')->first();
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = LstDlDiscounts::where(['discount_name' => $request['discount_name']])
                ->where('id', '!=', $id)
                ->get()
                ->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Discount heading already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['discountData'] = array_merge($request, $update);
            $result = LstDlDiscounts::where('id', $request['id'])->update($input['discountData']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
