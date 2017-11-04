<?php

namespace App\Http\Controllers\backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\backend\Employee;
use DB;
use Auth;
use App\Classes\CommonFunctions;
use App\Classes\S3;
use Config;

class smsReportController extends controller {    
     public function allEmployeesMorningSmsReport() {
        /* 1)Developer : Uma Shinde (uma@nextedgegroup.co.in)
          * Details- This function is used for send short sms report to employees at 8.00 am 
        */
        //$employees = \App\Models\backend\Employee::where(['employee_status' => 1])->whereRaw('FIND_IN_SET(1,department_id)')->get();
         
        $employees = \App\Models\backend\Employee::where(['employee_status' => 1])->get();
        foreach ($employees as $employee) {
            $submenu = json_decode($employee->employee_submenus, true);
           // print_r($employee->employee_submenus);exit;
            if (isset($submenu) && in_array("0401", $submenu) == 1) {
                $todayDate = Date("Y-m-d");
                $enquiries = DB::select('CALL proc_todays_followups_test("' . $employee->id . '","0","1","","","","","0","0","","","","","","","","","","","","",0)');
                $enqCnt = DB::select("select FOUND_ROWS() totalCount");

                $pending = DB::select('CALL proc_pending_followups_test("' . $employee->id . '","0","1","","","","","0","0","","","","","","","","","","","","","",0)');
                $pendingCount = DB::select("select FOUND_ROWS() totalCount");

                $testDrives = DB::table('testdrives')
                        ->where('testdrive_date', $todayDate)
                        ->where('testdrive_by', $employee->id)
                        ->where('testdrive_status_id', 2)
                        ->select(DB::raw('count(*) as testDrive'))
                        ->get();

                $employeeName = $employee->first_name . " " . $employee->last_name;
                $Followup = $enqCnt['0']->totalCount;
                $pending = $pendingCount['0']->totalCount;
                $TestDrive = $testDrives['0']->testDrive;
                $templatedata['employee_id'] = $employee->id;
                $templatedata['client_id'] = config('global.client_id');
                $templatedata['template_setting_customer'] = 0; //50;
                $templatedata['template_setting_employee'] = 37;
                $templatedata['customer_id'] = '1';
                $templatedata['emp_sms_cc'] = 0;
//            $templatedata['customer_number'] = $employee->personal_mobile1;
                $templatedata['model_id'] = 0;
                $templatedata['sms_status'] = 1;
                $templatedata['email_status'] = 0;
                $templatedata['arrExtra'][0] = array(
                    '[#employeeName#]',
                    '[#TodayFollowupCount#]',
                    '[#pendingFollowupCount#]',
                    '[#TodaysTestDriveCount#]',
                );

                $templatedata['arrExtra'][1] = array(
                    $employeeName,
                    $Followup,
                    $pending,
                    $TestDrive,
                );
                //print_r($templatedata);
                $result = CommonFunctions::templateData($templatedata);              
            }
        }
    }

