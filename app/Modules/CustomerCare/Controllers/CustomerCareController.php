<?php

namespace App\Modules\CustomerCare\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\MasterSales\Models\Enquiry;
use App\Modules\MasterSales\Models\EnquiryDetail;
use App\Models\CcPresalesFollowup;
use App\Classes\CommonFunctions;
use App\Models\backend\Employee;
use Auth;
use DB;

class CustomerCareController extends Controller {

    public static $procname;

    public function __construct() {
        $this->middleware('web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view("CustomerCare::index");
    }

    /* customer care pre sales modules */

    public function viewpresalesTotal($type) {
        return view("CustomerCare::presales.total")->with("type", $type);
    }

    public function getpresalesTotal() {
        /* param
         * type =  0 my and type =1 Team
         * type
         * empId
         * pageNumber
         * itemPerPage
         */

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $date = date('y-m-d');
        $this->allusers = array();
        if ($request['type'] == 0) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['empId'];
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_total";
                    return $this->ccfilter();
                    exit;
                }
            }
            $loggedInUserId = $loggedInUserId . ",0";
        } else if ($request['type'] == 1) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
                $loggedInUserId = $loggedInUserId . ',0';
            } else {
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_total";
                    return $this->ccfilter();
                    exit;
                } else {
                    $loggedInUserId = $request['empId'];
                    $this->tuserid($loggedInUserId);
                    $alluser = $this->allusers;
                    $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
                }
            }
        }


        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        $enquiries = DB::select('CALL proc_cc_presales_total("' . $loggedInUserId . '",' . $startFrom . ',' . $request['itemPerPage'] . ',"","","","","0","0","","","","","","","","","","")');
        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = json_decode(json_encode($enqCnt), true);

        if (!empty($enquiries)) {
            $result = ['success' => true, 'records' => $enquiries, 'totalCount' => $enqCnt[0]['totalCount']];
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    public function viewpresalesCompleted($type) {
        return view("CustomerCare::presales.completed")->with("type", $type);
    }

    public function getpresalesCompleted() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $date = date('y-m-d');
        if ($request['type'] == 0) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['empId'];
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_complete";
                    return $this->ccfilter();
                    exit;
                }
            }
        } else if ($request['type'] == 1) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
            } else {
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_complete";
                    return $this->ccfilter();
                    exit;
                } else {
                    $loggedInUserId = $request['empId'];
                    $this->tuserid($loggedInUserId);
                    $alluser = $this->allusers;
                    $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
                }
            }
        }
        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        $enquiries = DB::select('CALL proc_cc_presales_complete("' . $loggedInUserId . '",' . $startFrom . ',' . $request['itemPerPage'] . ',"","","","","0","0","","","","","","","","","")');
        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = json_decode(json_encode($enqCnt), true);

        if (!empty($enquiries)) {
            $result = ['success' => true, 'records' => $enquiries, 'totalCount' => $enqCnt[0]['totalCount']];
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    public function viewpresalesPrevious($type) {
        return view("CustomerCare::presales.previous")->with("type", $type);
    }

    public function getpresalesPrevious() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $date = date('y-m-d');

        if ($request['type'] == 0) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['empId'];
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_previous";
                    return $this->ccfilter();
                    exit;
                }
            }
        } else if ($request['type'] == 1) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
            } else {
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_previous";
                    return $this->ccfilter();
                    exit;
                } else {
                    $loggedInUserId = $request['empId'];
                    $this->tuserid($loggedInUserId);
                    $alluser = $this->allusers;
                    $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
                }
            }
        }


        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        $enquiries = DB::select('CALL proc_cc_presales_previous("' . $loggedInUserId . '",' . $startFrom . ',' . $request['itemPerPage'] . ',"","","","","0","0","","","","","","","","","")');
        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = json_decode(json_encode($enqCnt), true);

        if (!empty($enquiries)) {
            $result = ['success' => true, 'records' => $enquiries, 'totalCount' => $enqCnt[0]['totalCount']];
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    public function getpresalesToday() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $date = date('y-m-d');

        if ($request['type'] == 0) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['empId'];
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_today";
                    return $this->ccfilter();
                    exit;
                }
            }
        } else if ($request['type'] == 1) {


            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
            } else {
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_today";
                    return $this->ccfilter();
                    exit;
                } else {
                    $loggedInUserId = $request['empId'];
                    $this->tuserid($loggedInUserId);
                    $alluser = $this->allusers;
                    $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
                }
            }
        }

        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        
        $enquiries = DB::select('CALL proc_cc_presales_today("' . $loggedInUserId . '",' . $startFrom . ',' . $request['itemPerPage'] . ',"","","","","0","0","","","","","","","","","")');
        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = json_decode(json_encode($enqCnt), true);

        if (!empty($enquiries)) {
            $i = 0;
//            foreach ($enquiries as $enquiry) {
//                if ($enquiry->test_drive_given == 1) {
//                    $scheduled_test_drive = \App\Models\Testdrive::select(DB::raw('DATE_FORMAT(testdrive_date, "%d-%m-%Y") as testdrive_date'), DB::raw('DATE_FORMAT(testdrive_time, "%h:%i %p") as testdrive_time'), DB::raw('address as test_drive_address'))->where(['enquiry_id' => $enquiry->id, 'testdrive_status_id' => 1])->orderBy('id', 'DESC')->first();
//                    $enquiries[$i]->testdrive_details = $scheduled_test_drive;
//                }
//                $i++;
//            }
            $result = ['success' => true, 'records' => $enquiries, 'totalCount' => $enqCnt[0]['totalCount']];
        } else {
            $result = ['success' => false];
        }
        return json_encode($result);
    }

    public function viewpresalesToday($type) {
        return view("CustomerCare::presales.today")->with("type", $type);
    }

    public function viewpresalesPending($type) {
        return view("CustomerCare::presales.pending")->with("type", $type);
    }

    public function getpresalesPending() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $date = date('y-m-d');
        if ($request['type'] == 0) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
            } else {
                $loggedInUserId = $request['empId'];
                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_pending";
                    return $this->ccfilter();
                    exit;
                }
            }
        } else if ($request['type'] == 1) {
            if (empty($request['empId'])) {
                $loggedInUserId = Auth::guard('admin')->user()->id;
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
            } else {

                if ($request['filterFlag'] == 1) {
                    CustomerCareController::$procname = "proc_cc_presales_pending";
                    return $this->ccfilter();
                    exit;
                } else {
                    $loggedInUserId = $request['empId'];
                    $this->tuserid($loggedInUserId);
                    $alluser = $this->allusers;
                    $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : 0;
                }
            }
        }

        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        $enquiries = DB::select('CALL proc_cc_presales_pending("' . $loggedInUserId . '",' . $startFrom . ',' . $request['itemPerPage'] . ',"","","","","0","0","","","","","","","","","")');
        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = json_decode(json_encode($enqCnt), true);

        if (!empty($enquiries)) {
            $result = ['success' => true, 'records' => $enquiries, 'totalCount' => $enqCnt[0]['totalCount']];
        } else {
            $result = ['success' => false, 'message' => 'No Records Founds'];
        }
        return json_encode($result);
    }

    public static function array_sort_by_column($array, $column, $direction = SORT_DESC) {
        $reference_array = array();
        foreach ($array as $key => $row) {
            $reference_array[$key] = strtotime($row[$column]);
        }
        array_multisort($reference_array, $direction, $array);
        //sprint_r($reference_array);

        return $reference_array;
    }

    public function getEnquiryHistory() {
        $postdata = file_get_contents("php://input");
        $input = json_decode($postdata, true);
        $enquiryId = $input['enquiryId'];
        $modules = $input['moduelswisehisory'];
        $cc_followup_history = array();
        /*
         * 1 = Sales Followup
         * 2 = Customer Care Follouwp
         * 
         */
       
        if (in_array(2, $modules)) {
            $cc_followup_history = DB::table('cc_presales_followups as ccf')
                    ->leftjoin('employees as e', 'e.id', '=', 'ccf.followup_by')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_cc_presales_status as mlps', 'mlps.id', '=', 'ccf.cc_presales_status_id')
                    ->leftjoin('cc_presales_substatus as ccpsubs', 'ccpsubs.id', '=', 'ccf.cc_presales_substatus_id')
                    ->select('ccf.*', DB::raw('DATE_FORMAT(ccf.followup_date_time, "%d-%m-%Y \n@ %h:%i %p") as last_followup_date'), DB::raw('DATE_FORMAT(ccf.next_followup_date, "%d-%m-%Y") as next_followup_date'), DB::raw('DATE_FORMAT(ccf.next_followup_time, "%h:%i %p") as next_followup_time'), 'e.first_name', 'e.last_name', 'mlps.cc_presales_status', 'ccpsubs.cc_presales_substatus')
                    ->where('ccf.enquiry_id', $enquiryId)
                    ->orderBy('ccf.id', 'DESC')
                    ->get();
        }
        $enqiry_followup_history = array();
        if (in_array(1, $modules)) {
            $enqiry_followup_history = DB::table('enquiry_followups as ef')
                    ->leftjoin('employees as e', 'e.id', '=', 'ef.followup_by_employee_id')
                    ->leftjoin('laravel_developement_master_edynamics.mlst_enquiry_sales_statuses as mess', 'mess.id', '=', 'ef.sales_status_id')
                    ->leftjoin('enquiry_sales_substatuses as ess', 'ess.id', '=', 'ef.sales_substatus_id')
                    ->select('ef.*', DB::raw('DATE_FORMAT(ef.followup_date_time, "%d-%m-%Y \n@ %h:%i %p") as last_followup_date'), DB::raw('DATE_FORMAT(ef.next_followup_date, "%d-%m-%Y") as next_followup_date'), DB::raw('DATE_FORMAT(ef.next_followup_time, "%h:%i %p") as next_followup_time'), 'e.first_name', 'e.last_name', 'mess.sales_status', 'ess.enquiry_sales_substatus')
                    ->where('ef.enquiry_id', $enquiryId)
                    ->orderBy('ef.id', 'DESC')
                    ->get();
        }
        $enqiry_followup_history = json_decode(json_encode($enqiry_followup_history), True);
        if (!empty($enqiry_followup_history)) {
            $enq_cnt = count($enqiry_followup_history);
            for ($r = 0; $r < $enq_cnt; $r++) {
                $enqiry_followup_history[$r]['short_name'] = 'PS';
            }
        }

        $cc_followup_history = json_decode(json_encode($cc_followup_history), True);
        if (!empty($cc_followup_history)) {
            $cc_cnt = count($cc_followup_history);
            for ($r = 0; $r < $cc_cnt; $r++) {
                $cc_followup_history[$r]['short_name'] = 'CC';
            }
        }

        $all_history_Merge = @array_merge($cc_followup_history, $enqiry_followup_history);
        $temp_history = array();
        if (!empty($all_history_Merge)) {
            foreach ($all_history_Merge as $obj_merge) {
                $temp_history[strtotime($obj_merge['followup_date_time'])] = $obj_merge;
            }
        }
        $sorted_key = $this->array_sort_by_column($temp_history, 'followup_date_time');
        $all_followup_history = array();
        $i = 0;
        $k = 1;

        foreach ($sorted_key as $key) {
            $url = '';
            $all_followup_history[$i] = $temp_history[$key];

            if ($all_followup_history[$i]['call_recording_log_type'] == 1) {

                if (!empty($all_followup_history[$i]['call_recording_id']) && $all_followup_history[$i]['call_recording_id'] != 0) {
                    $cloudurlquery = \App\Models\CtLogsInbound::where(['id' => $all_followup_history[$i]['call_recording_id']])->first();
                    $arrs = explode('&', $cloudurlquery->call_log_push_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                }
            } elseif ($all_followup_history[$i]['call_recording_log_type'] == 2) {
                $cloudurlquery = \App\Models\CtLogsOutbound::where(['id' => $all_followup_history[$i]['call_recording_id']])->first();
                $arrs = explode('&', $cloudurlquery->call_log_push_url);
                foreach ($arrs as $arr => $value) {
                    $dada = explode('=', $value);
                    if ($dada[0] == 'recording_url' && $dada[1] != '') {
                        $url = $dada[1];
                    }
                }
            }

            if (empty($all_followup_history[$i]['updated_by']) && $all_followup_history[$i]['short_name'] == 'PS' && $k == 1) {
                $all_followup_history[$i]['editFlag'] = 1;
                $k++;
            } else if ($all_followup_history[$i]['short_name'] == 'PS') {
                $k++;
            }

            $all_followup_history[$i]['call_recording_url'] = $url;
            $i++;
        }

        if ($all_followup_history) {
            $result = ['success' => true, 'records' => $all_followup_history];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'records' => $all_followup_history];
            return json_encode($result);
        }
    }

    /* today remark changes */

    public function getPresalesTodayremarksEnquiry() {
        try {
            $postdata = file_get_contents("php://input");
            $input = json_decode($postdata, true);
            $enquiryId = $input['enquiryId'];


            $emailId = $mobileNumber = array();
            $getRemarkDetails = DB::select('CALL proc_cc_presales_get_today_remark(' . $enquiryId . ')');
            $decodeRemarkDetails = json_decode(json_encode($getRemarkDetails), true);
            if (!empty($decodeRemarkDetails[0]['customer_mobile_no'])) {
                $mobileNumber = explode(",", $decodeRemarkDetails[0]['customer_mobile_no']);
                $mobileNumber = array_unique($mobileNumber);
            }
            if (!empty($decodeRemarkDetails[0]['customer_email_id'])) {
                $emailId = explode(",", $decodeRemarkDetails[0]['customer_email_id']);
                $emailId = array_values(array_filter($emailId));
                $emailId = array_unique($emailId);
            }

            if (!empty($input['emp_id'])) {

                $employee = Employee::where('id', $input['emp_id'])->first();
                $array = json_decode($employee->employee_submenus, true);
                if (!empty($employee->office_mobile_no)) {
                    $loginmobile = $employee->office_mobile_no;
                } else {
                    $loginmobile = $employee->personal_mobile1;
                }

                $client_id = $employee->client_id;
                $login_user_id = $employee->id;

                if (in_array('01602', $array)) {
                    $contact_permission = 1;
                } else {
                    $contact_permission = 0;
                }
                if (in_array('01601', $array)) {
                    $email_permission = 1;
                } else {
                    $email_permission = 0;
                }

                if (!empty($employee->office_email_id))
                    $useremail = $employee->office_email_id;
                else
                    $useremail = $employee->personal_email1;
            }
            else {
                $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
                if (!empty(Auth::guard('admin')->user()->office_mobile_no)) {
                    $loginmobile = Auth::guard('admin')->user()->office_mobile_no;
                } else {
                    $loginmobile = Auth::guard('admin')->user()->personal_mobile1;
                }

                $client_id = Auth::guard('admin')->user()->client_id;
                $login_user_id = Auth::guard('admin')->user()->id;
                if (in_array('01602', $array)) {
                    $contact_permission = 1;
                } else {
                    $contact_permission = 0;
                }
                if (in_array('01601', $array)) {
                    $email_permission = 1;
                } else {
                    $email_permission = 0;
                }

                if (!empty(Auth::guard('admin')->user()->office_email_id))
                    $useremail = Auth::guard('admin')->user()->office_email_id;
                else
                    $useremail = Auth::guard('admin')->user()->personal_email1;
            }

            $decodeRemarkDetails['mobileNumber'] = $mobileNumber;
            $decodeRemarkDetails['emailId'] = $emailId;
            //
            $reassignData['id'] = $decodeRemarkDetails[0]['sales_employee_id'];
            $reassignData['first_name'] = $decodeRemarkDetails[0]['first_name'] . " " . $decodeRemarkDetails[0]['last_name'];
            $result = ['success' => true, 'enquiryDetails' => $decodeRemarkDetails, 'useremail' => $useremail,
                "reassignData" => $reassignData, 'contact_permission' => $contact_permission, 'email_permission' => $email_permission,
                'client_id' => $client_id, 'login_user_id' => $login_user_id, 'loginmobile' => $loginmobile
            ];
        } catch (\Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return json_encode($result);
    }

    public function insertCcPreSalesRemark() {
        try {
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata, true);
            $request = $request['data'];

            if (!empty($request['loggedInUserId'])) {
                $loggedInUserId = $request['loggedInUserId'];
                if (!empty($request['cc_presales_employee_id'])) {

                    $cc_presales_employee_id = $request['cc_presales_employee_id'];
                } else {
                    $cc_presales_employee_id = $request['loggedInUserId'];
                }
            } else {
                $loggedInUserId = Auth::guard('admin')->user()->id;
                if (!empty($request['cc_presales_employee_id']))
                    $cc_presales_employee_id = $request['cc_presales_employee_id'];
                else
                    $cc_presales_employee_id = Auth::guard('admin')->user()->id;
            }

            $cc_presales_category_id = !empty($request['cc_presales_category_id']) ? $request['cc_presales_category_id'] : "0";
            $cc_presales_subcategory_id = !empty($request['cc_presales_subcategory_id']) ? $request['cc_presales_subcategory_id'] : "0";
            $cc_presales_status_id = !empty($request['cc_presales_status_id']) ? $request['cc_presales_status_id'] : "0";
            $cc_presales_substatus_id = !empty($request['cc_presales_substatus_id']) ? $request['cc_presales_substatus_id'] : "0";
            $enquiry_id = $request['enquiryId'];

            $enqUpdate = Enquiry::where('id', $enquiry_id)
                    ->update([
                "cc_presales_category_id" => $cc_presales_category_id,
                "cc_presales_subcategory_id" => $cc_presales_subcategory_id,
                "cc_presales_status_id" => $cc_presales_status_id,
                "cc_presales_substatus_id" => $cc_presales_substatus_id,
                "cc_presales_employee_id" => $cc_presales_employee_id
            ]);

            if ($cc_presales_status_id == 2) {
                $request['next_followup_date'] = "0000-00-00";
                $request['next_followup_time'] = "00:00:00";
            } else {
                $request['next_followup_date'] = date('Y-m-d', strtotime($request['next_followup_date']));
                $request['next_followup_time'] = date('H:i:s', strtotime($request['next_followup_time']));
            }

            $request['followup_date_time'] = date('Y-m-d H:i:s');
            $request['followup_by'] = $loggedInUserId;
            $request['remarks'] = $request['textRemark'];
            $request['followup_entered_through'] = 1;
            $request['actual_followup_date_time'] = '0000-00-00 00:00:00';
            $request['cc_presales_category_id'] = $cc_presales_category_id;
            $request['cc_presales_subcategory_id'] = $cc_presales_subcategory_id;
            $request['cc_presales_status_id'] = $cc_presales_status_id;
            $request['cc_presales_substatus_id'] = $cc_presales_substatus_id;
            $request['enquiry_id'] = $enquiry_id;
            $request['call_recording_log_type'] = 0;
            $request['call_recording_id'] = 0;
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $request = array_merge($request, $create);

            $insertFollowup = CcPresalesFollowup::create($request);
            if ($insertFollowup) {
                $result = ['success' => true, 'message' => 'Remark inserted successfully'];
            } else {
                $result = ['success' => false, 'message' => 'Remark not inserted. Please try again'];
            }
        } catch (Exception $ex) {
            $result = ["success" => false, "status" => 412, "message" => $ex->getMessage()];
        }
        return response()->json($result);
    }

    public function tuserid($id) {
        $admin = \App\Models\backend\Employee::where(['team_lead_id' => $id])->get();
        if (!empty($admin)) {

            foreach ($admin as $item) {

                $this->allusers[$item->id] = $item->id;

                $this->tuserid($item->id);
            }
        } else {
            return;
        }
    }

    public function ccfilter() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $filter = array();
        if (!empty($request['filter']))
            $filter = $request['filter'];



        if (empty($request['empId'])) {
            $loggedInUserId = Auth::guard('admin')->user()->id . ',0';
        } else {
            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
            $loggedInUserId = $request['empId'] . ',0';
            $request["getProcName"] = CustomerCareController::$procname;
        }
        if (isset($filter['employee_id']) && !empty($filter['employee_id'])) {
            $loggedInUserId = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $filter['employee_id']));
        } else if ($request['type'] == 1) {
            $this->tuserid($loggedInUserId);
            $alluser = $this->allusers;
            $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;
            $loggedInUserId = $loggedInUserId . ',0';
        }

        if (!empty($filter["cc_presales_status_id"])) {
            $cc_presales_status_id = explode("_", $filter["cc_presales_status_id"]);
            $filter["cc_presales_status_id"] = $cc_presales_status_id[0];
        } else {
            $filter["cc_presales_status_id"] = "";
        }

        if (!empty($filter["cc_presales_category_id"])) {
            $cc_presales_category_id = explode("_", $filter["cc_presales_category_id"]);
            $filter["cc_presales_category_id"] = $cc_presales_category_id[0];
        } else {
            $filter["cc_presales_category_id"] = "";
        }

        if (!empty($filter["source_id"])) {
            $source_id = explode("_", $filter["source_id"]);
            $filter["source_id"] = $source_id[0];
        } else {
            $filter["source_id"] = "";
        }
        
        $filter["fname"] = !empty($filter['fname']) ? $filter['fname'] : "";
        $filter["lname"] = !empty($filter['lname']) ? $filter['lname'] : "";
        $filter["company_name"] = !empty($filter['company_name']) ? $filter['company_name'] : "";
        $filter["emailId"] = !empty($filter['emailId']) ? $filter['emailId'] : "";
        $filter["mobileNumber"] = !empty($filter['mobileNumber']) ? $filter['mobileNumber'] : "";
        $filter["verifiedMobNo"] = !empty($filter['verifiedMobNo']) ? $filter['verifiedMobNo'] : "0";
        $filter["verifiedEmailId"] = !empty($filter['verifiedEmailId']) ? $filter['verifiedEmailId'] : "0";
        $filter["fromDate"] = !empty($filter['fromDate']) ? date('Y-m-d', strtotime($filter['fromDate'])) : "";
        $filter["toDate"] = !empty($filter['toDate']) ? date('Y-m-d', strtotime($filter['toDate'])) : "";
        $filter["cc_presales_substatus_id"] = !empty($filter['cc_presales_substatus_id']) ? implode(',', array_column($filter['cc_presales_substatus_id'], 'id')) : "";
        $filter["cc_presales_subcategory_id"] = !empty($filter['cc_presales_subcategory_id']) ? implode(',', array_column($filter['cc_presales_subcategory_id'], 'id')) : "";
        $filter["project_id"] = !empty($filter['project_id']) ? implode(',', array_column($filter['project_id'], 'id')) : "";
        $filter["subsource_id"] = !empty($filter['subsource_id']) ? implode(',', array_column($filter['subsource_id'], 'id')) : "";
        $filter["site_visit"] = !empty($filter['site_visit']) ? $filter['site_visit'] : "";
        $enquiries = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '",' . $request['pageNumber'] . ','
                        . $request['itemPerPage'] . ',"' . $filter["fname"] . '","' . $filter["lname"] . '","'
                        . $filter["mobileNumber"] . '","' . $filter["emailId"] . '","' . $filter["verifiedMobNo"] . '","'
                        . $filter["verifiedEmailId"] . '","' . $filter["cc_presales_category_id"] . '","' . $filter['cc_presales_subcategory_id'] . '","'
                        . $filter["source_id"] . '","' . $filter["subsource_id"] . '","'
                        . $filter["fromDate"] . '","' . $filter["toDate"] . '","' . $filter["site_visit"] . '","'
                        . $filter["cc_presales_status_id"] . '","' . $filter["cc_presales_substatus_id"] .
                        '")'
        );
        $enqCnt = DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = json_decode(json_encode($enqCnt), true);

        $enquiries = json_decode(json_encode($enquiries), true);
        if (count($enquiries) != 0) {
            $result = ['success' => true, 'records' => $enquiries, 'totalCount' => $enqCnt[0]['totalCount']];
        } else {
            $result = ['success' => false, 'records' => 'No Records Found'];
        }
        return response()->json($result);
    }

}
