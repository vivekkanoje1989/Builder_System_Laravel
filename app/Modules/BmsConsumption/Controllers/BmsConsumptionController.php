<?php

namespace App\Modules\BmsConsumption\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use Excel;
use Illuminate\Http\Request;
use App\Models\SmsLog;
use App\Models\backend\Employee;

class BmsConsumptionController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("BmsConsumption::index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        
    }

    public function smsConsumption() {
        return view("BmsConsumption::smsConsumption")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function smsReport() {
        return view("BmsConsumption::smsReport")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function smsLogs() {
        return view("BmsConsumption::smsLogs")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function smsLogDetails($id) {
        return view("BmsConsumption::smsLogDetails")->with('transactionId', $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function allSmsReports() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
        }
        $getSmsReportlist = array();
        $reportData = [];
        $smsReport = [];
        $smsPercentage = [];
        $currentMonth = date('m');
        $currentYear = date('Y');
        $Totalsms = SmsLog::whereYear('created_at', '=', $currentYear)
                ->whereMonth('created_at', '=', $currentMonth)
                ->where('employee_id', '=', $emp_id)
                ->get();
        $successSms = SmsLog::whereYear('created_at', '=', $currentYear)
                ->whereMonth('created_at', '=', $currentMonth)
                ->where('employee_id', '=', $emp_id)
                ->where('status', '=', 'success')
                ->get();
        $reportData['total'] = count($Totalsms);
        $reportData['success'] = count($successSms);
        $reportData['fail'] = $reportData['total'] - $reportData['success'];
        $smsReport[] = $reportData;
        if ($reportData['total'] != 0) {
            $reportDataP['successPercentage'] = round(($reportData['success'] / $reportData['total']) * 100);
            $reportDataP['failPercentage'] = round(($reportData['fail'] / $reportData['total']) * 100);
            $reportDataP['totalPercentage'] = round(($reportData['total'] / $reportData['total']) * 100);
            $smsPercentage[] = $reportDataP;
        }

        $firstDateofThisMonth = date('01-m-Y');
        $currentDate = date('d-m-Y');
        if (!empty($reportData)) {
            $result = ['success' => true, 'records' => $smsReport, 'logInPercentage' => $smsPercentage, 'firstDate' => $firstDateofThisMonth, 'currentDate' => $currentDate];
        } else {
            $result = ['success' => false, 'records' => $smsReport, 'logInPercentage' => $smsPercentage];
        }
        return json_encode($result);
    }

    public function allSmsLogs() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
//        print_r($request);exit;
        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
            if ($request['filterFlag'] == 1) {
                BmsConsumptionController::$procname = "proc_sms_logs";
                return $this->filteredData();
                exit;
            }
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
        }
        $getSmsLoglist = array();
        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        $getCount = SmsLog::where('employee_id', $emp_id)
                ->groupBy('externalId1')
                ->orderBy('id', 'desc')
                ->get();
        $getCountSms = count($getCount);
        $getSmsLogs = SmsLog::where('employee_id', $emp_id)
                ->groupBy('externalId1')
                ->orderBy('id', 'desc')
                ->take($request['itemPerPage'])->offset($startFrom)
                ->get();
        $cnt = count($getSmsLogs);
        $getSmsLog = [];
        $getSmsLog = array();
        $transactionId = [];
        for ($i = 0; $i < $cnt; $i++) {
            $transactionId[] = $getSmsLogs[$i]['externalId1'];
            $getSmsLogs[$i]['dateTime'] = date('d-m-Y h:i A', strtotime($getSmsLogs[$i]['sent_date_time']));
        }

        for ($k = 0; $k < count($transactionId); $k++) {
            $getSmslist = SmsLog::where('externalId1', $transactionId[$k])->get();
            $getListcnt = count($getSmslist);
            $sum = 0;
            $count = 0;
            for ($j = 0; $j < $getListcnt; $j++) {
                if (trim($getSmslist[$j]['status']) == "success") {
                    $count++;
                }
                $credit = $getSmslist[$j]['credits_deducted'];
                $sum = $sum + $credit;
            }
            $data['successSms'] = $count;
            $data['credits'] = $sum;
            $data['failSms'] = count($getSmslist) - $data['successSms'];
            $data['totalSms'] = count($getSmslist);
            $getDetails[] = $data;
        }
        if (!empty($getDetails)) {
            for ($m = 0; $m < count($getDetails); $m++) {
                $getSmsLogs[$m]['smsDetails'] = $getDetails[$m];
            }
        }
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }

        if (!empty($getSmsLogs)) {
            $result = ['success' => true, 'records' => $getSmsLogs, 'totalCount' => $getCountSms, 'exportSmsLogsData' => $export];
        } else {
            $result = ['success' => false, 'records' => $getSmsLogs, 'totalCount' => $getCountSms];
        }
        return json_encode($result);
    }

    public function smsLogsExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $emp_id = Auth::guard('admin')->user()->id;
            $getSmsLoglist = array();
            $getCount = SmsLog::where('employee_id', $emp_id)
                    ->groupBy('externalId1')
                    ->orderBy('id', 'desc')
                    ->get()
                    ->count();

            $getSmsLogs = SmsLog::where('employee_id', $emp_id)
                    ->groupBy('externalId1')
                    ->orderBy('id', 'desc')
                    ->get();
            $cnt = count($getSmsLogs);
            $getSmsLog = [];
            $getSmsLog = array();
            $transactionId = [];
            for ($i = 0; $i < $cnt; $i++) {
                $transactionId[] = $getSmsLogs[$i]['externalId1'];
                $getSmsLogs[$i]['dateTime'] = date('d-m-Y h:i A', strtotime($getSmsLogs[$i]['sent_date_time']));
            }

            for ($k = 0; $k < count($transactionId); $k++) {
                $getSmslist = SmsLog::where('externalId1', $transactionId[$k])->get();
                $getListcnt = count($getSmslist);
                $sum = 0;
                $count = 0;
                for ($j = 0; $j < $getListcnt; $j++) {
                    if (trim($getSmslist[$j]['status']) == "success") {
                        $count++;
                    }
                    $credit = $getSmslist[$j]['credits_deducted'];
                    $sum = $sum + $credit;
                }
                $data['successSms'] = $count;
                $data['credits'] = $sum;
                $data['failSms'] = count($getSmslist) - $data['successSms'];
                $data['totalSms'] = count($getSmslist);
                $getDetails[] = $data;
            }

            for ($m = 0; $m < count($getDetails); $m++) {
                $getSmsLogs[$m]['smsDetails'] = $getDetails[$m];
            }

            $smsLogsdata = array();
            $n = 1;
            $getSmsLogs = json_decode(json_encode($getSmsLogs), true);
            for ($p = 0; $p < count($getSmsLogs); $p++) {
                $smsLogs['Sr No'] = $n++;
                $smsLogs['Date Time'] = $getSmsLogs[$p]['dateTime'];
                $smsLogs['Transaction Id'] = $getSmsLogs[$p]['externalId1'];
                $smsLogs['Sms Body'] = str_replace('&nbsp;', '', strip_tags(preg_replace("/\r|\n/", "", $getSmsLogs[$p]['sms_body'])));
                $smsLogs['Sms Type'] = $getSmsLogs[$p]['sms_type'];
                $smsLogs['Success Sms'] = $getSmsLogs[$p]['smsDetails']['successSms'];
                if ($getSmsLogs[$p]['smsDetails']['failSms'] == '0') {
                    $smsLogs['Fail Sms'] = '0';
                } else {
                    $smsLogs['Fail Sms'] = $getSmsLogs[$p]['smsDetails']['failSms'];
                }

                $smsLogs['Total Sms'] = $getSmsLogs[$p]['smsDetails']['totalSms'];
                $smsLogs['Credits'] = $getSmsLogs[$p]['smsDetails']['credits'];

                $smsLogsdata[] = $smsLogs;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export SMS Logs Data', function($excel) use($smsLogsdata) {
                    $excel->sheet('sheet1', function($sheet) use($smsLogsdata) {
                        $sheet->fromArray($smsLogsdata);
                    });
                })->download('csv');
            }
        }
    }

    public function smsLogDetailsExportToxls($transId) {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $emp_id = Auth::guard('admin')->user()->id;
            $transactionId = $transId;
            $getSmslist = SmsLog::join('employees as emp', 'emp.id', '=', 'sms_logs.employee_id')
                            ->select('sms_logs.*', 'emp.first_name', 'emp.last_name')
                            ->where('externalId1', $transactionId)->get();
            $getCount = SmsLog::where('externalId1', $transactionId)->get()->count();

            for ($i = 0; $i < count($getSmslist); $i++) {
                $employee_id = $getSmslist[$i]['employee_id'];
                $getSmslist[$i]['dateTime'] = date('d-m-Y h:i A', strtotime($getSmslist[$i]['sent_date_time']));
                $getSmslist[$i]['mobile_code'] = substr($getSmslist[$i]['mobile_number'], 0, 2);
                $mobile_first = substr($getSmslist[$i]['mobile_number'], 3, 2);
                $mobile_last = substr($getSmslist[$i]['mobile_number'], 11, 2);
                $getSmslist[$i]['mobile'] = $mobile_first . 'xxxxxx' . $mobile_last;
                $first_name = $getSmslist[$i]['first_name'];
                $last_name = $getSmslist[$i]['last_name'];
                $getSmslist[$i]['employee_name'] = $first_name . ' ' . $last_name;
            }

            $smsLogsdata = array();
            $n = 1;
            $getSmslist = json_decode(json_encode($getSmslist), true);
            for ($p = 0; $p < count($getSmslist); $p++) {
                $smsLogs['Sr No'] = $n++;
                $smsLogs['Date Time'] = $getSmslist[$p]['sent_date_time'];
                $smsLogs['Mobile Number'] = $getSmslist[$p]['mobile_number'];
                $smsLogs['Sms Body'] = str_replace('&nbsp;', '', strip_tags(preg_replace("/\r|\n/", "", $getSmslist[$p]['sms_body'])));
                $smsLogs['Employee Name'] = $getSmslist[$p]['employee_name'];
                $smsLogs['Sms Type'] = $getSmslist[$p]['sms_type'];
                $smsLogs['Delivery Status'] = $getSmslist[$p]['status'];
                $smsLogs['Date and Time'] = $getSmslist[$p]['dateTime'];
                $smsLogs['Reason'] = $getSmslist[$p]['status'];
                $smsLogs['Credits Billed'] = $getSmslist[$p]['credits_deducted'];

                $smsLogsdata[] = $smsLogs;
            }
            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Log Details Data', function($excel) use($smsLogsdata) {
                    $excel->sheet('sheet1', function($sheet) use($smsLogsdata) {
                        $sheet->fromArray($smsLogsdata);
                    });
                })->download('csv');
            }
        }
    }

    public function smsLogData() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $transactionId = $request['id'];
        $getSmslist = SmsLog::where('externalId1', $transactionId)->get();
        for ($i = 0; $i < count($getSmslist); $i++) {
            $employee_id = $getSmslist[$i]['employee_id'];
            $getSmslist[$i]['dateTime'] = date('d-m-Y h:i A', strtotime($getSmslist[$i]['sent_date_time']));
            $getSmslist[$i]['mobile_code'] = substr($getSmslist[$i]['mobile_number'], 0, 2);
            $mobile_first = substr($getSmslist[$i]['mobile_number'], 3, 2);
            $mobile_last = substr($getSmslist[$i]['mobile_number'], 11, 2);
            $getSmslist[$i]['mobile'] = $mobile_first . 'xxxxxx' . $mobile_last;
        }
        $getEmpName = Employee::where('id', $employee_id)->get();
        $employee_name = $getEmpName[0]['first_name'] . ' ' . $getEmpName[0]['last_name'];

