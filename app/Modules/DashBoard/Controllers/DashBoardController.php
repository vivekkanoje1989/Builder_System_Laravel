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
use App\Models\backend\Employee;

class DashBoardController extends Controller {

    public function __construct() {
        $this->middleware('web');
    }

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

        $userId = array();
        $userCCId = array();
        foreach ($request['uid'] as $uid) {
            $userid = $uid['id'];
            array_push($userId, $userid);
        }
        $uid = implode(',', $userId);
        $request['uid']['id'] = $uid;

        if (!empty($request['cc'])) {
            foreach ($request['cc'] as $cc) {
                $userCCid = $cc['id'];
                array_push($userCCId, $userCCid);
            }
            $cc = implode(',', $userCCId);
            $request['cc'] = $cc;
        }
        if (!empty($request["loggedInUserId"])) {
            $loggedInUserId = $request["loggedInUserId"];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }

        $request['uid'] = $uid;
        $emailBody = $request['req_desc'];
        $fromDate = date("d-m-Y", strtotime($request['from_date']));
        $toDate = date("d-m-Y", strtotime($request['to_date']));

        if (!empty($request['cc'])) {
            $userCC = array();
            $userCC1 = array();
            $userCC = explode(',', $request['cc']);
            $employee = \App\Models\backend\Employee::select('personal_email1')->whereIn('id', $userCC)->get();
            for ($j = 0; $j < count($employee); $j++) {
                $userCC1[] = $employee[$j]['personal_email1'];
            }
            $empCC = implode(',', $userCC1);
        } else {
            $userCC = '';
        }
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['employeeData'] = array_merge($request, $create);
        $input['employeeData']['request_type'] = 'Leave';
        $input['employeeData']['in_date'] = date("Y-m-d") . " " . date("h-i-s");
        $employee_request = EmployeeRequest::create($input['employeeData']);
        if (!empty($request["empFirstName"])) {
            $loginFirstName = $request["empFirstName"];
        } else {
            $loginFirstName = Auth::guard('admin')->user()->first_name;
        }
        if (!empty($request["empLastName"])) {
            $loginlastName = $request["empLastName"];
        } else {
            $loginlastName = Auth::guard('admin')->user()->last_name;
        }
        $loginEmployeeName = $loginFirstName . ' ' . $loginlastName;
        $userId = array();
        $userId = explode(',', $uid);
        for ($i = 0; $i < count($userId); $i++) {
            $templatedata['employee_id'] = $userId[$i];
            $templatedata['client_id'] = config('global.client_id');
            $templatedata['template_setting_customer'] = 0;
            $templatedata['template_setting_employee'] = 48;
            $templatedata['event_id_customer'] = 0;
            $templatedata['event_id_employee'] = 68;
            $templatedata['customer_id'] = 0;
            $templatedata['model_id'] = 0;
            if (!empty($empCC)) {
                $templatedata['emp_cc'] = $empCC;
            }
            $templatedata['arrExtra'][0] = array(
                '[#emailBody#]',
                '[#loginEmployeeName#]',
                '[#fromDate#]',
                '[#toDate#]'
            );
            $templatedata['arrExtra'][1] = array(
                $emailBody,
                $loginEmployeeName,
                $fromDate,
                $toDate
            );

            $result = CommonFunctions::templateData($templatedata);
        }
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
        $i = 0;
        foreach ($employees as $employee) {
            $employees[$i]->employeeName = $employee->first_name . ' ' . $employee->last_name;
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
        $empId = implode(',', $request['id']);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $report = "select db2.first_name, db2.last_name, db2.id, db1.designation from `laravel_developement_master_edynamics`.`mlst_bmsb_designations` as `db1` inner join `laravel_developement_builder_client`.`employees` as `db2` on db1.id = db2.designation_id where db2.id <> ". $loggedInUserId." AND not find_in_set(db2.id, '".$empId."' )";
        $employees = DB::select($report);
//           $employees = DB::table('laravel_developement_master_edynamics.mlst_bmsb_designations as db1')
//                ->Join('laravel_developement_builder_client.employees as db2', 'db1.id', '=', 'db2.designation_id')
//                ->select(["db2.first_name", "db2.last_name", "db2.id", "db1.designation"])
//                ->where([
//                    ['db2.id', '<>', $loggedInUserId],
//                    ['db2.id', '<>', $request['id'][0]['id']]])
//                ->get();
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
        $userId = array();
        $userCCId = array();
        foreach ($request['uid'] as $uid) {
            $userid = $uid['id'];
            array_push($userId, $userid);
        }
        $uid = implode(',', $userId);
        $request['uid']['id'] = $uid;

        if (!empty($request['cc'])) {
            foreach ($request['cc'] as $cc) {
                $userCCid = $cc['id'];
                array_push($userCCId, $userCCid);
            }
            $cc = implode(',', $userCCId);
            $request['cc'] = $cc;
        }

        if (!empty($request["loggedInUserId"])) {
            $loggedInUserId = $request["loggedInUserId"];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        $request['uid'] = $uid;
        $emailBody = $request['req_desc'];
        $userCC = array();
        if (!empty($request['cc'])) {            
            $userCC1 = array();
            $userCC = explode(',', $request['cc']);
            $employee = \App\Models\backend\Employee::select('personal_email1')->whereIn('id', $userCC)->get();
            for ($j = 0; $j < count($employee); $j++) {
                $userCC1[] = $employee[$j]['personal_email1'];
            }
            $empCC = implode(',', $userCC1);
        }

        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['employeeData'] = array_merge($request, $create);
        $input['employeeData']['in_date'] = date("Y-m-d") . " " . date("h-i-s");

        $employee_request = EmployeeRequest::create($input['employeeData']);
        if (!empty($request["empFirstName"])) {
            $loginFirstName = $request["empFirstName"];
        } else {
            $loginFirstName = Auth::guard('admin')->user()->first_name;
        }
        if (!empty($request["empLastName"])) {
            $loginlastName = $request["empLastName"];
        } else {
            $loginlastName = Auth::guard('admin')->user()->last_name;
        }
        $loginEmployeeName = $loginFirstName . ' ' . $loginlastName;
  
        $userId = explode(',', $uid);
        for ($i = 0; $i < count($userId); $i++) {
            $templatedata['employee_id'] = $userId[$i];
            $templatedata['client_id'] = config('global.client_id');
            $templatedata['template_setting_customer'] = 0;
            $templatedata['template_setting_employee'] = 49;
            $templatedata['event_id_customer'] = 0;
            $templatedata['event_id_employee'] = 69;
            $templatedata['customer_id'] = 0;
            $templatedata['model_id'] = 0;
            if (!empty($empCC)) {
                $templatedata['emp_cc'] = $empCC;
            }
            $templatedata['arrExtra'][0] = array(
                '[#emailBody#]',
                '[#loginEmployeeName#]'
            );
            $templatedata['arrExtra'][1] = array(
                $emailBody,
                $loginEmployeeName
            );

            $result = CommonFunctions::templateData($templatedata);
        }
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
        $export = '';
        $query = '';
        if (!empty($request['loggedInUserID']))
            $loggedInUserId = $request['loggedInUserID'];
        else
            $loggedInUserId = Auth::guard('admin')->user()->id;
        if (isset($request['pageNumber'])) {
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            if (!empty($request['filterData'])) {
                $request['filterData']['request_type'] = !empty($request['filterData']) ? $request['filterData'][0]['request_type'] : '';
                $request['filterData']['uid'] = !empty($request['filterData'][0]['uid']) ? $request['filterData'][0]['uid'] : '';
//            $request['filterData']['in_date'] = !empty($request['filterData'][0]['in_date']) ? date('Y-m-d', strtotime($request['filterData'][0]['in_date'] )): '';
                $request['filterData']['from_date'] = !empty($request['filterData'][0]['from_date']) ? date('Y-m-d', strtotime($request['filterData'][0]['from_date'])) : '';
                $request['filterData']['to_date'] = !empty($request['filterData'][0]['to_date']) ? date('Y-m-d', strtotime($request['filterData'][0]['to_date'])) : '';

                if (!empty($request['filterData']['request_type'])) {
                    $query .= " AND req.request_type = '" . $request['filterData']['request_type'] . "'";
                }
                if (!empty($request['filterData']['uid'])) {
                    $query .= " AND FIND_IN_SET (" . $request['filterData']['uid'] . ",req.uid)";
                }
                if (!empty($request['filterData']['from_date'])) {
                    $query .= " AND req.from_date  = '" . $request['filterData']['from_date'] . "'";
                }
                if (!empty($request['filterData']['to_date'])) {
                    $query .= " AND req.to_date  = '" . $request['filterData']['to_date'] . "'";
                }

                $report = "SELECT req.in_date, req.created_at, req.request_type, req.from_date, req.req_desc, req.to_date, req.status,GROUP_CONCAT(distinct emp.first_name,' ', emp.last_name) as empName "
                        . "FROM `request` as req LEFT JOIN employees as emp ON emp.id =" . $request['filterData']['uid'] . " "
                        . "WHERE req.created_by = " . $loggedInUserId . $query . " GROUP BY req.id  limit " . $startFrom . "," . $request['itemPerPage'];
                $employees = DB::select($report);
            } else {
                $report = "select SQL_CALC_FOUND_ROWS request.id, request.in_date, request.created_at, request.request_type, request.from_date, request.req_desc, request.to_date, GROUP_CONCAT(distinct employees.first_name,' ', employees.last_name) as empName, request.status from request left join employees on find_in_set(employees.id, request.uid) where request.created_by = " . $loggedInUserId . " GROUP BY request.id limit " . $startFrom . "," . $request['itemPerPage'];
                $employees = DB::select($report);
            }
            $rows = DB::select("select FOUND_ROWS() as totalCount");
            $cnt = $rows[0]->totalCount;
        } else {
            $report = "select request.id, request.in_date, request.created_at, request.request_type, request.from_date, request.req_desc, request.to_date, GROUP_CONCAT(distinct employees.first_name,' ', employees.last_name) as empName, request.status from request left join employees on find_in_set(employees.id, request.uid) where request.created_by = " . $loggedInUserId . " GROUP BY request.id ";
            $employees = DB::select($report);
            $cnt = '';
        }
        $i = 0;
        foreach ($employees as $employee) {
            $employees[$i]->application_to = $employee->empName;
            $i++;
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
            if (in_array('01401', $array)) {
                $export = 1;
            }
        }
        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees, 'exportData' => $export, 'totalCount' => $cnt];
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
        $export = '';
        if (!empty($request['loggedInUserID'])) {
            $loggedInUserId = $request['loggedInUserID'];
        } else {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        }
        if (isset($request['pageNumber'])) {
            $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            if (!empty($request['filterData'])) {
                $request['filterData']['request_type'] = !empty($request['filterData']) ? $request['filterData'][0]['request_type'] : '';
                $request['filterData']['uid'] = !empty($request[0]['uid']) ? $request['filterData'][0]['uid'] : '';
//            $request['filterData']['in_date'] = !empty($request['filterData'][0]['in_date']) ? date('Y-m-d', strtotime($request['filterData'][0]['in_date'] )): '';
                $request['filterData']['from_date'] = !empty($request['filterData'][0]['from_date']) ? date('Y-m-d', strtotime($request['filterData'][0]['from_date'])) : '';
                $request['filterData']['to_date'] = !empty($request['filterData'][0]['to_date']) ? date('Y-m-d', strtotime($request['filterData'][0]['to_date'])) : '';

                $employees = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                        ->select([DB::raw('SQL_CALC_FOUND_ROWS request.id, request.in_date, request.created_at, request.request_type, request.from_date, request.req_desc, request.to_date, employees.first_name, employees.last_name, request.status')])
                        ->where('request.uid', '=', $loggedInUserId)
                        ->where('request.request_type', 'like', '%' . $request['filterData']['request_type'] . '%')
                        ->where('request.uid', 'like', '%' . $request['filterData']['uid'] . '%')
                        ->where('request.from_date', $request['filterData']['from_date'])
                        ->where('request.to_date', $request['filterData']['to_date'])
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
            } else {
                $employees = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                        ->select([DB::raw('SQL_CALC_FOUND_ROWS request.id, request.in_date, request.created_at, request.request_type, request.from_date, request.req_desc, request.to_date, employees.first_name, employees.last_name, request.status')])
                        ->where('request.uid', '=', $loggedInUserId)
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
            }
            $rows = DB::select("select FOUND_ROWS() as totalCount");
            $cnt = $rows[0]->totalCount;
        } else {
            $employees = EmployeeRequest::join('employees', 'request.uid', '=', 'employees.id')
                    ->select('request.id', 'request.in_date', 'request.created_at', 'request.request_type', 'request.from_date', 'request.req_desc', 'request.to_date', 'employees.first_name', 'employees.last_name', 'request.status')
                    ->where('request.uid', '=', $loggedInUserId)
                    ->get();
            $cnt = '';
        }
        $i = 0;
        foreach ($employees as $employee) {
            $employees[$i]['application_from'] = $employee['first_name'] . ' ' . $employee['last_name'];
            $date = explode(' ', $employee['in_date']);
            $employees[$i]['in_date'] = $date[0];
            $i++;
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
            if (in_array('01401', $array)) {
                $export = 1;
            }
        }
        if (!empty($employees)) {
            $result = ['status' => true, 'records' => $employees, 'exportData' => $export, 'totalCount' => $cnt];
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
                })->download('csv');
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
                })->download('csv');
            }
        }
    }

}