    public function allTeamLeadMorningSmsReport() {
        /* 1)Developer : Uma Shinde (uma@nextedgegroup.co.in)
          * Details- This function is used for send short sms report of his team at 8.15 am 
         */
        //$alluser = \App\Models\backend\Employee::where(['employee_status' => 1])->whereRaw('FIND_IN_SET(1,department_id)')->get();
        $alluser = \App\Models\backend\Employee::where(['employee_status' => 1])->get();
        foreach ($alluser as $user) {
            $temp = array();
            $this->allusers = array();
            $this->tuserid($user->id);
            $alt = $this->allusers;
            
            $team = implode(',', $alt);
            $todayDate = Date("Y-m-d");
            if (!empty($alt)) {
                if (!empty($team)) {
                    $enquiries = DB::select('CALL proc_todays_followups_test("' . $team . '","0","1","","","","","0","0","","","","","","","","","","","","",0)');
                    $enqCnt = DB::select("select FOUND_ROWS() totalCount");

                    $pending = DB::select('CALL proc_pending_followups_test("' . $team . '","0","1","","","","","0","0","","","","","","","","","","","","","",0)');
                    $pendingCount = DB::select("select FOUND_ROWS() totalCount");
                    
                    $testDrives = DB::table('testdrives')
                            ->where('testdrive_date', $todayDate)
                            ->where('testdrive_status_id', 2) // for  scheduled testdrive testdrive_status_id=2
                            ->whereIn('testdrive_by', array($team))
                            ->select(DB::raw('count(*) as testDrive'))
                            ->get();

                    $Followup = $enqCnt['0']->totalCount;
                    $pending = $pendingCount['0']->totalCount;
                    $TestDrive = $testDrives['0']->testDrive;
                } else {
                    $Followup = 0;
                    $pending = 0;
                    $TestDrive = 0;
                }
                $employeeName = $user->first_name . " " . $user->last_name;
                $templatedata['employee_id'] = $user->id;
                $templatedata['client_id'] = config('global.client_id');
                $templatedata['template_setting_customer'] = 0; //50;
                $templatedata['template_setting_employee'] = 38;
                $templatedata['customer_id'] = '1';
                $templatedata['emp_sms_cc'] = 0;
                //$templatedata['customer_number'] = $user->personal_mobile1;
                $templatedata['model_id'] = 0;
                $templatedata['sms_status'] = 1;
                $templatedata['email_status'] = 0;
                $templatedata['arrExtra'][0] = array(
                    '[#employeeName#]',
                    '[#TodayFollowupCount#]',
                    '[#pendingFollowupCount#]',
                    '[#TodaysTestDriveCount#]',
                );
                $templatedata['arrExtra'][1] = array(
                    $employeeName,
                    $Followup,
                    $pending,
                    $TestDrive,
                );
               // print_r($templatedata);
                $result = CommonFunctions::templateData($templatedata);
            }
        }
    }

    
    public function allEmployeesSmsReport() {       
        //$employees = \App\Models\backend\Employee::where(['employee_status' => 1])->whereRaw('FIND_IN_SET(1,department_id)')->get();
        $employees = \App\Models\backend\Employee::where(['employee_status' => 1])->get();
        foreach ($employees as $employee) {
            $user = $employee->id;
            if (!empty($employee)) {
                $submenu = json_decode($employee->employee_submenus, true);
                if (!empty($employee->employee_submenus) && in_array("0401", $submenu) == 1) {
                    $todayDate = Date("Y-m-d");
                    $newEnquiries = DB::table('enquiries')
                            ->where('sales_employee_id', $user)
                            ->where('created_date', $todayDate) // 	created_date //  sales_enquiry_date
                            ->select(DB::raw('count(id) as New'))
                            ->get();
                    //$todayfollowup = DB::select("select count(*) as cnt from enquiry_followups where next_followup_date = date(now()) AND followup_by = " . $user . " ");
                    $completedFollowups = DB::select("select count(*) as cnt from enquiry_followups where date(actual_followup_date_time) <> '0000-00-00' AND next_followup_date = date(now()) AND followup_by = " . $user . " ");
                    $pendingFollowups = DB::select("select count(*) as cnt from enquiry_followups where  date(actual_followup_date_time) = '0000-00-00' AND next_followup_date = date(now()) AND followup_by = " . $user . " ");
                    $testDrives = DB::table('testdrives')
                            ->where('testdrive_date', $todayDate)
                            ->where('testdrive_by', $user)
                            ->select(DB::raw('count(id) as testDrive'))
                            ->get();

                    $bookings = DB::table('enquiries')
                            ->where('sales_employee_id', $user)
                            ->where('sales_enquiry_date', $todayDate)
                            ->where('sales_status_id', 3)
                            ->select(DB::raw('count(id) as bookings'))
                            ->get();

                    $employeeName = $employee->first_name . " " . $employee->last_name;
                    $todaysCompletedFollowups = $completedFollowups['0']->cnt;
                    $todaysNewEnquiries = $newEnquiries['0']->New;
                    //$Followup = $todayfollowup['0']->cnt;
                    $todaysPendingFollowups = $pendingFollowups['0']->cnt;
                    $todaysTestDrive = $testDrives['0']->testDrive;
                    $todaysBookings = $bookings['0']->bookings;
                    $templatedata['employee_id'] = $employee->id;
                    $templatedata['client_id'] = config('global.client_id');
                    $templatedata['template_setting_customer'] = 0; //50;
                    $templatedata['template_setting_employee'] = 35;
                    $templatedata['customer_id'] = '1';
                    $templatedata['emp_sms_cc'] = 0;
                    $templatedata['model_id'] = 0;
                    $templatedata['sms_status'] = 1;
                    $templatedata['email_status'] = 0;
                    $templatedata['arrExtra'][0] = array(
                        '[#employeeName#]',
                        '[#TodaysNewEnquiry#]',
                        '[#TodaysCompletedFollowup#]',
                        '[#TodaysPendingFollowup#]',
                        '[#TodaysBookings#]',
                        '[#TodaysTestDrive#]',
                    );

                    $templatedata['arrExtra'][1] = array(
                        $employeeName,
                        $todaysNewEnquiries,
                        $todaysCompletedFollowups,
                        $todaysPendingFollowups,
                        $todaysBookings,
                        $todaysTestDrive,
                    );
                    //print_r($templatedata);
                    $result = CommonFunctions::templateData($templatedata);
                }
            }
        }
    }