//       
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }
        if (!empty($getSmslist)) {
            $result = ['success' => true, 'records' => $getSmslist, 'employee_name' => $employee_name, 'smsLogDetailsData' => $export];
        } else {
            $result = ['success' => false, 'records' => $getSmslist];
        }
        return json_encode($result);
    }

    public function filteredData() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $filterData = $request['filterData'];
        $ids = [];

        if (empty($request['employee_id'])) { // For Web
            $loggedInUserId = Auth::guard('admin')->user()->id;
        } else { // For App
            $request["getProcName"] = BmsConsumptionController::$procname;
            $loggedInUserId = $request['employee_id'];

            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
                $loggedInUserId = implode(',', array_map(function($el) {
                            return $el['id'];
                        }, $filterData['empId']));
            }
            $filterData["mobile_number"] = !empty($filterData["mobile_number"]) ? $filterData["mobile_number"] : "";
            $filterData["sms_type"] = !empty($filterData['sms_type']) ? $filterData["sms_type"] : "";
            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        }
        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
            $loggedInUserId = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $filterData['empId']));
        }
        $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
        $filterData["toDate"] = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
        $filterData["mobile_number"] = !empty($filterData['mobile_number']) ? ($filterData['mobile_number']) : "";
        $filterData["externalId1"] = !empty($filterData['externalId1']) ? ($filterData['externalId1']) : "";
        $filterData["sms_type"] = !empty($filterData['sms_type']) ? ($filterData['sms_type']) : "";
        $request["getProcName"] = "proc_sms_logs";
        if (empty($filterData["fromDate"])) {
            $filterData["toDate"] = '';
        }

        $getSmsLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["fromDate"] . '","' .
                        $filterData["toDate"] . '","' . $filterData["sms_type"] . '","' . $filterData["externalId1"] . '","' . $request['pageNumber'] . '","' . $request['itemPerPage'] . '")');

        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = $enqCnt[0]->totalCount;
        if (!empty($getSmsLogs)) {
            for ($i = 0; $i < count($getSmsLogs); $i++) {
                $transactionId[] = $getSmsLogs[$i]->externalId1;
                $getSmsLogs[$i]->dateTime = date('d-m-Y h:i A', strtotime($getSmsLogs[$i]->sent_date_time));
            }

            for ($k = 0; $k < count($transactionId); $k++) {
                $getSmslist = SmsLog::where('externalId1', $transactionId[$k])->get();
                $getListcnt = count($getSmslist);
                $sum = 0;
                $count = 0;
                for ($j = 0; $j < $getListcnt; $j++) {
                    if (trim($getSmslist[$j]['status']) == "success") {
                        $count++;
                    }
                    $credit = $getSmslist[$j]['credits_deducted'];
                    $sum = $sum + $credit;
                }
                $data['successSms'] = $count;
                $data['credits'] = $sum;
                $data['failSms'] = count($getSmslist) - $data['successSms'];
                $data['totalSms'] = count($getSmslist);
                $getDetails[] = $data;
            }

            for ($m = 0; $m < count($getDetails); $m++) {
                $getSmsLogs[$m]->smsDetails = $getDetails[$m];
            }

            $i = 0;
        }

        if (!empty($getSmsLogs)) {
            $result = ['success' => true, 'records' => $getSmsLogs, 'totalCount' => $enqCnt];
        } else {
            $result = ['success' => false, 'records' => $getSmsLogs, 'totalCount' => count($getSmsLogs)];
        }
        return json_encode($result);
    }

    public function filterReportData() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $filterData = $request['filterData'];
        $ids = [];
        if (empty($request['employee_id'])) { // For Web
            $loggedInUserId = Auth::guard('admin')->user()->id;
        } else { // For App
            $request["getProcName"] = BmsConsumptionController::$procname;
            $loggedInUserId = $request['employee_id'];

            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
                $loggedInUserId = implode(',', array_map(function($el) {
                            return $el['id'];
                        }, $filterData['empId']));
            }
            $filterData["sms_type"] = !empty($filterData['sms_type']) ? $filterData["sms_type"] : "";
            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        }
        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
            $loggedInUserId = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $filterData['empId']));
        }
        $currentMonth = date('m');
        $currentYear = date('Y');
        $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
        $toDate = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
        $filterData["sms_type"] = !empty($filterData['sms_type']) ? ($filterData['sms_type']) : "";
        $filterData["toDate"] = $toDate;
        $getSmsReportLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","' . $filterData["fromDate"] . '","' .
                        $filterData["toDate"] . '","' . $filterData["sms_type"] . '")');

        $totalRecords = count($getSmsReportLogs);
        $reportFilterData = [];
        $smsPercentage = [];
        $count = 0;
        for ($k = 0; $k < $totalRecords; $k++) {
            if (trim($getSmsReportLogs[$k]->status) == 'success') {
                $count++;
            }
        }

        if ($totalRecords != 0) {
            $getSmsReportLogs['total'] = $totalRecords;
            $getSmsReportLogs['success'] = $count;
            $getSmsReportLogs['fail'] = $totalRecords - $getSmsReportLogs['success'];
            $reportFilterData[] = $getSmsReportLogs;
            if ($getSmsReportLogs['success'] != 0) {
                $reportDataP['successPercentage'] = round(($getSmsReportLogs['success'] / $getSmsReportLogs['total']) * 100);
            } else {
                $reportDataP['successPercentage'] = 0;
            }

            if ($getSmsReportLogs['fail'] != 0) {
                $reportDataP['failPercentage'] = round(($getSmsReportLogs['fail'] / $getSmsReportLogs['total']) * 100);
            } else {
                $reportDataP['failPercentage'] = 0;
            }
            if ($getSmsReportLogs['total'] != 0) {
                $reportDataP['totalPercentage'] = round(($getSmsReportLogs['total'] / $getSmsReportLogs['total']) * 100);
            } else {
                $getSmsReportLogs['totalPercentage'] = 0;
            }
            $smsPercentage[] = $reportDataP;
        }

        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = $enqCnt[0]->totalCount;
        $i = 0;
        $firstDateofThisMonth = !empty($filterData['fromDate']) ? date('d-m-Y', strtotime($filterData['fromDate'])) : "";
        $currentDate = !empty($filterData['toDate']) ? date('d-m-Y', strtotime($filterData['toDate'])) : "";

        if ($totalRecords != 0) {
            $result = ['success' => true, 'records' => $reportFilterData, 'logsInPercentage' => $smsPercentage, 'totalCount' => $enqCnt, 'firstDate' => $firstDateofThisMonth, 'curentDate' => $currentDate];
        } else {
            $result = ['success' => false, 'records' => $reportFilterData, 'logsInPercentage' => $smsPercentage, 'totalCount' => $enqCnt];
        }
        return json_encode($result);
    }

    public function store() {
        //
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
        //
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
