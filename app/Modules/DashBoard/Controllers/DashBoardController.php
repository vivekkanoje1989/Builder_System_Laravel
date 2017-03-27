<?php

namespace App\Modules\DashBoard\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\DashBoard\Models\EmployeeRequest;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Classes\CommonFunctions;

class DashBoardController extends Controller {

    public function index() {
        return view("DashBoard::index");
    }

    public function other() {
        return view("DashBoard::other");
    }

    public function requestsForMe() {
        return view("DashBoard::requestsforme");
    }

    public function myRequest() {
        return view("DashBoard::myrequest");
    }

    public function store() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['employeeData'] = array_merge($request, $create);
        $input['employeeData']['request_type'] = 'Leave';
        $employee_request = EmployeeRequest::create($input['employeeData']);
        if (!empty($employee_request)) {
            $result = ['status' => true, 'records' => $employee_request];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function getEmployees() {
        $employees = DB::table('employees')->select("first_name", "last_name", "id", "designation")->get();
        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function getEmployeesCC() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $employees = DB::table('employees')->where('id', '!=', $request['id'])->get();

        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function otherApproval() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['employeeData'] = array_merge($request, $create);

        $employee_request = EmployeeRequest::create($input['employeeData']);
        if (!empty($employee_request)) {
            $result = ['status' => true, 'records' => $employee_request];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function getMyRequest() {
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                ->select('request.id', 'request.created_date', 'request.created_at', 'request.request_type', 'request.from_date', 'request.req_desc', 'request.to_date', 'employees.first_name', 'employees.last_name','request.status')
                ->where('request.created_by', '=', $loggedInUserId)
                ->get();

        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function description() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = EmployeeRequest::join('employees', 'request.cc', '=', 'employees.id')
                ->select('employees.first_name', 'employees.last_name')
                ->first();

        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }
    
    public function getRequestForMe()
    {
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                ->select('request.id', 'request.created_date', 'request.created_at', 'request.request_type', 'request.from_date', 'request.req_desc', 'request.to_date', 'employees.first_name', 'employees.last_name','request.status')
                ->where('request.uid', '=', $loggedInUserId)
                ->get();

        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

}
