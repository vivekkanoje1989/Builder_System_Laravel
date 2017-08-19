<?php

namespace App\Modules\Reports\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Reports\Models\Enquiry;
use App\Modules\Reports\Models\EnquiryDetail;
use App\Modules\Reports\Models\EnquiryFollowup;
use App\Modules\Projects\Models\Project;
use App\Modules\Projects\Models\MlstBmscEnquirySalesSources;
use DB;
use Auth;

class ReportsController extends Controller {

    public function __construct() {
        $this->middleware('web');
    }

    public function getEnquiryReport() {
        return view("Reports::enquiryReport")->with("loggedInUserID", Auth::guard('admin')->user()->id);
    }

    public function myfollowupsreport() {
        return view("Reports::myfollowupsreport");
    }

    public function getCategoryReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $response = array();
        $condition = '';
        $employee_id = $request["employee_id"];
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            //print_r($request);exit;
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(e.sales_enquiry_date BETWEEN '$from_date' AND '$to_date')";
        }

        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }

        //$category_wise_report = "SELECT count(*) as cnt, eqty.enquiry_category FROM lmsauto_client_final.enquiries e INNER JOIN lmsauto_master_final.mlst_enquiry_sales_categories as eqty ON e.`sales_category_id` = eqty.id WHERE e.`sales_status_id`IN(1,2) AND e.`sales_employee_id` = $employee_id AND $condition GROUP BY e.`sales_category_id`";
        $category_wise_report = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id WHERE e.sales_status_id IN(1,2) AND e.sales_employee_id = $employee_id AND $condition GROUP BY e.sales_category_id";
        $category_wise_report = DB::select($category_wise_report);
        $category_wise_total = array();
        $cold_count = 0;
        $hot_count = 0;
        $warm_count = 0;
        $m_new_count = 0;
        $total = 0;
        if (!empty($category_wise_report)) {
            foreach ($category_wise_report as $result_enquiry_type) {
                $enqtype = $result_enquiry_type->enquiry_category;
                if ($enqtype == "Cold") {
                    $cold_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "Hot") {
                    $hot_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "Warm") {
                    $warm_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "New Enquiry") {
                    $m_new_count = $result_enquiry_type->cnt;
                }
                $total = $cold_count + $hot_count + $warm_count + $m_new_count;
            }
        }
        $category_wise_total[] = array('New' => $m_new_count, 'Hot' => $hot_count, 'Warm' => $warm_count, 'Cold' => $cold_count, 'Total' => $total);
        if (!empty($category_wise_total)) {
            $result = ['success' => true, 'records' => $category_wise_total];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getStatusReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $status_wise_total = array();
        $condition = '';
        $employee_id = $request["employee_id"];
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(laravel_developement_builder_client.enquiries.sales_enquiry_date BETWEEN '$from_date' AND '$to_date')";
        }

        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }
        //$status_wise_query = "SELECT count(*) as cnt,laravel_developement_master_edynamics.mlst_enquiry_sales_statuses.sales_status FROM laravel_developement_builder_client.enquiries INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_statuses ON laravel_developement_master_edynamics.mlst_enquiry_sales_statuses.id = laravel_developement_builder_client.enquiries.`sales_status_id` where laravel_developement_builder_client.enquiries.`sales_employee_id` = '$employee_id' AND '$condition' GROUP BY laravel_developement_builder_client.enquiries.`sales_status_id`";
        $status_wise_query = "SELECT count(*) as cnt,laravel_developement_master_edynamics.mlst_enquiry_sales_statuses.sales_status FROM laravel_developement_builder_client.enquiries INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_statuses ON  laravel_developement_master_edynamics.mlst_enquiry_sales_statuses.id = laravel_developement_builder_client.enquiries.sales_status_id where laravel_developement_builder_client.enquiries.sales_employee_id = $employee_id AND $condition  GROUP BY laravel_developement_builder_client.enquiries.sales_status_id";
        $status_wise_query = DB::select($status_wise_query);
        $m_new_count = 0;
        $open_count = 0;
        $booked_count = 0;
        $lost_count = 0;
        $total = 0;
        if (!empty($status_wise_query)) {
            foreach ($status_wise_query as $row) {
                $status = $row->sales_status;
                if ($status == "Open") {
                    $open_count = $row->cnt;
                } else if ($status == "Booked") {
                    $booked_count = $row->cnt;
                } else if ($status == "Lost") {
                    $lost_count = $row->cnt;
                } else if ($status == "New Enquiry") {
                    $m_new_count = $row->cnt;
                }
                $total = $open_count + $booked_count + $lost_count + $m_new_count;
            }
        }
        $status_wise_total[] = array('New' => $m_new_count, 'Open' => $open_count, 'Booked' => $booked_count, 'Lost' => $lost_count, 'Total' => $total);

        if (!empty($status_wise_total)) {
            $result = ['success' => true, 'records' => $status_wise_total];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getProjectWiseCategoryReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $response = array();
        $condition = '';
        $employee_id = $request["employee_id"];
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            //print_r($request);exit;
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(enquiries.sales_enquiry_date BETWEEN '$from_date' AND '$to_date')";
        }

        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }
        //$category_wise_report = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id WHERE e.sales_status_id IN(1,2) AND e.sales_employee_id = $employee_id AND $condition GROUP BY e.sales_category_id";
        $category_wise_report = "SELECT enquiry.enquiry_category,enquiry.id FROM laravel_developement_master_edynamics.mlst_enquiry_sales_categories as enquiry";
        $category_wise_report = DB::select($category_wise_report);

        $temp_array = array();
        $Total = 0;
        foreach ($category_wise_report as $sources) {
            $report = "SELECT  count(*) as cnt from enquiries INNER JOIN enquiry_details ON enquiry_details.enquiry_id = enquiries.id  where sales_category_id = $sources->id AND enquiry_details.project_id =" . $request['project_id'] . " AND $condition";
            $category = DB::select($report);


            $enquiry_category = str_replace(' ', '_', $sources->enquiry_category);
            //$sales_source_name = $sources->sales_source_name;

            $post = array($enquiry_category => $category['0']->cnt);
            $temp_array = array_merge($post, $temp_array);
            $Total = $Total + $category['0']->cnt;
        }
        $response['0'] = $temp_array;
        if (!empty($response)) {
            $result = ['success' => true, 'records' => $response, 'Total' => $Total];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getProjectWiseStatusReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $response = array();
        $condition = '';
        $employee_id = $request["employee_id"];
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            //print_r($request);exit;
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(enquiries.sales_enquiry_date BETWEEN '$from_date' AND '$to_date')";
        }

        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }
        //$category_wise_report = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id WHERE e.sales_status_id IN(1,2) AND e.sales_employee_id = $employee_id AND $condition GROUP BY e.sales_category_id";
        $status_wise_report = "SELECT enquiry.sales_status,enquiry.id FROM laravel_developement_master_edynamics.mlst_enquiry_sales_statuses as enquiry";
        $status_wise_report = DB::select($status_wise_report);

        $temp_array = array();
        $Total = 0;
        foreach ($status_wise_report as $status) {
            $salesStatus = $status->sales_status;
            $report = "SELECT  count(*) as cnt from enquiries INNER JOIN enquiry_details ON enquiry_details.enquiry_id = enquiries.id  where sales_status_id = $status->id AND enquiry_details.project_id = $request[project_id] AND $condition";
            $status = DB::select($report);
            $enquiry_status = str_replace(' ', '_', $salesStatus);
            //$sales_source_name = $sources->sales_source_name;

            $post = array($enquiry_status => $status['0']->cnt);
            $temp_array = array_merge($post, $temp_array);
            $Total = $Total + $status['0']->cnt;
        }
        $response['0'] = $temp_array;
        if (!empty($response)) {
            $result = ['success' => true, 'records' => $response, 'Total' => $Total];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getProjectWiseSourceReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $response = array();
        $condition = '';
        $employee_id = $request["employee_id"];
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            //print_r($request);exit;
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(enquiries.sales_enquiry_date BETWEEN '$from_date' AND '$to_date')";
        }

        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }
        //$category_wise_report = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id WHERE e.sales_status_id IN(1,2) AND e.sales_employee_id = $employee_id AND $condition GROUP BY e.sales_category_id";
        $source_wise_report = "SELECT enquiry.sales_source_name,enquiry.id FROM laravel_developement_master_edynamics.mlst_bmsb_enquiry_sales_sources as enquiry";
        $source_wise_report = DB::select($source_wise_report);

        $temp_array = array();
        $Total = 0;
        foreach ($source_wise_report as $source) {
            $salesSource = $source->sales_source_name;
            $report = "SELECT  count(*) as cnt from enquiries INNER JOIN enquiry_details ON enquiry_details.enquiry_id = enquiries.id  where sales_source_id = $source->id AND enquiry_details.project_id = $request[project_id] AND $condition";
            $status = DB::select($report);
            $enquiry_source = str_replace(' ', '_', $salesSource);
            //$sales_source_name = $sources->sales_source_name;

            $post = array($enquiry_source => $status['0']->cnt);
            $temp_array = array_merge($post, $temp_array);
            $Total = $Total + $status['0']->cnt;
        }
        $response['0'] = $temp_array;

        if (!empty($response)) {
            $result = ['success' => true, 'records' => $response, 'Total' => $Total];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getSourceReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $response = array();
        $condition = '';
        $employee_id = $request["employee_id"];
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(laravel_developement_builder_client.enquiries.sales_enquiry_date BETWEEN '$from_date' AND '$to_date')";
        }

        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }
        //$source_wise_report = "SELECT  count(*) as cnt,laravel_developement_master_edynamics.mlst_bmsb_enquiry_sales_sources.sales_source_name 
        //FROM laravel_developement_builder_client.enquiries RIGHT OUTER JOIN laravel_developement_master_edynamics.mlst_bmsb_enquiry_sales_sources
        // ON laravel_developement_master_edynamics.mlst_bmsb_enquiry_sales_sources.id = laravel_developement_builder_client.enquiries.sales_source_id 
        // where laravel_developement_builder_client.enquiries.sales_employee_id = $employee_id AND $condition  
        // GROUP BY laravel_developement_builder_client.enquiries.sales_source_id";
        $source_wise_report = "SELECT enquiry.sales_source_name,enquiry.id FROM laravel_developement_master_edynamics.mlst_bmsb_enquiry_sales_sources as enquiry";
        $source_wise_report = DB::select($source_wise_report);

        $temp_array = array();
        $Total = 0;
        foreach ($source_wise_report as $sources) {
            $report = "SELECT  count(*) as cnt from enquiries where sales_source_id = $sources->id";
            $source = DB::select($report);


            $sales_source_name = str_replace(' ', '_', $sources->sales_source_name);
            //$sales_source_name = $sources->sales_source_name;

            $post = array($sales_source_name => $source['0']->cnt);
            $temp_array = array_merge($post, $temp_array);
            $Total = $Total + $source['0']->cnt;
        }
        $response['0'] = $temp_array;
        if (!empty($response)) {
            $result = ['success' => true, 'records' => $response, 'Total' => $Total];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getMysalesreport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $salesreportlist = array();
        $emp_id = $request["employee_id"];
        $condition = '';
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(enqf.`followup_date_time` BETWEEN '$from_date' AND '$to_date')";
        }
        if (!empty($request['model_id'])) {
            $model_ids = $request['model_id'];
            if (!empty($condition))
                $condition .= "AND lmsauto_master_final.mlst_lmsa_models.`id` IN($model_ids)";
            else
                $condition .= "lmsauto_master_final.mlst_lmsa_models.`id` IN($model_ids)";
        }
        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }
        if ($flag == 0) {
            $top_query = "SELECT count(*)as cnt,lmsauto_master_final.mlst_lmsa_models.model_name from lmsauto_client_final.enquiry_followups enqf INNER JOIN lmsauto_client_final.enquiry_details ON enqf.booked_vehicle_id=lmsauto_client_final.enquiry_details.id INNER JOIN lmsauto_client_final.enquiries enq ON enq.id=enqf.enquiry_id INNER JOIN lmsauto_master_final.mlst_lmsa_models ON lmsauto_master_final.mlst_lmsa_models.id= lmsauto_client_final.enquiry_details.model_id WHERE enq.sales_employee_id = $emp_id AND enqf.sales_status_id=3 GROUP BY lmsauto_master_final.mlst_lmsa_models.id";
        } else {
            $top_query = "SELECT count(*)as cnt,lmsauto_master_final.mlst_lmsa_models.model_name from lmsauto_client_final.enquiry_followups enqf INNER JOIN lmsauto_client_final.enquiry_details ON enqf.booked_vehicle_id=lmsauto_client_final.enquiry_details.id INNER JOIN lmsauto_client_final.enquiries enq ON enq.id=enqf.enquiry_id INNER JOIN lmsauto_master_final.mlst_lmsa_models ON lmsauto_master_final.mlst_lmsa_models.id= lmsauto_client_final.enquiry_details.model_id WHERE enq.sales_employee_id = $emp_id AND enqf.sales_status_id=3 AND $condition GROUP BY lmsauto_master_final.mlst_lmsa_models.id";
        }
        $sales_report = DB::select($top_query);
        $salesreportlist['model_report'] = $sales_report;
        if (!empty($salesreportlist)) {
            $result = ['success' => true, 'records' => $salesreportlist];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getTeamcategoryreports() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $emp_id = $request["employee_id"];
        if (!empty($request['flag'])) {
            $flag1 = $request['flag'];
        } else {
            $flag1 = 0;
        }
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        $results_enquiry_type = DB::select('CALL proc_total_enquiry_report("' . $emp_id . '","0","","",0,"")');

        $category_wise_team_total = array();
        $mtotal = 0;
        $parant_id = '';
        $parant_id = $this->isParant($first_admin_model->id);
        if (!empty($results_enquiry_type)) {
            $mtotal = $results_enquiry_type['0']->Warm + $results_enquiry_type['0']->New + $results_enquiry_type['0']->Hot + $results_enquiry_type['0']->Cold;
            $category_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'Cold' => $results_enquiry_type['0']->Cold, 'Hot' => $results_enquiry_type['0']->Hot, 'Warm' => $results_enquiry_type['0']->Warm, 'New' => $results_enquiry_type['0']->New, 'Total' => $mtotal);
        } else {
            $category_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'Cold' => '0', 'Hot' => '0', 'Warm' => "0", 'New' => "0", 'Total' => "0");
        }

        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        }

        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;

            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = implode(',', $alluser);

            if (!empty($temp)) {

                $results_enquiry_type = DB::select('CALL proc_total_enquiry_report("' . $temp . '","0","","",0,"0")');
                $new = 0;
                $Hot = 0;
                $Warm = 0;
                $Cold = 0;
                foreach ($results_enquiry_type as $enquiry) {

                    $new += $enquiry->New;
                    $Hot += $enquiry->Hot;
                    $Warm += $enquiry->Warm;
                    $Cold += $enquiry->Cold;
                }
                $ttotal = $new + $Hot + $Warm + $Cold;
                $parant_id1 = 0;
                $parant_id1 = $this->isParant($selfmember->id);

                $category_wise_team_total[] = array('name' => $selfmember->first_name . ' ' . $selfmember->last_name, 'employee_id' => $selfmember->id, 'is_parent' => $parant_id1, 'Cold' => $Cold, 'Hot' => $Hot, 'Warm' => $Warm, 'New' => $new, 'Total' => $ttotal);
            }
        }

        $response = array("category_wise_report" => $category_wise_team_total);
        echo Json_encode($response);
    }

    public function tuserid($id) {

        $admin = \App\Models\backend\Employee::where(['team_lead_id' => $id])->get();
        if (!empty($admin)) {

            foreach ($admin as $item) {

                $this->allusers[$item->id] = $item->id;

                // $this->tuserid($item->id);
            }
        } else {
            return;
        }
    }

    public function getTeamsourcereports() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $emp_id = $request["employee_id"];
        if (!empty($request['flag'])) {
            $flag1 = $request['flag'];
        } else {
            $flag1 = 0;
        }
        $source_total = 0;
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        $allenquirysource = \App\Models\MlstBmscEnquirySalesSources::where('status', 1)->get();
        $results_enquiry_type = DB::select('CALL proc_enquiry_source_report(' . $request['employee_id'] . ',"0","","0")');
        $source_mtdresults = json_decode(json_encode($results_enquiry_type), true); //response in array
        $total = 0;
        foreach ($source_mtdresults as $source) {
            $total = $source['cnt'] + $total;
        }

        $parant_id = '';
        $parant_id = $this->isParant($first_admin_model->id);
        $source_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'total' => $total);


        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        }
        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;

            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            if (!empty($temp)) {
                $results_enquiry_type = DB::select('CALL proc_enquiry_source_report("' . $temp . '","0","","0")');
                $source_results = json_decode(json_encode($results_enquiry_type), true); //response in array

                $tsource_total = 0;
                foreach ($source_results as $enquiry_source) {
                    $tsource_total += $enquiry_source['cnt'];
                }
                $parant_id1 = 0;
                $parant_id1 = $this->isParant($selfmember->id);
                $source_wise_team_total[] = array('name' => $selfmember->first_name . ' ' . $selfmember->last_name, 'employee_id' => $selfmember->id, 'is_parent' => $parant_id1, 'total' => $tsource_total);
            }
        }
        $response = array("source_wise_report" => $source_wise_team_total);
        echo Json_encode($response);
    }

    public function getTeamstatusreports() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];
        if (!empty($request['flag'])) {
            $flag1 = $request['flag'];
        } else {
            $flag1 = 0;
        }
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        $results_status_wise = DB::select('CALL proc_enquiry_status_report("' . $emp_id . '","0","","",0,"")');
        $results_status_wise = json_decode(json_encode($results_status_wise), true);
        $total = 0;
        $parant_id = '';
        $parant_id = $this->isParant($first_admin_model->id);
        if (!empty($results_status_wise)) {
            $total = $results_status_wise['0']['Open'] + $results_status_wise['0']['Booked'] + $results_status_wise['0']['Lost'] + $results_status_wise['0']['New'] + $results_status_wise['0']['Preserved'];
            $status_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'open' => $results_status_wise['0']['Open'], 'booked' => $results_status_wise['0']['Booked'], 'lost' => $results_status_wise['0']['Lost'], 'new' => $results_status_wise['0']['New'], 'preserved' => $results_status_wise['0']['Preserved'], 'total' => $total);
        } else {
            $status_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'open' => "0", 'booked' => "0", 'lost' => "0", 'new' => "0", 'preserved' => "0", 'total' => "0");
        }
        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);

            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where(['team_lead_id' => $emp_id])->whereRaw('FIND_IN_SET(1,department_id)')->get();
        }

        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;

            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            if (!empty($temp)) {
                $results_enquiry_type = DB::select('CALL proc_enquiry_status_report("' . $temp . '","0","","",0,"0")');
                $new = 0;
                $Open = 0;
                $Booked = 0;
                $Lost = 0;
                $Preserved = 0;
                foreach ($results_enquiry_type as $enquiry) {

                    $new += $enquiry->New;
                    $Open += $enquiry->Open;
                    $Booked += $enquiry->Booked;
                    $Lost += $enquiry->Lost;
                    $Preserved += $enquiry->Preserved;
                }
                $ttotal = $new + $Open + $Booked + $Lost + $Preserved;

                $parant_id1 = 0;
                $parant_id1 = $this->isParant($selfmember->id);
                $status_wise_team_total[] = array('name' => $selfmember->first_name . ' ' . $selfmember->last_name, 'employee_id' => $selfmember->id, 'is_parent' => $parant_id1, 'open' => $Open, 'booked' => $Booked, 'lost' => $Lost, 'new' => $new, 'preserved' => $Preserved, 'total' => $ttotal);
            }
        }
        $response = array("status_wise_report" => $status_wise_team_total);
        echo Json_encode($response);
    }

    public function getsourcereports() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];
        if (empty($request['login_id'])) {
            $login_id = Auth::guard('admin')->user()->id;
        } else {
            $login_id = $request['login_id'];
        }
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        $allenquirysource = \App\Models\MlstBmscEnquirySalesSources::where('status', 1)->get();
        if ($emp_id == $login_id) {
            $results_enquiry_type = DB::select('CALL proc_enquiry_source_report(' . $request['employee_id'] . ',"0","","0")');
            $source_mtdresults = json_decode(json_encode($results_enquiry_type), true); //response in array
            $total = 0;
            foreach ($source_mtdresults as $source) {
                $total = $source['cnt'] + $total;
            }
            if ($login_id == $emp_id) {
                $counting[] = array('total' => $total);
            }
        }

        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_id)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        }
        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;

            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            if (!empty($temp)) {

                $results_enquiry_type = DB::select('CALL proc_enquiry_source_report("' . $temp . '","0","","")');
                $source_mtdresults = json_decode(json_encode($results_enquiry_type), true); //response in array

                $tsource_total = 0;
                foreach ($source_mtdresults as $enquiry_source) {
                    $tsource_total = $tsource_total + $enquiry_source['cnt'];
                }
                $counting[] = array('total' => $tsource_total);
            }
        }
        $countSales = 0;
        foreach ($counting as $count) {
            $countSales = $count['total'] + $countSales;
        }
        $parant_id = 0;
        $parant_id = $this->isParant($emp_id);
        $source_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'total' => $countSales);
        $response = array("source_wise_report" => $source_wise_team_total);
        echo Json_encode($response);
    }

    public function getSourceWiseReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $results_enquiry_type = DB::select('CALL proc_enquiry_source_report("' . $request['source']['employee_id'] . '","0","0","0")');
        $source = json_decode(json_encode($results_enquiry_type), true); //response in array
        $sourceReport = [];
        foreach ($source as $source) {

            $sales_subsources = DB::table('enquiry_sales_sub_sources')->where('enquiry_sales_source_id', '=', $source['id'])->get();

            if (count($sales_subsources) > 0) {
                $sReport = ['id' => $source['id'], 'sales_source_name' => $source['sales_source_name'], 'cnt' => $source['cnt'], 'substatus' => '1'];
                array_push($sourceReport, $sReport);
            } else {
                $sReport = ['id' => $source['id'], 'sales_source_name' => $source['sales_source_name'], 'cnt' => $source['cnt'], 'substatus' => '0'];
                array_push($sourceReport, $sReport);
            }
        }
        $response = array("source_report" => $sourceReport);
        echo Json_encode($response);
    }

    public function getTeamfollowupreports() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];
        if (empty($request['login_id'])) {
            $login_id = Auth::guard('admin')->user()->id;
        } else {
            $login_id = $request['login_id'];
        }

        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();

        $condition = '';

        $parant_id = '';
        $parant_id = $this->isParant($first_admin_model->id);
        if ($emp_id == $login_id) {

//            $top_query = "SELECT DATEDIFF(now(),ef.`next_followup_date`) as followupdate_diff_in_days ,if(DATEDIFF(now(),ef.`next_followup_date`) = 0,(count(DATEDIFF(now(),ef.`next_followup_date`))-(select count(distinct ef.enquiry_id) FROM `enquiry_followups` ef LEFT JOIN enquiries e ON ef.`enquiry_id`=e.id where e.sales_employee_id = $emp_id and ef.`next_followup_date`= CURDATE())),count(DATEDIFF(now(),ef.`next_followup_date`))
//                            
            $top_query = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id IN($emp_id) GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
        }
        $totacount = DB::select($top_query);
        $sameday = 0;
        $seconday = 0;
        $thirdday = 0;
        $afterthirdday = 0;
        $total = 0;
        $followupreportlist['sameday'] = $sameday;
        $followupreportlist['secondday'] = $seconday;
        $followupreportlist['thirdday'] = $thirdday;
        $followupreportlist['afterthirdday'] = $afterthirdday;
        if (!empty($totacount)) {
            foreach ($totacount as $row) {
                $followup[$row->followupdate_diff_in_days] = $row->followupdate_diff_in_days_cnt;
            }

            if (!empty($followup)) {

                foreach ($followup as $key1 => $value1) {

                    if ($key1 == 0) {
                        $sameday = $sameday + $value1;
                    }
                    if ($key1 == 1) {
                        $seconday = $seconday + $value1;
                    }
                    if ($key1 == 2) {
                        $thirdday = $thirdday + $value1;
                    }
                    if ($key1 >= 3) {
                        $afterthirdday = $afterthirdday + $value1;
                    }
                }
                $followupreportlist['sameday'] = $sameday;
                $followupreportlist['secondday'] = $seconday;
                $followupreportlist['thirdday'] = $thirdday;
                $followupreportlist['afterthirdday'] = $afterthirdday;
                $total = $sameday + $seconday + $thirdday + $afterthirdday;
            } else {
                $followupreportlist['sameday'] = $sameday;
                $followupreportlist['secondday'] = $seconday;
                $followupreportlist['thirdday'] = $thirdday;
                $followupreportlist['afterthirdday'] = $afterthirdday;
            }
        }
        $counting[] = array('sameday' => $followupreportlist['sameday'], 'secondday' => $followupreportlist['secondday'], 'thirdday' => $followupreportlist['thirdday'], 'afterthirdday' => $followupreportlist['afterthirdday'], 'total' => $total);

        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where(['team_lead_id' => $emp_id])->get();
        }
        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;

            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            $parant_id1 = 0;
            $parant_id1 = $this->isParant($selfmember->id);
            if (!empty($temp)) {
                $top_query = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id IN($temp) GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";


                $totacount1 = DB::select($top_query);

                $sameday = 0;
                $seconday = 0;
                $thirdday = 0;
                $afterthirdday = 0;
                $mtotal = 0;
                $followup1 = array();
                $followupreportlist1 = array();
                $followupreportlist1['sameday'] = $sameday;
                $followupreportlist1['secondday'] = $seconday;
                $followupreportlist1['thirdday'] = $thirdday;
                $followupreportlist1['afterthirdday'] = $afterthirdday;

                if (!empty($totacount1)) {
                    foreach ($totacount1 as $row1) {
                        $followup1[$row1->followupdate_diff_in_days] = $row1->followupdate_diff_in_days_cnt;
                    }
                    if (!empty($followup1)) {

                        foreach ($followup1 as $key1 => $value1) {

                            if ($key1 == 0) {
                                $sameday = $sameday + $value1;
                            }
                            if ($key1 == 1) {
                                $seconday = $seconday + $value1;
                            }
                            if ($key1 == 2) {
                                $thirdday = $thirdday + $value1;
                            }
                            if ($key1 >= 3) {
                                $afterthirdday = $afterthirdday + $value1;
                            }
                        }

                        $followupreportlist1['sameday'] = $sameday;
                        $followupreportlist1['secondday'] = $seconday;
                        $followupreportlist1['thirdday'] = $thirdday;
                        $followupreportlist1['afterthirdday'] = $afterthirdday;
                        $mtotal = $sameday + $seconday + $thirdday + $afterthirdday;
                    }
                }
                $counting[] = array('sameday' => $followupreportlist1['sameday'], 'secondday' => $followupreportlist1['secondday'], 'thirdday' => $followupreportlist1['thirdday'], 'afterthirdday' => $followupreportlist1['afterthirdday'], 'total' => $mtotal);
            }
        }
        $sameday = 0;
        $secondday = 0;
        $thirdday = 0;
        $afterthirdday = 0;
        $total = 0;
        foreach ($counting as $count) {
            $sameday = $count['sameday'] + $sameday;
            $secondday = $count['secondday'] + $secondday;
            $thirdday = $count['thirdday'] + $thirdday;
            $afterthirdday = $count['afterthirdday'] + $afterthirdday;
            $total = $count['total'] + $total;
        }
        $team_follwup[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'sameday' => $sameday, 'secondday' => $secondday, 'thirdday' => $thirdday, 'afterthirdday' => $afterthirdday, 'total' => $total);


        $response = array("Teams_followups" => $team_follwup);
        echo Json_encode($response);
    }

    public function isParant($admin) {
        $admin_model = "SELECT DISTINCT team_lead_id FROM employees";
        $admin_model = DB::select($admin_model);
        $parants = array();
        foreach ($admin_model as $admin_model_row) {
            $parants[] = $admin_model_row->team_lead_id;
        }

        if (in_array($admin, $parants)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function projectwiseReport() {
        return view("Reports::projectReport")->with("loggedInUserID", Auth::guard('admin')->user()->id);
    }

    public function followupReport() {
        return view("Reports::followupReport")->with("loggedInUserID", Auth::guard('admin')->user()->id);
    }

    Public function followupReports() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $response = array();
        $condition = '';
        $employee_id = $request["employee_id"];

        $condition = '';
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(ef.`followup_date_time` BETWEEN '$from_date' AND '$to_date')";
        }
        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }

        if (!empty($employee_id)) {
            if ($flag == 0) {
                $folowup_report = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id = $employee_id GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
            } else {
                $folowup_report = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id = $employee_id AND $condition GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
            }


            $folowup_report = DB::select($folowup_report);

            $same_day = 0;
            $second_day = 0;
            $third_day = 0;
            $after_third_day = 0;
            $total = 0;
            if (!empty($folowup_report)) {
                foreach ($folowup_report as $row) {
                    $days = $row->followupdate_diff_in_days;
                    if ($days == 0) {
                        $same_day = $row->followupdate_diff_in_days_cnt;
                    } else if ($days == 1) {
                        $second_day = $row->followupdate_diff_in_days_cnt;
                    } else if ($days == 2) {
                        $third_day = $row->followupdate_diff_in_days_cnt;
                    } else if ($days > 2) {
                        $after_third_day += $row->followupdate_diff_in_days_cnt;
                    }
                    $total = $same_day + $second_day + $third_day + $after_third_day;
                }
            }
            $followup_total[] = array('same_day' => $same_day, 'second_day' => $second_day, 'third_day' => $third_day, 'after_third_day' => $after_third_day, 'total' => $total);
        }
        if (!empty($followup_total)) {
            $result = ['success' => true, 'records' => $followup_total];
            return json_encode($result);
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
            return json_encode($result);
        }
    }

    public function getTeamEnquiryreports() {
        return view("Reports::teamEnquiryReport")->with("loggedInUserID", Auth::guard('admin')->user()->id);
    }

    public function projectwiseTeamreport() {
        return view("Reports::projectTeamReport")->with("loggedInUserID", Auth::guard('admin')->user()->id);
    }

    public function TeamLeadProjectCategotyReport() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();

        $results_enquiry_type = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty  ON e.sales_category_id = eqty.id INNER JOIN enquiry_details as detail ON detail.enquiry_id = e.id INNER JOIN projects as project  ON detail.project_id =  project.id  WHERE e.sales_status_id IN(1,2) AND  project.id = " . $request['project_id'] . "  AND e.sales_employee_id = " . $emp_id . " GROUP BY e.sales_category_id";
        $results_enquiry_type = DB::select($results_enquiry_type);
        $category_wise_team_total = array();
        $m_cold_count = 0;
        $m_hot_count = 0;
        $m_warm_count = 0;
        $m_new_count = 0;
        $mtotal = 0;
        if (!empty($results_enquiry_type)) {
            foreach ($results_enquiry_type AS $result_enquiry_type) {
                $enqtype = $result_enquiry_type->enquiry_category;
                if ($enqtype == "Cold") {
                    $m_cold_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "Hot") {
                    $m_hot_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "Warm") {
                    $m_warm_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "New Enquiry") {
                    $m_new_count = $result_enquiry_type->cnt;
                }
                $mtotal = $m_cold_count + $m_hot_count + $m_warm_count + $m_new_count;
            }
        }
        $parant_id = '';
        $parant_id = $this->isParant($first_admin_model->id);

        $counting[] = array('Cold' => $m_cold_count, 'Hot' => $m_hot_count, 'Warm' => $m_warm_count, 'New' => $m_new_count, 'Total' => $mtotal);

