<?php

namespace App\Modules\ManageLostReason\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Classes\CommonFunctions;
use App\Modules\ManageLostReason\Models\MlstBmsbEnquiryLostReasons;
use Auth;

class ManageLostReasonController extends Controller {

    public function index() {
        return view("ManageLostReason::index");
    }

    public function manageLostReason() {
        $data = MlstBmsbEnquiryLostReasons::select('id', 'reason', 'lost_reason_status')->get();
        if ($data) {
            $result = ['success' => true, 'records' => $data];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'records' => 'Something Wents Wrong'];
            echo json_encode($result);
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

        $getCount = MlstBmsbEnquiryLostReasons::where(['reason' => $request['reason']])->where('id','', $id)->get()->count();
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
