<?php

namespace App\Modules\ManageLostReason\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Classes\CommonFunctions;
use App\Modules\ManageLostReason\Models\MlstBmsbEnquiryLostReasons;
use Auth;
use Excel;

class ManageLostReasonController extends Controller {

    public function index() {
        return view("ManageLostReason::index");
    }

    public function manageLostReason() {
        $data = MlstBmsbEnquiryLostReasons::select('id', 'reason', 'lost_reason_status')->where('deleted_status', '!=', 1)->get();
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
        if ($data) {
            $result = ['success' => true, 'records' => $data, 'exportData' => $export,'delete'=>$deleteBtn];
        } else {
            $result = ['success' => false, 'records' => 'Something Wents Wrong'];
        }
        echo json_encode($result);
    }

    public function deleteLostReason() {
         $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::deleteMainTableRecords($loggedInUserId);
        $input['lostReasonData'] = array_merge($request, $create);
        $lostReasonData = MlstBmsbEnquiryLostReasons::where('id', $request['id'])->update($input['lostReasonData']);
        $result = ['success' => true, 'result' => $lostReasonData];
        return json_encode($result);
        
    }
    
    public function lostReasonExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $data = MlstBmsbEnquiryLostReasons::select('id', 'reason', 'lost_reason_status')->get();
            $getCount = MlstBmsbEnquiryLostReasons::select('id', 'reason', 'lost_reason_status')->get()->count();
            $data = json_decode(json_encode($data), true);

            $manageData = array();
            $j = 1;
            for ($i = 0; $i < count($data); $i++) {
                $blogData['Sr No.'] = $j++;
                $blogData['Reason'] = $data[$i]['reason'];
                if ($data[$i]['lost_reason_status'] == '1') {
                    $blogData['Status'] = 'Active';
                } else {
                    $blogData['Status'] = 'In Active';
                }
                $manageData[] = $blogData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Lost Reason Details', function($excel) use($manageData) {
                    $excel->sheet('sheet1', function($sheet) use($manageData) {
                        $sheet->fromArray($manageData);
                    });
                })->download('csv');
            }
        }
    }

    public function store() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $cnt = MlstBmsbEnquiryLostReasons::where(['reason' => $request['reason']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Discount heading already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['reasonData'] = array_merge($request, $create);
            $result = MlstBmsbEnquiryLostReasons::create($input['reasonData']);
            $last3 = MlstBmsbEnquiryLostReasons::latest('id')->first();
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
            return json_encode($result);
        }
    }

    public function update($id) {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $getCount = MlstBmsbEnquiryLostReasons::where(['reason' => $request['reason']])->where('id', '', $id)->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Reason already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
            $input['lostReason'] = array_merge($request, $update);
            $result = MlstBmsbEnquiryLostReasons::where('id', $request['id'])->update($input['lostReason']);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
