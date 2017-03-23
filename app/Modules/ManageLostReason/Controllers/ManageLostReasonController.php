<?php

namespace App\Modules\ManageLostReason\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Classes\CommonFunctions;
use App\Modules\ManageLostReason\Models\EnquiryLostReason;
use Auth; 
class ManageLostReasonController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("ManageLostReason::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manageLostReason() {
        $data = EnquiryLostReason::select('id', 'reason', 'lost_reason_status')->get();
        if ($data) {
            $result = ['success' => true, 'records' => $data];
            echo json_encode($result);
        } else {
            $result = ['success' => false, 'records' => 'Something Wents Wrong'];
            echo json_encode($result);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $cnt = EnquiryLostReason::where(['reason' => $request['reason']])->get()->count();
        if ($cnt > 0) {
            $result = ['success' => false, 'errormsg' => 'Discount heading already exists'];
            return json_encode($result);
        } else {
             $loggedInUserId = Auth::guard('admin')->user()->id; 
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['reasonData'] = array_merge($request, $create);
            $result = EnquiryLostReason::create($input['reasonData']);
            $last3 = EnquiryLostReason::latest('id')->first();
            $result = ['success' => true, 'result' => $result, 'lastinsertid' => $last3->id];
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
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $getCount = EnquiryLostReason::where(['reason' => $request['reason']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Reason already exists'];
            return json_encode($result);
        } else {
            
            $result = EnquiryLostReason::where('id', $request['id'])->update(($request));
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
