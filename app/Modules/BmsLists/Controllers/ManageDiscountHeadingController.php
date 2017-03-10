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
use App\Models\Discountheading;

class ManageDiscountHeadingController extends Controller {

    public function index() {
        return view("BmsLists::discountheading");
    }

    public function manageDiscountHeading() {
        $getDiscountname = Discountheading::all();

        if (!empty($getDiscountname)) {
            $result = ['success' => true, 'records' => $getDiscountname];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }
    public function createDiscountHeading() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = Discountheading::where(['discount_name' => $request['discount_name']])->get()->count();
        if ($cnt > 0) { //exists blood group
            $result = ['success' => false, 'errormsg' => 'Discount heading already exists'];
            return json_encode($result);
        } else {
            $getResult = Discountheading::create($request);
            $result = ['success' => true, 'result' => $getResult];
            return json_encode($result);
        }
    }

    public function updateDiscountHeading() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $getCount = Discountheading::where(['discount_name' => $request['discount_name']])->get()->count();
        if ($getCount > 0) {
            $result = ['success' => false, 'errormsg' => 'Discount heading already exists'];
            return json_encode($result);
        } else {
            $result = Discountheading::where('id', $request['id'])->update($request);
            $result = ['success' => true, 'result' => $result];
            return json_encode($result);
        }
    }

}
