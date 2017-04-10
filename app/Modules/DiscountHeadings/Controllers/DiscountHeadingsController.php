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
        return view("DiscountHeadings::index");
    }

    public function manageDiscountHeadings() {
        $getDiscountname = LstDlDiscounts::all();

        if (!empty($getDiscountname)) {
            $result = ['success' => true, 'records' => $getDiscountname];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $cnt = LstDlDiscounts::where(['discount_name' => $request['discount_name']])->get()->count();
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