//          
        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->get();
        }
        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;
            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            //print_r($temp);exit;
            if (!empty($temp)) {
                $results_category_wise = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id INNER JOIN enquiry_details as detail ON detail.enquiry_id = e.id INNER JOIN projects as project ON detail.project_id =  project.id WHERE e.sales_status_id IN(1,2) AND  project.id = " . $request['project_id'] . " AND e.sales_employee_id IN($temp) GROUP BY e.sales_category_id";
            }
            $results_category_wise = DB::select($results_category_wise);
            $cold_count = 0;
            $hot_count = 0;
            $warm_count = 0;
            $new_count = 0;
            $ttotal = 0;
            if (!empty($results_category_wise)) {
                foreach ($results_category_wise as $result_category_wise) {

                    $enqtype = $result_category_wise->enquiry_category;
                    if ($enqtype == "Cold") {
                        $cold_count = $result_category_wise->cnt;
                    } else if ($enqtype == "Hot") {
                        $hot_count = $result_category_wise->cnt;
                    } else if ($enqtype == "Warm") {
                        $warm_count = $result_category_wise->cnt;
                    } else if ($enqtype == "New Enquiry") {
                        $new_count = $result_category_wise->cnt;
                    }
                    $ttotal = $cold_count + $hot_count + $warm_count + $new_count;
                }
                //print_r($result_category_wise->enquiry_category);exit;
            }
            $parant_id1 = 0;
            $parant_id1 = $this->isParant($selfmember->id);

            $counting[] = array('Cold' => $cold_count, 'Hot' => $hot_count, 'Warm' => $warm_count, 'New' => $new_count, 'Total' => $ttotal);
        }
        $cold = 0;
        $hot = 0;
        $warm = 0;
        $new = 0;
        $total = 0;

        foreach ($counting as $count) {
            $cold = $count['Cold'] + $cold;
            $hot = $count['Hot'] + $hot;
            $warm = $count['Warm'] + $warm;
            $new = $count['New'] + $new;
            $total = $count['Total'] + $total;
        }


        $category_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'Cold' => $cold, 'Hot' => $hot, 'Warm' => $warm, 'New' => $new, 'is_parent' => $parant_id1, 'Total' => $total);
        $response = array("category_wise_report" => $category_wise_team_total);
        echo Json_encode($response);
    }

    public function TeamProjectCategotyReport() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];

        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();


        $results_enquiry_type = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty  ON e.sales_category_id = eqty.id INNER JOIN enquiry_details as detail ON detail.enquiry_id = e.id INNER JOIN projects as project  ON detail.project_id =  project.id  WHERE e.sales_status_id IN(1,2) AND  project.id = " . $request['project_id'] . "  AND e.sales_employee_id = " . $emp_id . " GROUP BY e.sales_category_id";
        $results_enquiry_type = DB::select($results_enquiry_type);

        $category_wise_team_total = array();
        $m_cold_count = 0;
        $m_hot_count = 0;
        $m_warm_count = 0;
        $m_new_count = 0;
        $mtotal = 0;
        if (!empty($results_enquiry_type)) {
            foreach ($results_enquiry_type AS $result_enquiry_type) {
                $enqtype = $result_enquiry_type->enquiry_category;
                if ($enqtype == "Cold") {
                    $m_cold_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "Hot") {
                    $m_hot_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "Warm") {
                    $m_warm_count = $result_enquiry_type->cnt;
                } else if ($enqtype == "New Enquiry") {
                    $m_new_count = $result_enquiry_type->cnt;
                }
                $mtotal = $m_cold_count + $m_hot_count + $m_warm_count + $m_new_count;
            }
        }
        $parant_id = '';
        $parant_id = $this->isParant($first_admin_model->id);

        $category_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'Cold' => $m_cold_count, 'Hot' => $m_hot_count, 'Warm' => $m_warm_count, 'New' => $m_new_count, 'Total' => $mtotal);

        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->get();
        }

        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;

            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            //print_r($temp);exit;
            if (!empty($temp)) {
                $results_category_wise = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id INNER JOIN enquiry_details as detail ON detail.enquiry_id = e.id INNER JOIN projects as project ON detail.project_id =  project.id WHERE e.sales_status_id IN(1,2) AND  project.id = " . $request['project_id'] . " AND e.sales_employee_id IN($temp) GROUP BY e.sales_category_id";
                $results_category_wise = DB::select($results_category_wise);

                $cold_count = 0;
                $hot_count = 0;
                $warm_count = 0;
                $new_count = 0;
                $ttotal = 0;
                if (!empty($results_category_wise)) {
                    foreach ($results_category_wise as $result_category_wise) {

                        $enqtype = $result_category_wise->enquiry_category;
                        if ($enqtype == "Cold") {
                            $cold_count = $result_category_wise->cnt;
                        } else if ($enqtype == "Hot") {
                            $hot_count = $result_category_wise->cnt;
                        } else if ($enqtype == "Warm") {
                            $warm_count = $result_category_wise->cnt;
                        } else if ($enqtype == "New Enquiry") {
                            $new_count = $result_category_wise->cnt;
                        }
                        $ttotal = $cold_count + $hot_count + $warm_count + $new_count;
                    }
                    //print_r($result_category_wise->enquiry_category);exit;
                }
                $parant_id1 = 0;
                $parant_id1 = $this->isParant($selfmember->id);

                $category_wise_team_total[] = array('name' => $selfmember->first_name . ' ' . $selfmember->last_name, 'employee_id' => $selfmember->id, 'is_parent' => $parant_id1, 'Cold' => $cold_count, 'Hot' => $hot_count, 'Warm' => $warm_count, 'New' => $new_count, 'Total' => $ttotal);
            }
        }

        $response = array("category_wise_report" => $category_wise_team_total);
        echo Json_encode($response);
    }

    public function TeamProjectStatusReport() {

        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];
        $condition = '';

        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        if ($emp_id) {
            $results_enquiry_type = "  SELECT count(*) as cnt, eqty.sales_status FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_statuses as eqty  ON e.sales_status_id = eqty.id INNER JOIN enquiry_details as detail ON detail.enquiry_id = e.id INNER JOIN projects as project  ON detail.project_id =  project.id  WHERE e.sales_status_id IN(1,2) AND  project.id = " . $request['project_id'] . "  AND e.sales_employee_id = " . $emp_id . " GROUP BY e.sales_status_id";
            $results_enquiry_type = DB::select($results_enquiry_type);
            $status_wise_team_total = array();
            $m_new_count = 0;
            $m_open_count = 0;
            $m_booked_count = 0;
            $m_lost_count = 0;
            $m_preserved_count = 0;
            $mtotal = 0;
            if (!empty($results_enquiry_type)) {
                foreach ($results_enquiry_type AS $result_enquiry_type) {
                    $enqtype = $result_enquiry_type->sales_status;
                    if ($enqtype == "New Enquiry") {
                        $m_new_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Open") {
                        $m_open_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Booked") {
                        $m_booked_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Lost") {
                        $m_lost_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Preserved") {
                        $m_preserved_count = $results_status_wise->cnt;
                    }
                    $mtotal = $m_new_count + $m_open_count + $m_booked_count + $m_lost_count + $m_preserved_count;
                }
            }
            $parant_id = '';
            $parant_id = $this->isParant($first_admin_model->id);
            $counting[] = array('new' => $m_new_count, 'open' => $m_open_count, 'booked' => $m_booked_count, 'lost' => $m_lost_count, 'preserved' => $m_preserved_count, 'total' => $mtotal);

//                 'name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id,
        }


        $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->get();

        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;
            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            if (!empty($temp)) {

                $results_status_wise = "SELECT count(*) as cnt, eqty.sales_status FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_statuses as eqty ON e.sales_status_id = eqty.id INNER JOIN enquiry_details as detail ON detail.enquiry_id = e.id INNER JOIN projects as project ON detail.project_id =  project.id WHERE e.sales_status_id IN(1,2) AND  project.id = " . $request['project_id'] . " AND e.sales_employee_id IN($temp) GROUP BY e.sales_status_id";

                $results_status_wise = DB::select($results_status_wise);
                $new_count = 0;
                $open_count = 0;
                $booked_count = 0;
                $Lost_count = 0;
                $ttotal = 0;
                $Preserved_count = 0;
                if (!empty($results_status_wise)) {
                    foreach ($results_status_wise as $results_status_wise) {
                        $enqtype = $results_status_wise->sales_status;
                        if ($enqtype == "New Enquiry") {
                            $new_count = $results_status_wise->cnt;
                        } else if ($enqtype == "Open") {
                            $open_count = $results_status_wise->cnt;
                        } else if ($enqtype == "Booked") {
                            $booked_count = $results_status_wise->cnt;
                        } else if ($enqtype == "Lost") {
                            $Lost_count = $results_status_wise->cnt;
                        } else if ($enqtype == "Preserved") {
                            $Preserved_count = $results_status_wise->cnt;
                        }
                        $ttotal = $new_count + $open_count + $booked_count + $Lost_count + $Preserved_count;
                    }
                }
                $parant_id1 = 0;
                $parant_id1 = $this->isParant($selfmember->id);
                $counting[] = array('new' => $new_count, 'open' => $open_count, 'booked' => $booked_count, 'lost' => $Lost_count, 'preserved' => $Preserved_count, 'total' => $ttotal);
            }
        }

        $open = 0;
        $booked = 0;
        $lost = 0;
        $new = 0;
        $preserved = 0;
        $total = 0;
        foreach ($counting as $count) {
            $open += $count['open'];
            $booked += $count['booked'];
            $lost += $count['lost'];
            $new += $count['new'];
            $preserved += $count['preserved'];
            $total += $count['total'];
        }
        $status_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'open' => $open, 'booked' => $booked, 'lost' => $lost, 'new' => $new, 'preserved' => $preserved, 'total' => $total);

        $response = array("status_wise_report" => $status_wise_team_total);
        echo Json_encode($response);
    }

    public function TeamProjectSourceReport() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $temp_array = array();
        $other_array = array();
        $emp_id = $request["employee_id"];
        $condition = '';
        $source_wise_team_total = array();
        $Total = 0;
        $counting = 0;
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();

        if ($emp_id) {
            $results_enquiry_type = "SELECT count(*) as cnt FROM enquiries as e INNER JOIN enquiry_details as detail ON e.id = detail.enquiry_id INNER JOIN projects as p ON p.id = detail.project_id AND e.sales_employee_id IN(" . $emp_id . ") AND e.sales_status_id IN (1,2,5) AND detail.project_id = 1";
            $results_enquiry_type = DB::select($results_enquiry_type);
            $counting = $results_enquiry_type[0]->cnt;
        }

        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->get();
        }
        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;
            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            if (!empty($temp)) {
                $results_enquiry_type = "SELECT count(*) as cnt FROM enquiries as e INNER JOIN enquiry_details as detail ON e.id = detail.enquiry_id INNER JOIN projects as p ON p.id = detail.project_id AND e.sales_employee_id IN(" . $temp . ") AND e.sales_status_id IN (1,2,5) AND detail.project_id = 1";
                $results_enquiry_type = DB::select($results_enquiry_type);

                foreach ($results_enquiry_type as $result) {
                    $counting += $result->cnt;
                }
            }
        }
        $parant_id = '';
        $parant_id = $this->isParant($emp_id);
        $source_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'count' => $counting);


        $response = array("source_wise_report" => $source_wise_team_total);
        echo Json_encode($response);
    }

    public function teamProjectSourceEmpReport() {

        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $temp_array = array();
        $other_array = array();
        $emp_id = $request["employee_id"];
        $condition = '';
        $source_wise_team_total = array();
        $Total = 0;
        $sTotal = 0;

        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();


        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();

        if ($emp_id) {
            $results_enquiry_type = "SELECT count(*) as cnt FROM enquiries as e INNER JOIN enquiry_details as detail "
                    . "ON e.id = detail.enquiry_id INNER JOIN projects as p ON p.id = detail.project_id "
                    . "AND e.sales_employee_id IN(" . $emp_id . ") "
                    . "AND e.sales_status_id IN (1,2,5) AND detail.project_id = 1";
            $results_enquiry_type = DB::select($results_enquiry_type);


            $parant_id = '';
            $parant_id = $this->isParant($first_admin_model->id);
            $source_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'count' => $results_enquiry_type[0]->cnt);
        }
        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->get();
        }
        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $count1 = 0;
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;
            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);

            if (!empty($temp)) {

                $sresult = "SELECT count(*) as cnt FROM enquiries as e INNER JOIN enquiry_details as detail "
                        . "ON e.id = detail.enquiry_id INNER JOIN projects as p ON p.id = detail.project_id "
                        . "AND e.sales_employee_id IN(" . $temp . ") "
                        . "AND e.sales_status_id IN (1,2,5) AND detail.project_id = 1";

                $source_result = DB::select($sresult);

                foreach ($source_result as $source) {
                    $count1 += $source->cnt;
                }

                $parant_id1 = 0;
                $parant_id1 = $this->isParant($selfmember->id);
                $source_wise_team_total[] = array('name' => $selfmember->first_name . ' ' . $selfmember->last_name, 'employee_id' => $selfmember->id, 'is_parent' => $parant_id1, 'count' => $count1);
            }
        }

        $response = array("source_wise_report" => $source_wise_team_total);
        echo Json_encode($response);
    }

    public function teamProjectCategoryReport() {

        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];
        $condition = '';
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(be.sales_enquiry_date BETWEEN '$from_date' AND '$to_date')";
        }
        if (!empty($request['flag'])) {
            $flag1 = $request['flag'];
        } else {
            $flag1 = 0;
        }
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        if ($emp_id) {
            if ($flag1 == 0) {
                $results_enquiry_type = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id INNER JOIN laravel_developement_builder_client.enquiry_details as details ON details.enquiry_id = e.id WHERE e.sales_status_id IN(1,2) AND e.sales_employee_id = $emp_id AND details.project_id= " . $request['project_id'] . " GROUP BY e.sales_category_id";
            } else {
                if (!empty($condition)) {
                    $results_enquiry_type = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id INNER JOIN laravel_developement_builder_client.enquiry_details as details ON details.enquiry_id = e.id WHERE e.sales_status_id IN(1,2) AND e.sales_employee_id = $emp_id AND $condition AND details.project_id= " . $request['project_id'] . " GROUP BY e.sales_category_id";
                } else {
                    $results_enquiry_type = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id INNER JOIN laravel_developement_builder_client.enquiry_details as details ON details.enquiry_id = e.id WHERE e.sales_status_id IN(1,2) AND e.sales_employee_id = $emp_id AND details.project_id= " . $request['project_id'] . " GROUP BY e.sales_category_id";
                }
            }
            $results_enquiry_type = DB::select($results_enquiry_type);
            $category_wise_team_total = array();
            $m_cold_count = 0;
            $m_hot_count = 0;
            $m_warm_count = 0;
            $m_new_count = 0;
            $mtotal = 0;

            if (!empty($results_enquiry_type)) {
                foreach ($results_enquiry_type AS $result_enquiry_type) {
                    $enqtype = $result_enquiry_type->enquiry_category;
                    if ($enqtype == "Cold") {
                        $m_cold_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Hot") {
                        $m_hot_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Warm") {
                        $m_warm_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "New Enquiry") {
                        $m_new_count = $result_enquiry_type->cnt;
                    }
                    $mtotal = $m_cold_count + $m_hot_count + $m_warm_count + $m_new_count;
                }
            }
            $parant_id = '';
            $parant_id = $this->isParant($first_admin_model->id);

            $category_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'Cold' => $m_cold_count, 'Hot' => $m_hot_count, 'Warm' => $m_warm_count, 'New' => $m_new_count, 'Total' => $mtotal);
        }

        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->get();
        }


        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;
            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);


            if (!empty($temp)) {
                if ($flag1 == 0) {
                    $results_category_wise = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id INNER JOIN laravel_developement_builder_client.enquiry_details as details ON details.enquiry_id = e.id WHERE e.sales_status_id IN(1,2) AND details.project_id = 1 AND e.sales_employee_id IN($temp) AND details.project_id= " . $request['project_id'] . " GROUP BY e.sales_category_id";
                } else {
                    if (!empty($condition)) {
                        $results_category_wise = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id INNER JOIN laravel_developement_builder_client.enquiry_details as details ON details.enquiry_id = e.id WHERE e.sales_status_id IN(1,2) AND details.project_id = 1 AND e.sales_employee_id IN($temp)   AND $condition  AND details.project_id= " . $request['project_id'] . " GROUP BY e.sales_category_id";
                    }
                    $results_category_wise = "SELECT count(*) as cnt, eqty.enquiry_category FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_categories as eqty ON e.sales_category_id = eqty.id INNER JOIN laravel_developement_builder_client.enquiry_details as details ON details.enquiry_id = e.id WHERE e.sales_status_id IN(1,2) AND details.project_id = 1 AND e.sales_employee_id IN($temp)   AND $condition  GROUP BY e.sales_category_id";
                }
                $results_category_wise = DB::select($results_category_wise);
                $cold_count = 0;
                $hot_count = 0;
                $warm_count = 0;
                $new_count = 0;
                $ttotal = 0;
                if (!empty($results_category_wise)) {
                    foreach ($results_category_wise as $result_category_wise) {
                        $enqtype = $result_category_wise->enquiry_category;
                        if ($enqtype == "Cold") {
                            $cold_count = $result_category_wise->cnt;
                        } else if ($enqtype == "Hot") {
                            $hot_count = $result_category_wise->cnt;
                        } else if ($enqtype == "Warm") {
                            $warm_count = $result_category_wise->cnt;
                        } else if ($enqtype == "New Enquiry") {
                            $new_count = $result_category_wise->cnt;
                        }
                        $ttotal = $cold_count + $hot_count + $warm_count + $new_count;
                    }
                }
                $parant_id1 = 0;
                $parant_id1 = $this->isParant($selfmember->id);
                $category_wise_team_total[] = array('name' => $selfmember->first_name . ' ' . $selfmember->last_name, 'employee_id' => $selfmember->id, 'is_parent' => $parant_id1, 'Cold' => $cold_count, 'Hot' => $hot_count, 'Warm' => $warm_count, 'New' => $new_count, 'Total' => $ttotal);
            }
        }

        $response = array("category_wise_report" => $category_wise_team_total);
        echo Json_encode($response);
    }

    public function teamProjectStatusEmpReport() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];

        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        if ($emp_id) {
            $results_enquiry_type = "SELECT count(*) as cnt, eqty.sales_status FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_statuses as eqty ON e.sales_status_id = eqty.id INNER JOIN laravel_developement_builder_client.enquiry_details as details ON details.enquiry_id = e.id  AND e.sales_employee_id = $emp_id AND details.project_id= " . $request['project_id'] . " GROUP BY e.sales_status_id";
            $results_enquiry_type = DB::select($results_enquiry_type);

            $status_wise_team_total = array();
            $m_new_count = 0;
            $m_open_count = 0;
            $m_booked_count = 0;
            $m_lost_count = 0;
            $m_preserved_count = 0;
            $mtotal = 0;
            if (!empty($results_enquiry_type)) {
                foreach ($results_enquiry_type AS $result_enquiry_type) {
                    $enqtype = $result_enquiry_type->sales_status;
                    if ($enqtype == "New Enquiry") {
                        $m_new_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Open") {
                        $m_open_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Booked") {
                        $m_booked_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Lost") {
                        $m_lost_count = $result_enquiry_type->cnt;
                    } else if ($enqtype == "Preserved") {
                        $m_preserved_count = $result_enquiry_type->cnt;
                    }
                    $mtotal = $m_new_count + $m_open_count + $m_booked_count + $m_lost_count + $m_preserved_count;
                }
            }
            $parant_id = '';
            $parant_id = $this->isParant($first_admin_model->id);
            $status_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'new' => $m_new_count, 'open' => $m_open_count, 'booked' => $m_booked_count, 'lost' => $m_lost_count, 'preserved' => $m_preserved_count, 'Total' => $mtotal);
        }
        $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->get();

        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;
            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);

            if (!empty($temp)) {
                $results_status_wise = "SELECT count(*) as cnt, eqty.sales_status FROM laravel_developement_builder_client.enquiries e INNER JOIN laravel_developement_master_edynamics.mlst_enquiry_sales_statuses as eqty ON e.sales_status_id = eqty.id INNER JOIN laravel_developement_builder_client.enquiry_details as details ON details.enquiry_id = e.id WHERE  details.project_id= " . $request['project_id'] . "  AND e.sales_employee_id IN($temp) GROUP BY e.sales_status_id";
                $results_status_wise = DB::select($results_status_wise);
                $new_count = 0;
                $open_count = 0;
                $booked_count = 0;
                $Lost_count = 0;
                $preserved_count = 0;
                $ttotal = 0;

                if (!empty($results_status_wise)) {
                    foreach ($results_status_wise as $results_status_wise) {
                        $enqtype = $results_status_wise->sales_status;
                        if ($enqtype == "New Enquiry") {
                            $new_count = $results_status_wise->cnt;
                        } else if ($enqtype == "Open") {
                            $open_count = $results_status_wise->cnt;
                        } else if ($enqtype == "Booked") {
                            $booked_count = $results_status_wise->cnt;
                        } else if ($enqtype == "Lost") {
                            $Lost_count = $results_status_wise->cnt;
                        } else if ($enqtype == "Preserved") {
                            $preserved_count = $result_enquiry_type->cnt;
                        }
                        $ttotal = $new_count + $open_count + $booked_count + $Lost_count + $preserved_count;
                    }
                }
                $parant_id1 = 0;
                $parant_id1 = $this->isParant($selfmember->id);
                $status_wise_team_total[] = array('name' => $selfmember->first_name . ' ' . $selfmember->last_name, 'employee_id' => $selfmember->id, 'is_parent' => $parant_id1, 'new' => $new_count, 'open' => $open_count, 'booked' => $booked_count, 'lost' => $Lost_count, 'preserved' => $m_preserved_count, 'Total' => $ttotal);
            }
        }

        $response = array("status_wise_report" => $status_wise_team_total);
        echo Json_encode($response);
    }

    public function teamfollowupReport() {
        return view("Reports::teamFollowupReport")->with("loggedInUserID", Auth::guard('admin')->user()->id);
    }

    public function projectSourceReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $results_enquiry_type = DB::select('SELECT ess.id, ess.sales_source_name,(SELECT  COUNT(*) FROM   laravel_developement_builder_client.enquiries as e INNER JOIN laravel_developement_builder_client.enquiry_details as detail ON e.id = detail.enquiry_id INNER JOIN laravel_developement_builder_client.projects as p ON detail.project_id = p.id  WHERE e.sales_source_id = ess.id AND detail.project_id = "' . $request['project_id'] . '"  AND e.sales_employee_id  IN("' . $request['source']['employee_id'] . '") AND e.sales_status_id IN(1,2,5)) as cnt FROM laravel_developement_master_edynamics.mlst_bmsb_enquiry_sales_sources as ess');
        $result = json_decode(json_encode($results_enquiry_type), true);

        $sourceReport = [];
        foreach ($result as $source) {

            $sales_subsources = DB::table('enquiry_sales_sub_sources')->where('enquiry_sales_source_id', '=', $source['id'])->get();

            if (count($sales_subsources) > 0) {
                $sReport = ['id' => $source['id'], 'sales_source_name' => $source['sales_source_name'], 'cnt' => $source['cnt'], 'substatus' => '1'];
                array_push($sourceReport, $sReport);
            } else {
                $sReport = ['id' => $source['id'], 'sales_source_name' => $source['sales_source_name'], 'cnt' => $source['cnt'], 'substatus' => '0'];
                array_push($sourceReport, $sReport);
            }
        }
        $response = array("source_wise_report" => $sourceReport);
        echo Json_encode($response);
    }

    public function projectSubSourceReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $result = DB::select("select eqty.sub_source, eqty.id, count(*) as cnt from enquiries as e inner join enquiry_details as detail on detail.enquiry_id = e.id inner join projects as p on p.id = detail.project_id inner join enquiry_sales_sub_sources as eqty on e.sales_subsource_id = eqty.id where e.sales_source_id = " . $request['source']['id'] . " and detail.project_id = " . $request['project_id'] . "  and e.sales_employee_id IN(" . $request['employee_id'] . ") and e.sales_status_id in (1,2,5) group by eqty.sub_source");
        $result1 = json_decode(json_encode($result), true);
        $response = array("sub_source_wise_report" => $result1);
        echo Json_encode($response);
    }

    public function subCategoryReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if ($request['is_emp_group'] == 0) {
            $results_enquiry_type = DB::select('CALL proc_total_enquiry_report(' . $request['category']['employee_id'] . ',' . $request['category_id'] . ',"","",0,"")');
            $result = json_decode(json_encode($results_enquiry_type), true);
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $request['category']['employee_id'])->whereRaw('FIND_IN_SET(1,department_id)')->get();
            $emp_id = [];
            foreach ($selfteam as $selfmember) {
                $this->allusers = array();
                $this->tuserid($selfmember->id);
                $alluser = $this->allusers;
                $alluser[$selfmember->id] = $selfmember->id;
                ksort($alluser);
                foreach ($alluser as $user) {
                    array_push($emp_id, $user);
                }
            }

            $temp = @implode(',', $emp_id);
            if (!empty($temp)) {
                $employee_id = $request['category']['employee_id'] . "," . $temp;
            } else {
                $employee_id = $request['category']['employee_id'];
            }
            $results_enquiry_type = DB::select('CALL proc_total_enquiry_report("' . $employee_id . '",' . $request['category_id'] . ',"","",0,"")');
            $result = json_decode(json_encode($results_enquiry_type), true);
        }
        $response = array("sub_category" => $result);
        return json_encode($response);
    }

    public function subProjectCategoryReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if ($request['is_emp_group'] == 0) {
            $results_enquiry_type = "select eqty.enquiry_sales_subcategory, eqty.id, count(*) as cnt from "
                    . "enquiries as e  inner join enquiry_details as detail on detail.enquiry_id = e.id inner join enquiry_sales_subcategories as eqty on e.sales_subcategory_id = eqty.id"
                    . " where e.sales_category_id = " . $request['category_id'] . " and detail.project_id = " . $request['project_id'] . " and e.sales_employee_id IN(" . $request['category']['employee_id'] . ")"
                    . " and e.sales_status_id in (1,2,5) group by eqty.enquiry_sales_subcategory";
            $result = DB::select($results_enquiry_type);
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $request['category']['employee_id'])->whereRaw('FIND_IN_SET(1,department_id)')->get();
            $emp_id = [];
            foreach ($selfteam as $selfmember) {
                $this->allusers = array();
                $this->tuserid($selfmember->id);
                $alluser = $this->allusers;
                $alluser[$selfmember->id] = $selfmember->id;
                ksort($alluser);
                foreach ($alluser as $user) {
                    array_push($emp_id, $user);
                }
            }
            $temp = @implode(',', $emp_id);
            if (!empty($temp)) {
                $employee_id = $request['category']['employee_id'] . "," . $temp;
            } else {
                $employee_id = $request['category']['employee_id'];
            }
            $results_enquiry_type = "select eqty.enquiry_sales_subcategory, eqty.id, count(*) as cnt from "
                    . "enquiries as e  inner join enquiry_details as detail on detail.enquiry_id = e.id inner join enquiry_sales_subcategories as eqty on e.sales_subcategory_id = eqty.id"
                    . " where e.sales_category_id = " . $request['category_id'] . " and detail.project_id = " . $request['project_id'] . " and e.sales_employee_id IN(" . $request['category']['employee_id'] . ")"
                    . " and e.sales_status_id in (1,2,5) group by eqty.enquiry_sales_subcategory";
            $result = DB::select($results_enquiry_type);
        }
        $response = array("sub_category" => $result);
        return json_encode($response);
    }

    public function subProjectStatusReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if ($request['is_emp_group'] == 0) {
            $results_enquiry_type = "select eqty.enquiry_sales_substatus, eqty.id, count(*) as cnt from "
                    . "enquiries as e  inner join enquiry_details as detail on detail.enquiry_id = e.id inner join enquiry_sales_substatuses as eqty on e.sales_status_id = eqty.id"
                    . " where e.sales_status_id = " . $request['status_id'] . " and detail.project_id = " . $request['project_id'] . " and e.sales_employee_id IN(" . $request['status']['employee_id'] . ")"
                    . "  group by eqty.enquiry_sales_substatus";
            $result = DB::select($results_enquiry_type);
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $request['status']['employee_id'])->whereRaw('FIND_IN_SET(1,department_id)')->get();
            $emp_id = [];
            foreach ($selfteam as $selfmember) {
                $this->allusers = array();
                $this->tuserid($selfmember->id);
                $alluser = $this->allusers;
                $alluser[$selfmember->id] = $selfmember->id;
                ksort($alluser);
                foreach ($alluser as $user) {
                    array_push($emp_id, $user);
                }
            }
            $temp = @implode(',', $emp_id);
            if (!empty($temp)) {
                $employee_id = $request['status']['employee_id'] . "," . $temp;
            } else {
                $employee_id = $request['status']['employee_id'];
            }
            $results_enquiry_type = "select eqty.enquiry_sales_substatus, eqty.id, count(*) as cnt from "
                    . "enquiries as e  inner join enquiry_details as detail on detail.enquiry_id = e.id inner join enquiry_sales_substatuses as eqty on e.sales_status_id = eqty.id"
                    . " where e.sales_status_id = " . $request['status_id'] . " and detail.project_id = " . $request['project_id'] . " and e.sales_employee_id IN(" . $employee_id . ")"
                    . "  group by eqty.enquiry_sales_substatus";
            $result = DB::select($results_enquiry_type);
        }
        $response = array("sub_status" => $result);
        return json_encode($response);
    }

    public function getEmpcategoryreports() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];

        if (empty($request['login_id'])) {
            $login_id = Auth::guard('admin')->user()->id;
        } else {
            $login_id = $request['login_id'];
        }
        if (!empty($request['flag'])) {
            $flag1 = $request['flag'];
        } else {
            $flag1 = 0;
        }
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        if ($emp_id == $login_id) {
            $results_enquiry_type = DB::select('CALL proc_total_enquiry_report("' . $emp_id . '","0","","",0,"")');
            $results_enquiry_type = json_decode(json_encode($results_enquiry_type), true);
            $category_wise_team_total = array();
            $mtotal = 0;
            $parant_id1 = 0;
            $parant_id1 = $this->isParant($results_enquiry_type['0']['id']);
            $emp_ids = $results_enquiry_type['0']['id'];
            $mtotal = $results_enquiry_type['0']['Cold'] + $results_enquiry_type['0']['Hot'] + $results_enquiry_type['0']['Warm'] + $results_enquiry_type['0']['New'];
            $counting[] = array('Cold' => $results_enquiry_type['0']['Cold'], 'Hot' => $results_enquiry_type['0']['Hot'], 'Warm' => $results_enquiry_type['0']['Warm'], 'New' => $results_enquiry_type['0']['New'], 'Total' => $mtotal);
        }
        $selfteam = \App\Models\backend\Employee::where('team_lead_id', $emp_id)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        $i = 0;
        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;

            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = implode(',', $alluser);
            if (!empty($temp)) {
                if ($flag1 == 0) {
                    $results_category_wise = DB::select('CALL proc_total_enquiry_report("' . $temp . '","0","","",0,"")');
                } else {
                    $results_category_wise = DB::select('CALL proc_total_enquiry_report("' . $temp . '","0","","",0,"")');
                }
                foreach ($results_category_wise as $category) {
                    $ttotal = 0;
                    $ttotal = $category->Cold + $category->Hot + $category->Warm + $category->New;
                    $i + 1;
                    $counting[] = array('Cold' => $category->Cold, 'Hot' => $category->Hot, 'Warm' => $category->Warm, 'New' => $category->New, 'Total' => $ttotal);
                }
            }
        }
        $cold = 0;
        $hot = 0;
        $warm = 0;
        $new = 0;
        $total = 0;
        foreach ($counting as $count) {
            $cold = $count['Cold'] + $cold;
            $hot = $count['Hot'] + $hot;
            $warm = $count['Warm'] + $warm;
            $new = $count['New'] + $new;
            $total = $count['Total'] + $total;
        }
