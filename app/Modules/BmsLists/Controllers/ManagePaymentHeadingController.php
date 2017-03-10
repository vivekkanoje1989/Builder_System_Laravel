<?php

namespace App\Modules\BmsLists\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Hashing\HashServiceProvider;
use Auth;
use App\Classes\CommonFunctions;
use App\Models\PaymentHeadings;

class ManagePaymentHeadingController extends Controller {

    public function index() {
        return view("BmsLists::paymentheading");
    }

    public function managePaymentHeading() {
        $getPayment = PaymentHeadings::all();

        if (!empty($getPayment)) {
            $result = ['success' => true, 'records' => $getPayment];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function createPaymentHeading() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = PaymentHeadings::where(['type_of_payment' => $request['type_of_payment']])->get()->count();
        if ($cnt > 0) { //exists blood group
            $result = ['success' => false, 'errormsg' => 'Payment type already exists'];
            return json_encode($result);
        } else {
            $getResult = PaymentHeadings::create($request);
            $result = ['success' => true, 'result' => $getResult];
            return json_encode($result);
        }
    }

    public function updatePaymentHeading() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = PaymentHeadings::where(['type_of_payment' => $request['type_of_payment']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Payment type already exists'];
            return json_encode($result);
        } else {
            $result = PaymentHeadings::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
