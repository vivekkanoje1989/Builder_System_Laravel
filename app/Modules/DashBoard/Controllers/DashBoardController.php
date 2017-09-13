<?php

namespace App\Modules\DashBoard\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\DashBoard\Models\EmployeeRequest;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Classes\CommonFunctions;
use Excel;

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
        $uid = $request['uid']['id'];
        $cc = $request['cc']['id'];
        if (!empty($request["loggedInUserId"])) {
            $loggedInUserId = $request["loggedInUserId"];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        unset($request['uid']);
        unset($request['cc']);
        $request['uid'] = $uid;
        $request['cc'] = $cc;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['employeeData'] = array_merge($request, $create);
        $input['employeeData']['request_type'] = 'Leave';
        $input['employeeData']['in_date'] = date("Y-m-d") . " " . date("h-i-s");

        $employee_request = EmployeeRequest::create($input['employeeData']);
        if (!empty($employee_request)) {
            $result = ['status' => true, 'records' => $employee_request];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function getEmployees() {

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = DB::table('laravel_developement_master_edynamics.mlst_bmsb_designations as db1')
                ->Join('laravel_developement_builder_client.employees as db2', 'db1.id', '=', 'db2.designation_id')
                ->select(["db2.first_name", "db2.last_name", "db2.id", "db1.designation"])
                ->where('db2.id', '!=', $loggedInUserId)
                ->get();
        $i=0;
        foreach($employees as $employee){
            $employees[$i]->employeeName = $employee->first_name.' '.$employee->last_name;
            $i++;
        }

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

        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = DB::table('laravel_developement_master_edynamics.mlst_bmsb_designations as db1')
                ->Join('laravel_developement_builder_client.employees as db2', 'db1.id', '=', 'db2.designation_id')
                ->select(["db2.first_name", "db2.last_name", "db2.id", "db1.designation"])
                ->where('db2.id', '!=', $request['id'])
                ->where('db2.id', '!=', $loggedInUserId)
                ->get();
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
        if (!empty($request["loggedInUserId"])) {
            $loggedInUserId = $request["loggedInUserId"];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['employeeData'] = array_merge($request, $create);
        $input['employeeData']['in_date'] = date("Y-m-d") . " " . date("h-i-s");

        $employee_request = EmployeeRequest::create($input['employeeData']);
        if (!empty($employee_request)) {
            $result = ['status' => true, 'records' => $employee_request];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function getMyRequest() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        if (!empty($request['loggedInUserID']))
            $loggedInUserId = $request['loggedInUserID'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                ->select('request.id', 'request.in_date', 'request.created_at', 'request.request_type', 'request.from_date', 'request.req_desc', 'request.to_date', 'employees.first_name', 'employees.last_name', 'request.status')
                ->where('request.created_by', '=', $loggedInUserId)
                ->get();
        $i = 0;
        foreach ($employees as $employee) {
            $employees[$i]['application_to'] = $employee['first_name'] . ' ' . $employee['last_name'];
            $i++;
        }
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        }else{
              $export = '';
        }
        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees, 'exportData' => $export];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function description() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $employees = EmployeeRequest::join('employees', 'request.cc', '=', 'employees.id')
                ->select('employees.first_name', 'employees.last_name')
                ->where('request.id', $request['id'])
                ->first();
        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "No record"];
        }
        return json_encode($result);
    }

    public function getRequestForMe() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        if (!empty($request['data']['loggedInUserID']))
            $loggedInUserId = $request['data']['loggedInUserID'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;
        $employees = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                ->select('request.id', 'request.in_date', 'request.created_at', 'request.request_type', 'request.from_date', 'request.req_desc', 'request.to_date', 'employees.first_name', 'employees.last_name', 'request.status')
                ->where('request.uid', '=', $loggedInUserId)
                ->get();
        $i = 0;
        foreach ($employees as $employee) {
            $employees[$i]['application_from'] = $employee['first_name'] . ' ' . $employee['last_name'];
            $i++;
        }
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        }else{
              $export = '';
        }
        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees, 'exportData' => $export];
        } else {
            $result = ['status' => false, 'message' => "Something went wrong"];
        }
        return json_encode($result);
    }

    public function changeStatus() {
        $postdata = file_get_contents('php://input');
        $request = json_decode($postdata, true);
        $request['reply_date'] = date("Y-m-d") . " " . date("h-i-s");
        if (!empty($request['reply_by']))
            $request['reply_by'] = $request['reply_by'];
        else
            $request['reply_by'] = Auth::guard('admin')->user()->id;
        $employees = EmployeeRequest::where('id', $request['id'])->update($request);
        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees];
        } else {
            $result = ['status' => false, 'message' => "Record updated already"];
        }
        return json_encode($result);
    }

