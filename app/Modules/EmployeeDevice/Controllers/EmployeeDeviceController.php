<?php

namespace App\Modules\EmployeeDevice\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\EmployeeDevice\Models\EmployeesDevice;
use Illuminate\Http\Request;
use App\Models\backend\Employee;
use DB;
use Auth;
use Validator;
use App\Classes\CommonFunctions;

class EmployeeDeviceController extends Controller {

    public function index() {
        return view("EmployeeDevice::index");
    }

    public function manageDevice() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        if ($input['id'] === 'index') { // index
            $data = EmployeesDevice::all();
            foreach ($data as $deviceData) {
                $name = '';
                $arr = explode(',', $deviceData['employee_id']);
                $empnames = Employee::whereIn('id', $arr)->select('first_name', 'last_name')->get();
                foreach ($empnames as $empname) {
                    $name .= ',' . $empname['first_name'] . ' ' . $empname['last_name'];
                }
                $name = trim($name, ',');
                $deviceData['employee_id'] = $name;
            }
        }
        if ($input['id'] === 0) { // create
            $data = 1;
        }
        if ($input['id'] > 0) { // update
            $data = EmployeesDevice::where('id', $input['id'])->get();
            $arr = explode(',', $data[0]['employee_id']);
            $employees = Employee::whereIn('id', $arr)->select('id', 'first_name', 'last_name', 'designation_id')->get();
            $data[0]['employee_id'] = $employees;
        }
        if (!empty($data)) {
            $result = ['success' => true, 'records' => $data];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function create() {
        return view('EmployeeDevice::createEmployeeDevice')->with('id', 0);
    }

    public function store() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $validationMessages = EmployeesDevice::validationMessages();
        $validationRules = EmployeesDevice::validationRules();
        $validator = Validator::make($input['data'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
        if (!empty($input['data']['employee_id'])) {
            $input['data']['employee_id'] = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $input['data']['employee_id']));
        } else {
            $input['data']['employee_id'] = $input['data']['employee_id'];
        }
        if (!empty($input['data']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['data'] = array_merge($input['data'], $create);
        $createDevice = EmployeesDevice::create($input['data']);
        if ($createDevice) {
            $result = ['success' => true, 'message' => "Device added successfully."];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'meassage' => "Something wents wrong"];
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
        return view('EmployeeDevice::createEmployeeDevice')->with('id', $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $validationMessages = EmployeesDevice::validationMessages();
        $validationRules = EmployeesDevice::validationRules();
        $validator = Validator::make($input['data'], $validationRules, $validationMessages);
        if ($validator->fails()) {
            $result = ['success' => false, 'message' => $validator->messages()];
            echo json_encode($result);
            exit;
        }
        if (!empty($input['data']['employee_id'])) {
            $input['data']['employee_id'] = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $input['data']['employee_id']));
        } else {
            $input['data']['employee_id'] = $input['data']['employee_id'];
        }
        if (!empty($input['data']['loggedInUserId'])) {
            $loggedInUserId = $input['userData']['loggedInUserId'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $update = CommonFunctions::updateMainTableRecords($loggedInUserId);
        $input['data'] = array_merge($input['data'], $update);
        $updateDevice = EmployeesDevice::where('id', $id)->update($input['data']);
        $result = ['success' => true, 'message' => "Device updated successfully."];
        return json_encode($result);
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

    public function getAllEmployeesList() {
        $getEmployees = Employee::select('id', 'first_name', 'last_name', 'designation_id')->get();
        if (!empty($getEmployees)) {
            $result = ['success' => true, 'records' => $getEmployees];
            return $result;
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

}