    public function allTeamLeadSmsReport() {
        //$alluser = \App\Models\backend\Employee::select('id', 'first_name', 'last_name')->where(['employee_status' => 1])->whereRaw('FIND_IN_SET(1,department_id)')->get();
        $alluser = \App\Models\backend\Employee::select('id', 'first_name', 'last_name')->where(['employee_status' => 1])->get();
        foreach ($alluser as $user) {
            $temp = array();
            $this->allusers = array();
            $this->tuserid($user->id);
            $alt = $this->allusers;            
           
            $team = implode(',', $this->allusers);
            $todayDate = Date("Y-m-d");
            if (!empty($alt)) {
                if (!empty($team)) {
                    $new = DB::table('enquiries')
                            ->whereIn('sales_employee_id', array($team))
                            ->where('created_date', $todayDate)
                            ->select(DB::raw('count(*) as New'))
                            ->get();
                   //$todayfollowup = DB::select("select count(*) as cnt from enquiry_followups where next_followup_date = date(now()) AND followup_by IN(" . $team . ")");
                    $completeFollowup = DB::select("select count(*) as completed from enquiry_followups where date(actual_followup_date_time) <> '0000-00-00' AND next_followup_date = date(now()) AND followup_by IN(" . $team . ")");
                    $pendingFollowup = DB::select("select count(*) as pending from enquiry_followups where date(actual_followup_date_time) = '0000-00-00' AND next_followup_date = date(now()) AND followup_by IN(" . $team . ") ");

                    $testDrives = DB::table('testdrives')
                            ->where('testdrive_date', $todayDate) // testdrive_date instead created date
                            ->whereIn('testdrive_by', array($team))
                            ->where('testdrive_status_id', 2) // for  scheduled testdrive testdrive_status_id=2
                            ->select(DB::raw('count(*) as testDrive'))
                            ->get();

                    $bookings = DB::table('enquiries')
                            ->whereIn('sales_employee_id', array($team))
                            ->where('created_date', $todayDate)
                            ->where('sales_status_id', 3)
                            ->select(DB::raw('count(id) as bookings'))
                            ->get();                    
                    $todaysCompletedFollowups = $completeFollowup['0']->completed;
                    $todaysNewEnquiries = $new['0']->New;
                    $todaysPendingFollowups = $pendingFollowup['0']->pending;
                    $todaysTestDrive = $testDrives['0']->testDrive;
                    $todaysBookings = $bookings['0']->bookings;
                } else {
                    $todaysCompletedFollowups = $todaysNewEnquiries =  $todaysPendingFollowups = $todaysTestDrive = $todaysBookings = 0;
                }
                $employeeName = $user->first_name . " " . $user->last_name;
                $templatedata['employee_id'] = $user->id;
                $templatedata['client_id'] = config('global.client_id');
                $templatedata['template_setting_customer'] = 0; //50;
                $templatedata['template_setting_employee'] = 36;
                $templatedata['customer_id'] = '1';
                $templatedata['emp_sms_cc'] = 0;
                $templatedata['model_id'] = 0;
                $templatedata['sms_status'] = 1;
                $templatedata['email_status'] = 0;

                $templatedata['arrExtra'][0] = array(
                    '[#employeeName#]',
                        '[#TodaysNewEnquiry#]',
                        '[#TodaysCompletedFollowup#]',
                        '[#TodaysPendingFollowup#]',
                        '[#TodaysBookings#]',
                        '[#TodaysTestDrive#]',                    
                );
                $templatedata['arrExtra'][1] = array(
                    $employeeName,
                    $todaysNewEnquiries,
                    $todaysCompletedFollowups,
                    $todaysPendingFollowups,
                    $todaysBookings,
                    $todaysTestDrive,
                );
                //echo '<pre>';
                //print_r($templatedata);
                $result = CommonFunctions::templateData($templatedata);
            }
        }
    }
    
    
    public function testdriveAlert(){
        $date = date('Y-m-d');
        $h = date('H:i:s');
        $cenvertedTime = date('H:i:s',strtotime('+2 hour'));

        
        $gettodaysTestdrive = \App\Models\Testdrive::where(['testdrive_status_id' => 2,'testdrive_date' => $date])
                                                    ->whereBetween('testdrive_time', array($h,$cenvertedTime))->get();
        if(!empty($gettodaysTestdrive)){
            foreach($gettodaysTestdrive as $todaysTestdrive){
                $testvehicle = \App\Models\TestdriveVehicle::where('id', $todaysTestdrive->testdrive_vehicle_ids)->first();
                $custEnquiry = \App\Modules\MasterSales\Models\Enquiry::where('id',$todaysTestdrive->enquiry_id)->first();
                $enquiry_id = $custEnquiry->id;
                $customer_id = $custEnquiry->customer_id;
                $model_id = $testvehicle->model_id;
                $client_location = \App\Models\ClientLocation::where('id', 1)->first();

                if ($todaysTestdrive->testdrive_type == 2) {
                    $location = $todaysTestdrive->area;
                } else {
                    $location = $client_location->google_map;
                }
                
                $server_url1 = $_SERVER['HTTP_HOST'] . '/website/confirmtestdrive/' . base64_encode($enquiry_id);
                //$return_val1 = $this->shortenUrl($server_url1);
                //$short_url_result1 = $return_val1['id'];
                
                $server_url2 = $_SERVER['HTTP_HOST'] . '/website/scheduletestdriveform/' . base64_encode($enquiry_id);
                //$return_val2 = $this->shortenUrl($server_url2);
                //$short_url_result2 = $return_val2['id'];
                
                $server_url3 = $_SERVER['HTTP_HOST'] . '/website/canceltestdriveform/' . base64_encode($enquiry_id);
                //$return_val3 = $this->shortenUrl($server_url3);
                //$short_url_result3 = $return_val3['id'];
                
                //data for  enquiry_followups table
                //template for new enquiry..
                $templatedata['employee_id'] = $custEnquiry->sales_employee_id;
                $templatedata['client_id'] = config('global.client_id');
                $templatedata['template_setting_customer'] = 48;
                $templatedata['template_setting_employee'] = 49;

                $templatedata['customer_id'] = $customer_id;
                $templatedata['model_id'] = $model_id;
                $templatedata['arrExtra'][0] = array(
                    '[#testvehicleName#]',
                    '[#appointmentDate#]',
                    '[#confirmUrl#]',
                    '[#rescheduleUrl#]',
                    '[#cancelUrl#]',
                    '[#location#]'
                );
                $templatedata['arrExtra'][1] = array(
                    $testvehicle->friendly_name,
                    date('d-m-Y', strtotime($todaysTestdrive->testdrive_date)) . ' @ ' . date('h:i A', strtotime($todaysTestdrive->testdrive_time)),
                    $server_url1,
                    $server_url2,
                    $server_url3,
                    $location
                );

                $result = CommonFunctions::templateData($templatedata);
            }
        }
        echo "Alert send successfully...";
        exit;
            //$result = ["success" => true, 'message' => 'Alert send succesfully.'];
            //echo json_encode($result);
       // print_r($gettodaysTestdrive);exit;
        
    }
    
    
    