//         'is_parent' => $parant_id,
        $category_wise_team_total[] = array('name' => $results_enquiry_type['0']['first_name'] . " " . $results_enquiry_type['0']['last_name'], 'employee_id' => $results_enquiry_type['0']['id'], 'Cold' => $cold, 'Hot' => $hot, 'Warm' => $warm, 'New' => $new, 'is_parent' => $parant_id1, 'Total' => $total);

        $response = array("category_wise_report" => $category_wise_team_total);
        echo Json_encode($response);
    }

    public function subSourceReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        print_r($request);
        exit;
        if ($request['source_emp_group'] == 0) {
            $results_enquiry_type = DB::select('CALL proc_enquiry_source_report(' . $request['employee_id'] . ',"' . $request['source_id'] . '","0","0")');
            $result = json_decode(json_encode($results_enquiry_type), true);
        } else {
      
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $request['employee_id'])->whereRaw('FIND_IN_SET(1,department_id)')->get();
            $emp_id = [];
             
            foreach ($selfteam as $selfmember) {
                $this->allusers = array();
                $this->tuserid($selfmember->id);
                $alluser = $this->allusers;
                $alluser[$selfmember->id] = $selfmember->id;
                ksort($alluser);
                foreach ($alluser as $user) {
                    array_push($emp_id, $user);
                }
            }
            $temp = @implode(',', $emp_id);
            if (!empty($temp)) {
                $employee_id = $request['employee_id'] . "," . $temp;
            } else {
                $employee_id = $request['employee_id'];
            }
             
            $results_enquiry_type = DB::select('CALL proc_enquiry_source_report("' . $employee_id . '","' . $request['source_id'] . '","0","0")');
            $result = json_decode(json_encode($results_enquiry_type), true); //response in array
        }
        $response = array("sub_source" => $result);
        return json_encode($response);
        exit;
    }

    public function getEmpFollowUpReports() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();
        $condition = '';
        if (!empty($request['from_date']) && !empty($request['to_date']) && $request['to_date'] != "0000-00-00") {
            $from_date = date('Y-m-d', strtotime($request['from_date']));
            $to_date = date('Y-m-d', strtotime($request['to_date']));
            $condition .= "(ef.`next_followup_date` BETWEEN '$from_date' AND '$to_date')";
        }
        if (!empty($request['flag'])) {
            $flag = $request['flag'];
        } else {
            $flag = 0;
        }
        $parant_id = '';
        $parant_id = $this->isParant($first_admin_model->id);

        if ($flag == 0) {
            $top_query = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id = $emp_id GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
        } else {
            if (!empty($condition)) {
                $top_query = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id = $emp_id AND $condition GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
            } else {
                $top_query = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id = $emp_id GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
            }
        }
        $totacount = DB::select($top_query);
        $sameday = 0;
        $seconday = 0;
        $thirdday = 0;
        $afterthirdday = 0;
        $total = 0;
        $followupreportlist['sameday'] = $sameday;
        $followupreportlist['secondday'] = $seconday;
        $followupreportlist['thirdday'] = $thirdday;
        $followupreportlist['afterthirdday'] = $afterthirdday;
        if (!empty($totacount)) {
            foreach ($totacount as $row) {
                $followup[$row->followupdate_diff_in_days] = $row->followupdate_diff_in_days_cnt;
            }
            if (!empty($followup)) {

                foreach ($followup as $key1 => $value1) {

                    if ($key1 == 0) {
                        $sameday = $sameday + $value1;
                    }
                    if ($key1 == 1) {
                        $seconday = $seconday + $value1;
                    }
                    if ($key1 == 2) {
                        $thirdday = $thirdday + $value1;
                    }
                    if ($key1 >= 3) {
                        $afterthirdday = $afterthirdday + $value1;
                    }
                }
                $followupreportlist['sameday'] = $sameday;
                $followupreportlist['secondday'] = $seconday;
                $followupreportlist['thirdday'] = $thirdday;
                $followupreportlist['afterthirdday'] = $afterthirdday;
                $total = $sameday + $seconday + $thirdday + $afterthirdday;
            } else {
                $followupreportlist['sameday'] = $sameday;
                $followupreportlist['secondday'] = $seconday;
                $followupreportlist['thirdday'] = $thirdday;
                $followupreportlist['afterthirdday'] = $afterthirdday;
            }
        }
        $team_follwup[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'sameday' => $followupreportlist['sameday'], 'secondday' => $followupreportlist['secondday'], 'thirdday' => $followupreportlist['thirdday'], 'afterthirdday' => $followupreportlist['afterthirdday'], 'total' => $total);


        if (!empty($employeeids)) {
            $emp_ids = explode(',', $employeeids);
            $selfteam = \App\Models\backend\Employee::whereIN('id', $emp_ids)->whereRaw('FIND_IN_SET(1,department_id)')->get();
        } else {
            $selfteam = \App\Models\backend\Employee::where(['team_lead_id' => $emp_id])->whereRaw('FIND_IN_SET(1,department_id)')->get();
        }

        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;

            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            $parant_id1 = 0;
            $parant_id1 = $this->isParant($selfmember->id);
            if (!empty($temp)) {
                if ($flag == 0) {
                    $top_query = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id IN($temp) GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
                } else {
                    if (!empty($condition)) {
                        $top_query = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id IN($temp) AND $condition GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
                    } else {
                        $top_query = "SELECT DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`) as followupdate_diff_in_days, count(DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)) as followupdate_diff_in_days_cnt FROM `enquiry_followups` ef, enquiries e WHERE ef.`enquiry_id`=e.id AND e.sales_employee_id IN($temp) GROUP BY DATEDIFF(ef.`next_followup_date`,ef.`followup_date_time`)";
                    }
                }

                $totacount1 = DB::select($top_query);

                $sameday = 0;
                $seconday = 0;
                $thirdday = 0;
                $afterthirdday = 0;
                $mtotal = 0;
                $followup1 = array();
                $followupreportlist1 = array();
                $followupreportlist1['sameday'] = $sameday;
                $followupreportlist1['secondday'] = $seconday;
                $followupreportlist1['thirdday'] = $thirdday;
                $followupreportlist1['afterthirdday'] = $afterthirdday;

                if (!empty($totacount1)) {
                    foreach ($totacount1 as $row1) {
                        $followup1[$row1->followupdate_diff_in_days] = $row1->followupdate_diff_in_days_cnt;
                    }
                    if (!empty($followup1)) {

                        foreach ($followup1 as $key1 => $value1) {

                            if ($key1 == 0) {
                                $sameday = $sameday + $value1;
                            }
                            if ($key1 == 1) {
                                $seconday = $seconday + $value1;
                            }
                            if ($key1 == 2) {
                                $thirdday = $thirdday + $value1;
                            }
                            if ($key1 >= 3) {
                                $afterthirdday = $afterthirdday + $value1;
                            }
                        }

                        $followupreportlist1['sameday'] = $sameday;
                        $followupreportlist1['secondday'] = $seconday;
                        $followupreportlist1['thirdday'] = $thirdday;
                        $followupreportlist1['afterthirdday'] = $afterthirdday;
                        $mtotal = $sameday + $seconday + $thirdday + $afterthirdday;
                    }
                }
                $team_follwup[] = array('name' => $selfmember->first_name . ' ' . $selfmember->last_name, 'employee_id' => $selfmember->id, 'is_parent' => $parant_id1, 'sameday' => $followupreportlist1['sameday'], 'secondday' => $followupreportlist1['secondday'], 'thirdday' => $followupreportlist1['thirdday'], 'afterthirdday' => $followupreportlist1['afterthirdday'], 'total' => $mtotal);
            }
        }
        $response = array("Teams_followups" => $team_follwup);
        echo Json_encode($response);
    }

    public function getEmpStatusreports() {
        $response = array();
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_id = $request["employee_id"];
        if (empty($request['login_id'])) {
            $login_id = Auth::guard('admin')->user()->id;
        } else {
            $login_id = $request['login_id'];
        }
        $condition = '';

        if (!empty($request['flag'])) {
            $flag1 = $request['flag'];
        } else {
            $flag1 = 0;
        }
        $first_admin_model = \App\Models\backend\Employee::where('id', $emp_id)->first();

        if ($emp_id == $login_id) {

            $results_enquiry_type = DB::select('CALL proc_enquiry_status_report("' . $emp_id . '","0","","",0,"")');
            $results_enquiry_type = json_decode(json_encode($results_enquiry_type), true);
            $total = 0;
            $parant_id = '';
            $parant_id = $this->isParant($results_enquiry_type['0']['id']);
            $counting[] = array('open' => $results_enquiry_type['0']['Open'], 'booked' => $results_enquiry_type['0']['Booked'], 'lost' => $results_enquiry_type['0']['Lost'], 'new' => $results_enquiry_type['0']['New'], 'preserved' => $results_enquiry_type['0']['Preserved'], 'total' => $total);
        }
        $selfteam = \App\Models\backend\Employee::where(['team_lead_id' => $emp_id])->whereRaw('FIND_IN_SET(1,department_id)')->get();

        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;
            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            $temp = @implode(',', $alluser);
            if (!empty($temp)) {
                $results_status_wise = DB::select('CALL proc_enquiry_status_report("' . $temp . '","0","","",0,"")');
                $results_status_wise = json_decode(json_encode($results_status_wise), true);

                $m_total = 0;
                foreach ($results_status_wise as $status) {

                    $parant_id1 = 0;
                    $parant_id1 = $this->isParant($status['id']);
                    $m_total = $status['Open'] + $status['Booked'] + $status['Lost'] + $status['New'] + $status['Preserved'];
                    $counting[] = array('open' => $status['Open'], 'booked' => $status['Booked'], 'lost' => $status['Lost'], 'new' => $status['New'], 'preserved' => $status['Preserved'], 'total' => $m_total);
                }
            }
        }

        $open = 0;
        $booked = 0;
        $lost = 0;
        $new = 0;
        $preserved = 0;
        $total = 0;
        foreach ($counting as $count) {
            $open += $count['open'];
            $booked += $count['booked'];
            $lost += $count['lost'];
            $new += $count['new'];
            $preserved += $count['preserved'];
            $total += $count['total'];
        }
        $status_wise_team_total[] = array('name' => $first_admin_model->first_name . ' ' . $first_admin_model->last_name, 'employee_id' => $first_admin_model->id, 'is_parent' => $parant_id, 'open' => $open, 'booked' => $booked, 'lost' => $lost, 'new' => $new, 'preserved' => $preserved, 'total' => $total);
        $response = array("status_wise_report" => $status_wise_team_total);
        echo Json_encode($response);
    }

    public function subStatusReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        if ($request['team_lead'] == 0) {
            $results_enquiry_type = DB::select('CALL proc_enquiry_status_report(' . $request['status']['employee_id'] . ',' . $request['status_id'] . ',"","",0,"")');
            $result = json_decode(json_encode($results_enquiry_type), true);
        } else {
            $selfteam = \App\Models\backend\Employee::where('team_lead_id', $request['status']['employee_id'])->whereRaw('FIND_IN_SET(1,department_id)')->get();
            $emp_id = [];
            foreach ($selfteam as $selfmember) {
                $this->allusers = array();
                $this->tuserid($selfmember->id);
                $alluser = $this->allusers;
                $alluser[$selfmember->id] = $selfmember->id;
                ksort($alluser);
                foreach ($alluser as $user) {
                    array_push($emp_id, $user);
                }
            }

            $temp = @implode(',', $emp_id);
            if (!empty($temp)) {
                $employee_id = $request['status']['employee_id'] . "," . $temp;
            } else {
                $employee_id = $request['status']['employee_id'];
            }
            $results_enquiry_type = DB::select('CALL proc_enquiry_status_report("' . $employee_id . '",' . $request['status_id'] . ',"","",0,"")');
            $result = json_decode(json_encode($results_enquiry_type), true);
        }

        $response = array("sub_status" => $result);
        return json_encode($response);
    }

    public function getSourceWiseGroupReport() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $selfteam = \App\Models\backend\Employee::where('team_lead_id', $request['source']['employee_id'])->whereRaw('FIND_IN_SET(1,department_id)')->get();
        $emp_id = [];
        foreach ($selfteam as $selfmember) {
            $this->allusers = array();
            $this->tuserid($selfmember->id);
            $alluser = $this->allusers;
            $alluser[$selfmember->id] = $selfmember->id;
            ksort($alluser);
            foreach ($alluser as $user) {
                array_push($emp_id, $user);
            }
        }

        $temp = @implode(',', $emp_id);
        if (!empty($temp)) {
            $employee_id = $request['source']['employee_id'] . "," . $temp;
        } else {
            $employee_id = $request['source']['employee_id'];
        }
        $results_enquiry_type = DB::select('CALL proc_enquiry_source_report("' . $employee_id . '","0","0","0")');
        $source = json_decode(json_encode($results_enquiry_type), true); //response in array
        $sourceReport = [];
        foreach ($source as $source) {
            $sales_subsources = DB::table('enquiry_sales_sub_sources')->where('enquiry_sales_source_id', '=', $source['id'])->get();

            if (count($sales_subsources) > 0) {
                $sReport = ['id' => $source['id'], 'sales_source_name' => $source['sales_source_name'], 'cnt' => $source['cnt'], 'substatus' => '1'];
                array_push($sourceReport, $sReport);
            } else {
                $sReport = ['id' => $source['id'], 'sales_source_name' => $source['sales_source_name'], 'cnt' => $source['cnt'], 'substatus' => '0'];
                array_push($sourceReport, $sReport);
            }
        }
        $response = array("source_report" => $sourceReport);
        echo Json_encode($response);
    }

    public function projectOverviewReport() {
        return view('Reports::projectOverviewReport');
    }

    public function overViewReport() {
        $projectList = Project::with('wings')->get();

        if (!empty($projectList)) {
            $result = ['success' => true, 'records' => $projectList];
        } else {
            $result = ['success' => false, 'message' => 'Something Went Wrong'];
        }
        return json_encode($result);
    }

}