//function to export data to xls
    public function exportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $loggedInUserId = Auth::guard('admin')->user()->id;
            $getCount = EmployeeRequest::where('created_by', '=', $loggedInUserId)->get()->count();
//        $myRequest = EmployeeRequest::select('id as SrNo','Request Type as request_type')->where('created_by', '=', $loggedInUserId)->get();
            $myRequest = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                    ->select('request.id', 'request.in_date', 'request.created_at', 'request.request_type', 'request.from_date', 'request.req_desc', 'request.to_date', 'employees.first_name', 'employees.last_name', 'request.status')
                    ->where('request.created_by', '=', $loggedInUserId)
                    ->get();
            $i = 0;
            foreach ($myRequest as $employee) {
                $myRequest[$i]['application_to'] = $employee['first_name'] . ' ' . $employee['last_name'];
                $i++;
            }
            $myRequestData = [];
            $data = [];
            $k = 1;
            for ($j = 0; $j < count($myRequest); $j++) {
                $myRequestData['Sr No'] = $k++;
                $myRequestData['Application To'] = $myRequest[$j]['application_to'];
                $myRequestData['Request Type'] = $myRequest[$j]['request_type'];
                $myRequestData['From Date'] = $myRequest[$j]['from_date'];
                $myRequestData['To Date'] = $myRequest[$j]['to_date'];
                if ($myRequest[$j]['status'] == '1') {
                    $myRequestData['Status'] = 'Leave';
                } else {
                    $myRequestData['Status'] = 'Approved';
                }
                $data[] = $myRequestData;
            }
            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export My Request Data', function($excel) use($data) {
                    $excel->sheet('sheet1', function($sheet) use($data) {
                        $sheet->fromArray($data);
                    });
                })->download('xls');
            }
        }
    }

    public function requestForMeExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {

            $loggedInUserId = Auth::guard('admin')->user()->id;
            $getCount = EmployeeRequest::where('created_by', '=', $loggedInUserId)->get()->count();
//        $myRequest = EmployeeRequest::select('id as SrNo','Request Type as request_type')->where('created_by', '=', $loggedInUserId)->get();
            $employees = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                    ->select('request.id', 'request.in_date', 'request.created_at', 'request.request_type', 'request.from_date', 'request.req_desc', 'request.to_date', 'employees.first_name', 'employees.last_name', 'request.status')
                    ->where('request.uid', '=', $loggedInUserId)
                    ->get();
            $i = 0;
            foreach ($employees as $employee) {
                $employees[$i]['application_from'] = $employee['first_name'] . ' ' . $employee['last_name'];
                $i++;
            }
//        print_r($employees);exit;
            $myRequestData = [];
            $data = [];
            $k = 1;
            for ($j = 0; $j < count($employees); $j++) {
                $myRequestData['Sr No'] = $k++;
                $myRequestData['Application To'] = $employees[$j]['application_from'];
                $myRequestData['Request Type'] = $employees[$j]['request_type'];
                $myRequestData['From Date'] = $employees[$j]['from_date'];
                $myRequestData['To Date'] = $employees[$j]['to_date'];
                if ($employees[$j]['status'] == '1') {
                    $myRequestData['Status'] = 'Leave';
                } else {
                    $myRequestData['Status'] = 'Approved';
                }
                $data[] = $myRequestData;
            }
            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Request For Me Data', function($excel) use($data) {
                    $excel->sheet('sheet1', function($sheet) use($data) {
                        $sheet->fromArray($data);
                    });
                })->download('xls');
            }
        }
    }

}
