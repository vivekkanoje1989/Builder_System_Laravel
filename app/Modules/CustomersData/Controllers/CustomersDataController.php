<?php

namespace App\Modules\CustomersData\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\CustomersData\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Classes\CommonFunctions;
use App\Classes\S3;

class CustomersDataController extends Controller {

    public function index() {
        return view("CustomersData::index");
    }

    public function customerData() {
        $result = Customers::all();
        if (!empty($result)) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['mssg' => 'No record found', 'status' => false]);
        }
    }

    public function getcustomerData() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $result = Customers::where('id', $request['id'])->first();
        if (!empty($result)) {
            return json_encode(['result' => $result, 'status' => true]);
        } else {
            return json_encode(['mssg' => 'No record found', 'status' => false]);
        }
    }

    public function update() {
        $input = Input::all();
        if (!empty($input['emp_photo_url'])) {
            $originalName = $input['emp_photo_url']->getClientOriginalName();
            if ($originalName !== 'fileNotSelected') {
                $s3FolderName = "Customer";
                $imageName = 'customer_' . rand(pow(10, config('global.randomNoDigits') - 1), pow(10, config('global.randomNoDigits')) - 1) . '.' . $input['emp_photo_url']->getClientOriginalExtension();
                S3::s3FileUplod($input['emp_photo_url']->getPathName(), $imageName, $s3FolderName);
                $image_file = $imageName;
                unset($input['emp_photo_url']);
            } else {
                unset($input['emp_photo_url']);
            }
        }
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['customerData'] = array_merge($input, $create);
        if(!empty($image_file))
        {
          $input['customerData']['image_file'] = $image_file;    
        }
        $input['customerData']['client_id'] = $loggedInUserId;
        $result = Customers::where('id', $input['id'])->update($input['customerData']);
        return json_encode(['result' => $result, 'status' => true]);
    }

    public function edit($id) {
        return view("CustomersData::edit")->with("custId", $id);
    }

}
