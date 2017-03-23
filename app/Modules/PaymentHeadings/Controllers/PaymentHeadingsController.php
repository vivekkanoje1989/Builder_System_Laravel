<?php

namespace App\Modules\PaymentHeadings\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\PaymentHeadings\Models\LstDlPaymentHeadings;
use App\Classes\CommonFunctions;
use App\Modules\ManageProjectTypes\Models\ProjectTypes;
use DB;
use Auth;

class PaymentHeadingsController extends Controller {

    public function index() {
        return view("PaymentHeadings::paymentheading");
    }

    public function managePaymentHeading() {
        $getPayment = LstDlPaymentHeadings::all();

        if (!empty($getPayment)) {
            $result = ['success' => true, 'records' => $getPayment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    
     public function manageProjectTypes() {
        $getTypes = ProjectTypes::all();

        if (!empty($getTypes)) {
            $result = ['success' => true, 'records' => $getTypes];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
       
        $cnt = LstDlPaymentHeadings::where(['payment_heading' => $request['payment_heading']])->get()->count();
        if ($cnt > 0) { //exists blood group
            $result = ['success' => false, 'errormsg' => 'Payment type already exists'];
            return json_encode($result);
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['paymentHeading'] = array_merge($request, $create);
            $getResult = LstDlPaymentHeadings::create($input['paymentHeading']);
            $last3 = LstDlPaymentHeadings::latest('id')->first();
            $result = ['success' => true,'lastinsertid' => $last3->id];
         return json_encode($result);
          
        }
    }

    public function update($id) {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = LstDlPaymentHeadings::where(['payment_heading' => $request['payment_heading']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Payment type already exists'];
            return json_encode($result);
        } else {
            $result = LstDlPaymentHeadings::where('id', $id)->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