    public function testdriveStatusChange(){
        $date = date('Y-m-d');
        $h = "08:00:00";
        $cenvertedTime = date('H:i:s');
        $flag = 0;
        
        $getoldTestdrives = \App\Models\Testdrive::select('id','testdrive_status_id','testdrive_date','testdrive_time')->where(['testdrive_status_id' => 2])
                                                    ->where('testdrive_date', '<', $date)->get();
        
        if(!empty($getoldTestdrives)){
            foreach($getoldTestdrives as $getoldTestdrive){
                $getoldTestdrive->testdrive_status_id = 5;
                $getoldTestdrive->save();
            $flag = 1;
        }
            
        }
        $gettodayTestdrives = \App\Models\Testdrive::select('id','testdrive_status_id','testdrive_date','testdrive_time')->where(['testdrive_status_id' => 2])
                                                    ->where('testdrive_date', '=', $date)
                                                    ->whereBetween('testdrive_time', array($h,$cenvertedTime))->get();
        
        if(!empty($gettodayTestdrives)){
            foreach($gettodayTestdrives as $gettodayTestdrive){
                $gettodayTestdrive->testdrive_status_id = 5;
                $gettodayTestdrive->save();
            $flag = 1;
        }
            
        }
        if($flag == 1){
            echo "Status updated successfully";
        }else{
            echo "No record found";
        }
        
    }



    public function tuserid($id) {
        $admin = \App\Models\backend\Employee::select('id','employee_submenus')->where('employee_submenus','like','%"0401"%')->where(['team_lead_id' => $id])->get();
        //$admin = \App\Models\backend\Employee::select('id','employee_submenus')->where(['team_lead_id' => $id, 'employee_status' => '1'])
        //        ->where('employee_submenus','like','%:"0401"%')->whereRaw('FIND_IN_SET(1,department_id)')->get();
        if (!empty($admin)) {
            foreach ($admin as $item) {
                $this->allusers[$item->id] = $item->id;
                $this->tuserid($item->id);
            }
        } else {
            return;
        }
    }
    
    public function shortenUrl($longUrl) {
        $data = array('longUrl' => $longUrl);
        $data_string = json_encode($data);
        $ch = @curl_init('https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyBC0YOgQJFeoD1m4eFJj-rEggFksB7HW4M');
        @curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data_string))
        );
        $result = @curl_exec($ch);
        return json_decode($result, true);
    }
}
?>