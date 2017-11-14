<?php

namespace App\Modules\Api\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Api\Models\PushApiSetting;
use App\Modules\Api\Models\PushApiErrorNotificationLogs;
use App\Modules\Api\Models\PushApiSettingsLog;
use App\Classes\CommonFunctions;
use Auth;
use App\Modules\Projects\Models\Project;
use App\Models\backend\Employee;
use DB;
use mPDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\S3;
use App\Modules\MasterSales\Models\Enquiry;
use App\Modules\MasterSales\Models\Customer;
use App\Modules\MasterSales\Models\CustomersContact;
use App\Modules\MasterSales\Models\EnquiryFollowup;
use App\Modules\MasterSales\Models\EnquiryDetail;

class ApiController extends Controller {

    public function index() {
        return view("Api::index");
    }

    public function tuserid($id) {

        $admin = \App\Models\backend\Employee::where(['team_lead_id' => $id])->get();

        if (!empty($admin)) {
            $this->allusers[$id] = $id;
            foreach ($admin as $item) {

                $this->allusers[$item->id] = $item->id;

                $this->tuserid($item->id);
            }
        } else {
            return;
        }
    }

    public function listApis() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
        }
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $export = 1;
        } else {
            $export = '';
        }

        $getApilist = array();
        $this->tuserid($emp_id);
        $alluser = $this->allusers;
        $getApilist = PushApiSetting::leftjoin('employees as emp', 'emp.id', '=', 'push_api_settings.employee_id')
                ->orderBy('push_api_settings.id', 'DESC')
                ->select('push_api_settings.*', 'emp.first_name', 'emp.last_name', 'emp.title_id as emp_title_id')
                ->whereIN('push_api_settings.employee_id', $alluser)
                ->get();
        $i = 0;
        foreach ($getApilist as $getApilists) {
            $getApilist[$i]['empName'] = $getApilists['first_name'] . ' ' . $getApilists['last_name'];
            $i++;
        }

        $result = ['success' => true, 'records' => $getApilist, 'export' => $export];
        return json_encode($result);
    }

    public function apiExportToxls() {
        $array = json_decode(Auth::guard('admin')->user()->employee_submenus, true);
        if (in_array('01401', $array)) {
            $result = PushApiSetting::select('api_name', 'key', 'id')->get();
            $getCount = PushApiSetting::select('api_name', 'key', 'id')->get()->count();
            $api = array();
            $j = 1;
            $manageApi = json_decode(json_encode($result), true);
            for ($i = 0; $i < count($manageApi); $i++) {
                $apiData['Sr No'] = $j++;
                $apiData['api_name'] = $manageApi[$i]['api_name'];
                $apiData['key'] = $manageApi[$i]['key'];
                $api[] = $apiData;
            }

            if ($getCount < 1) {
                return false;
            } else {
                Excel::create('Export Api Data', function($excel) use($api) {
                    $excel->sheet('sheet1', function($sheet) use($api) {
                        $sheet->fromArray($api);
                    });
                })->download('csv');
            }
        }
    }

    public function edit($api_id) {
        return view("Api::new")->with(array('apiId' => $api_id));
    }

    public function getemployees() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_ids = explode(',', $request['data']['employee']);
        $resultEmployee = Employee::whereIN('id', $emp_ids)->select('first_name', 'last_name', 'id')->get();

        if (!empty($resultEmployee)) {
            $result = ['success' => true, 'records' => $resultEmployee];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function getEmployeesOther() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $emp_ids = explode(',', $request['data']['employee']);

        $resultEmployee = Employee::whereNOTIN('id', $emp_ids)->select('first_name', 'last_name', 'id')->get();

        if (!empty($resultEmployee)) {
            $result = ['success' => true, 'records' => $resultEmployee];
        } else {
            $result = ['success' => false, 'message' => 'Something went wrong'];
        }
        return json_encode($result);
    }

    public function createApi() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);


        $empl = [];
        foreach ($request['pushApiData']['employee_id'] as $employees) {
            array_push($empl, $employees['id']);
        }
        $request['pushApiData']['employee_id'] = implode(',', $empl);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input = array_merge($request['pushApiData'], $create);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" . time();
        $input['key'] = substr(str_shuffle($chars), 0, 12);
        $pdfName = substr(str_shuffle($chars), 0, 4);

        $mpdf = new \mPDF('c', 'A4', '', '', 0, 0, 10, 10, 0, 0);
        $mpdf->SetDisplayMode('fullpage');
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employee = Employee::where('id', '=', $loggedInUserId)->first();

        $emplEmail = Employee::where('id', '=', $request['pushApiData']['error_notification_email'])->first();

        if (!empty($employee->personal_landline_no)) {
            if ($employee->personal_landline_no != '0') {
                $landline = $employee->personal_landline_no;
            } else {
                $landline = '';
            }
        } else {
            $landline = '';
        }

        $sourcer = [];


        $source = DB::connection('masterdb')->table('mlst_bmsb_enquiry_sales_sources')->get();
        foreach ($source as $source) {
            $subsource = [];
            $sub = DB::table('enquiry_sales_sub_sources')->where('enquiry_sales_source_id', '=', $source->id)->select('sub_source')->get();
            foreach ($sub as $subsrc) {
                array_push($subsource, $subsrc->sub_source);
            }
            $sourceWise = ['source' => $source->sales_source_name, 'subsource' => $subsource];
            array_push($sourcer, $sourceWise);
        }


        if ($request['pushApiData']['first_name_mandatory'] == 1) {
            $first_name_mandatory = 'Mandatory';
        } else {
            $first_name_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['first_name_mandatory'] == 1) {
            $last_name_mandatory = 'Mandatory';
        } else {
            $last_name_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['mobile_number_mandatory'] == 1) {
            $mobile_number_mandatory = 'Mandatory';
        } else {
            $mobile_number_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['email_id_mandatory'] == 1) {
            $email_id_mandatory = 'Mandatory';
        } else {
            $email_id_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['country_code_mandatory'] == 1) {
            $country_code_mandatory = 'Mandatory';
        } else {
            $country_code_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['email_verification'] == 1) {
            $email_verification = 'Mandatory';
        } else {
            $email_verification = 'Not Mandatory';
        }
        if ($request['pushApiData']['mobile_verification'] == 1) {
            $mobile_verification = 'Mandatory';
        } else {
            $mobile_verification = 'Not Mandatory';
        }
        if ($request['pushApiData']['dial_outbound_call'] == 1) {
            $dial_outbound_call = 'Mandatory';
        } else {
            $dial_outbound_call = 'Not Mandatory';
        }
        $sourceSubSource = '';
        if (!empty($sourcer)) {
            foreach ($sourcer as $EnquirySource_row) {
                $sourceSubSource .= "<tr width='98%'><td style='border:1px solid #555;font-size: 16px;border-top:none;'><b>" . $EnquirySource_row['source'] . "</b><span style='color:blue'>(Source)</span></td></tr>";

                if (count($EnquirySource_row['subsource']) > 0) {
                    foreach ($EnquirySource_row['subsource'] as $subsources) {
                        $sourceSubSource .= "<tr width='98%'><td   style='border:1px solid #555;font-size: 16px;border-top:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $subsources . " <span style='color:blue'>(Sub Source)</span></td></tr>";
                    }
                }
            }
        } else {
            $sourceSubSource .= '';
        }



        $api_records = DB::table('push_api_settings')->latest('id')->first();
        $api_record = $api_records->id + 1;
        $source = DB::connection('masterdb')->table('mlst_bmsb_enquiry_sales_sources')->select('sales_source_name', 'id')->first();
        $subsource = DB::table('enquiry_sales_sub_sources')->select('sub_source', 'id')->where('enquiry_sales_source_id', '=', $source->id)->first();
        $sourceName = $source->sales_source_name;
        if (!empty($subsource->enquiry_subsource)) {
            $subsourceName = $subsource->enquiry_subsource;
        } else {
            $subsourceName = '';
        }


        $projects = Project::get();
        $project = '';
        for ($i = 0; $i < count($projects); $i++) {

            $project .= "<tr width='98%'><td style='border:1px solid #555;font-size: 16px;border-top:none;'><b>" . $projects[$i]['project_name'] . "</b><span style='color:blue'>(Project)</span></td></tr>";

            $blocks = DB::table("project_blocks as p")
                    ->join('laravel_developement_master_edynamics.mlst_bmsb_block_types as block', 'block.id', '=', 'p.block_type_id')
                    ->select('block.block_name')
                    ->where('p.project_id', '=', $projects[$i]['id'])
                    ->get();

            if (count($blocks) > 0) {
                foreach ($blocks as $block) {

                    $project .= "<tr width='98%'><td   style='border:1px solid #555;font-size: 16px;border-top:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $block->block_name . " <span style='color:blue'>(Sub Source)</span></td></tr>";
                }
            }
        }
        $projectName = '';
        $projectResult = DB::table('projects')->get();
        if (!empty($projectResult['0']->project_name)) {
            $projectName = $projectResult['0']->project_name;
            $blocksTypes = DB::table("project_blocks as p")
                    ->join('laravel_developement_master_edynamics.mlst_bmsb_block_types as block', 'block.id', '=', 'p.block_type_id')
                    ->select('block.block_name')
                    ->where('p.project_id', '=', $projectResult['0']->id)
                    ->get();
            if (!empty($blocksTypes)) {
                $block_type = $blocksTypes['0']->block_name;
            } else {
                $block_type = '';
            }
        } else {
            $projectName = '';
        }

        $emplEmail = Employee::where('id', '=', $request['pushApiData']['error_notification_email'])->first();
        $client = \App\Models\ClientInfo::where('id', $GLOBALS['client_id'])->first();
        $companyLogo = config('global.s3Path') . '/client/' . $GLOBALS['client_id'] . '/' . $client->company_logo;


        $mpdf->WriteHTML('<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Push Api Documentation</title>
                </head>
                <body>
                    <table width="100%" bgcolor="#fff" align="center" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                        <tbody>
                                            <tr>
                                                <td width="100%" height="10"></td>
                                            </tr>
                                            <tr>
                                                <td width="1000">
                                                    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                        <tbody>
                                                            <tr>
                                                                <td width="500">
                                                                    &nbsp;
                                                                </td>                                                              
                                                                <td width="500" align="right">
                                                                    <p style="text-align: right"><b>BMS API</b></p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </td>
                                            </tr>       
                                            <tr>
                                                <td width="1000">
                                                    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100">
                                                                    <hr style="background: #d6202d;height: 2px;border: none;color:#d6202d;">
                                                                </td>
                                                                <td width="100" align="center">
                                                                    &nbsp;<img src="' . $companyLogo . '" alt="edynamics" width="auto" height="60" />
                                                                </td>
                                                                <td width="800">
                                                                    <hr style="background: #d6202d;height: 2px;border: none;color:#d6202d;">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%">
                                    <table bgcolor="#fff" width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit" >
                                        <tbody>
                                            <tr>
                                                <td width="1000">
                                                    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                        <tbody>
                                                            <tr>
                                                                <td width="1000">
                                                                    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="100%" height="10"></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>
                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td valign="middle" align="left" width="50%" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:left; color:#000" class="logo">
                                                                                                    <div>
                                                                                                        <p><b>Document For &nbsp;:&nbsp;</b>' . $request['pushApiData']['api_name'] . ' </p>
                                                                                                    </div>
                                                                                                </td>
                                                                                                <td width="10%">&nbsp;</td>
                                                                                                <td valign="middle" align="right" width="20%" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:right; color:#000" class="logo">
                                                                                                    <div>
                                                                                                        <p><b>API Key  &nbsp;:&nbsp;</b>' . $input['key'] . ' </p>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>                                                                               
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <table width="80%" cellpadding="0" cellspacing="0" border="0" align="left" class="devicewidth">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td valign="middle" align="left" width="20%"  style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:left; color:#000" class="logo">
                                                                                                    <div>
                                                                                                        <p><b>Document Generated On  &nbsp;:&nbsp;</b>' . date('d-m-Y h:i:s A') . '   <b>By </b>' . Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name . '</p>
                                                                                                    </div>
                                                                                                </td>

                                                                                            </tr>                                                                               
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <table width="100%" style="font-size: 16px;" cellpadding="0" cellspacing="0" border="0" align="left" class="devicewidth">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td  valign="middle" align="left" width="100%" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:left; color:#000" class="logo">
                                                                                                   <p><b>Example Url</b>: http://' . $_SERVER['SERVER_NAME'] . ':8000/api/pushapi/BmsPushApi?<b>api_record=' . $api_record . '</b>&<b>secret_key=' . trim($input['key']) . '</b>&<b>first_name=' . $employee->first_name . '</b>&</p>
                                                                                                   <p><b>last_name=' . $employee->last_name . '</b>&<b>country_code=</b>91&<b>mobile_no=</b>' . $employee->personal_mobile1 . '&<b>mobile_no_verification_status=</b>0&<b>landline=</b>' . $landline . '&<b>email_id=</b></p> 
                                                                                                       <p>' . $employee->personal_email1 . '&<b>email_id_verification_status=</b>0&<b>source=' . $sourceName . '</b>&<b>sub_source=</b>' . $subsourceName . '&<b>source_description=</b>testing enquiry by ' . $employee->first_name . ' ' . $employee->last_name . '&<b>referrer_mobile_number=</b>' . $employee->personal_mobile1 . '&<b>campaign_country=</b></p>
                                                                                                      <p>india&<b>campaign_state</b>=Maharashtra&<b>campaign_city=</b>Mumbai&<b>campaign_id=</b>campaing1234&<b>campaign_keyword= ' . $keywords_name . '</b>&<b>campaign_device=' . $device_name . '</b>&<b>campaign_placement=</b>' . $placement_name . '&<b>project_name=</b>' . $projectName . '&<b>block_type=</b>' . $block_type . '&<b>remarks=</b>test&</p>
                                                                                                      <p><b>ip_address=</b>' . $_SERVER['REMOTE_ADDR'] . '&<b>other_1=</b>test&<b>other_2=</b>test&<b>other_3=</b>test</b></p> 
                                                                                                </td>
                                                                                            </tr>                                                                               
                                                                                                                </tbody>
                                                                                                                </table>
                                                                                                                </td>
                                                                                                                </tr>

                                                                                                                <tr>
                                                                                                                    <td>
                                                                                                                        <!-- logo -->
                                                                                                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" align="left" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td  align="left" width="100%" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:left; color:#000" class="logo">
                                                                                                                                        <div>
                                                                                                                                            <p><b>Parameters With Description  &nbsp;:&nbsp;</b> </p>
                                                                                                                                        </div>
                                                                                                                                    </td>

                                                                                                                                </tr>                                                                               
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                                </table>
                                                                                                                </td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                                </table>
                                                                                                                </td>
                                                                                                                </tr>
                                                                                                                </tbody>
                                                                                                                </table>
                                                                                                                </td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="center" style="background: #d6202d; color: #fff;">
                                                                                                                                                    <th style="border:1px solid #555; color: #fff;">Parameters</th>
                                                                                                                                                    <th style="border:1px solid #555; color: #fff;">Description</th>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%"  style="border:1px solid #555; font-size: 16px;border-top:none;">
                                                                                                                                                        <b>api_record</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>This is system generated parameter please do not change, keep it as it is for this API.</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%"  style="border:1px solid #555; font-size: 16px;border-top:none;">
                                                                                                                                                        <b>secret_key</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Please refer the example URL or Top right corner of the document</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>first_name</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>First name of the customer</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>last_name</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Last name of the customer</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>country_code</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Country code <span style="color:blue">(Ex. Country code for INDIA is 91)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>mobile_no</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Mobile number  (Numeric)
                                                                                                                                                        </span>
                                                                                                                                                        <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.6)</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>mobile_no_verification_status</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span> This is a flag which defines the mobile number is verified or not by default this is set = 0 if the mobile number is verified = 1
                                                                                                                                                            in this parameter </span>

                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>landline</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Landline number <span style="color:blue">(Numeric With STD code)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>email_id</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Email id <span style="color:blue">(Proper Format Ex. test@gmail.com)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>email_id_verification_status</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span> This is a flag which defines the email id is verified or not by default this is set = 0 if the email id is verified = 1
                                                                                                                                                            in this parameter </span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>source</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Source name</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>sub_source</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Sub source name</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>source_description</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Description about source</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>referrer_mobile_number</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Mobile number of a person who is referring this customer</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_country</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Country of campaign <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.1)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_state</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>State of campaign <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.1)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_city</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>City of campaign <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.1)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_id</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Campaigning id of your social media campaigning</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_keyword</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Keyword of the campaign for which you got this click/conversion <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.2)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_placement</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Placement of the campaign for which you got this click/conversion <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.3)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_device</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Device of the campaign <span style="color:blue">(Ex. Web browser,Mobile browser,Mobile app)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>

                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>project_name</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Name of the project <span style="color:blue">(Value from the project list given below)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>block_type</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Name of the block type <span style="color:blue">(Value from the block type list given below)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>remarks</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Remarks of the customer</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>ip_address</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>IP address of the web page visitor who filling the form </span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr> 

                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>other1</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Optional 1</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>other2</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Optional 2</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>other3</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Optional 3</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>   
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <div >    
                                                                                                                            <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td width="980">
                                                                                                                                            <table width="100%" bgcolor="#fff"  align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit" >
                                                                                                                                                <tbody>
                                                                                                                                                    <tr align="center" style="background: #d6202d; color: #fff;">
                                                                                                                                                        <th style="border:1px solid #555;  font-size: 16px; color: #fff;">List of source & subsource in BMS</th>
                                                                                                                                                    </tr>
                                                                                                                                                </tbody>
                                                                                                                                            </table>
                                                                                                                                        </td>
                                                                                                                                    </tr>' . $sourceSubSource . '
                                                                                                                            </table>
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td width="100%" height="10"></td>
                                                                                                                                    </tr>
                                                                                                                                    <br/><br/><br/>
                                                                                                                                    <tr>
                                                                                                                                        <td width="1000">

                                                                                                                                            <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                                <tbody>
                                                                                                                                                    <tr align="center" style="background: #d6202d; color: #fff;">
                                                                                                                                                        <th style="border:1px solid #555;font-size: 16px; color: #fff;">List of projects & block types</th>
                                                                                                                                                    </tr>' . $project . '
                                                                                                                                                </tbody>
                                                                                                                                            </table>

                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </div>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr> <br/><br/>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" >
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="left" >
                                                                                                                                                    <td><b style="font-family: Helvetica, Arial, sans-serif;">Settings currently applicable for this API &nbsp;:&nbsp;</b></td>
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>

                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>   
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                            <tbody>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer First Name </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $first_name_mandatory . '</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Last Name </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $last_name_mandatory . '</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Last Name </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $country_code_mandatory . '</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Mobile Number </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $mobile_number_mandatory . '</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Mobile Number 10 Digit Minimum & Maximum Validation</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Mandatory</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Mobile Number First Digit Should Be Start With 9 or 8 or 7 Validation </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Mandatory</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Email Id </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $email_id_mandatory . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Source </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Mandatory</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Sub Source</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Mandatory</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Mobile Number Verification</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $mobile_verification . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Email Id Verification</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $email_verification . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>


                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Dial Outbound Call On Receiving Enquiry</b>

                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $dial_outbound_call . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>               


                                                                                                                                            </tbody>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>   
                                                                                                                <!-- error codes--><br/><br/>
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">
                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" >
                                                                                                                                            <tbody>
                                                                                                                                                <tr align="left" >
                                                                                                                                                    <td><b style="font-family: Helvetica, Arial, sans-serif;font-size: 16px;">Error Codes : 
                                                                                                                                                            <br> Note:</b> Error related emails will be sent to ' . $emplEmail->personal_email1 . '
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>    
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr><br/><br/><br/>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">
                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                            <tbody>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <th width="60" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Error Code</b>
                                                                                                                                                    </th>
                                                                                                                                                    <th width="920" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Description</span>
                                                                                                                                                    </th>

                                                                                                                                                </tr>

                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="60" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>401</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="920" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>BMS API disabled or secret key is wrong</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="60" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>500</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="920" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Value for one or multiple parameters is not provided</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="60" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>200</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="920" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Enquiry inserted successfully</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>

                                                                                                                                            </tbody>
                                                                                                                                        </table>

                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>    

                                                                                                                <!-- end error codes -->
                                                                                                                <!-- start developers -->
                                                                                                                <br/><br/><br/><br/><br/>
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" >
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="left" >
                                                                                                                                                    <td><b style="font-family: Helvetica, Arial, sans-serif;font-size: 16px;">Developers Guidelines :</b></td>
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>

                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>    

                                                                                                                <tr>
                                                                                                                    <td width="100%">

                                                                                                                        <table width="980" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="98%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="980">
                                                                                                                                        <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" >
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="left" >
                                                                                                                                                    <td>
                                                                                                                                                        <div>
                                                                                                                                                            <b> 1.</b><span>.Please refer this URL http://bmsbuilder.in/office.php/bmsPushApi/list?secret_key=c23EXsh3DN5u Send values for campaigning
country, campaigning state, campaigning city from database only. Value should be matching to the database value which is available for
your reference on the URL.  </span>
                                                                                                                                                            <b><br>2.</b><span>Please refer this URL http://bmsbuilder.in/office.php/bmsPushApi/list_keyword?secret_key=c23EXsh3DN5u Send values for
campaigning keywords from database only. Value should be matching to the database value which is available for your reference on the
URL.</span>
                                                                                                                                                            <b> <br>3.</b><span>Please refer this URL http://bmsbuilder.in/office.php/bmsPushApi/list_placement?secret_key=c23EXsh3DN5u Send values for
campaigning placement from database only. Value should be matching to the database value which is available for your reference on
the URL.</span>
                                                                                                                                                            <b> <br>4.</b><span>Refer the above parameters guidelines or Settings currently applicable for this API section properly to apply mandatory validations on
your form fields.</span> 
                                                                                                                                                            <br><b>5.</b><span>To verify customers mobile number or email id, there is no need to implement or integrate any thing from your side. Verification sms
and emails will be sent from the BMS system automatically and when customer clicks on the verification link email id or mobile number
will be flagged as verified directly</span>
                                                                                                                                                                <br><b>6.</b><span>Please note that if you send mobile number with country code as +91 (India) then mobile number should be 10 characters, system will
not accept less or more characters then 10. But if you are sending any other country code then +91 (India), you are allowed so send 12
characters in mobile number field. Please apply your form validations as per the same.</span>
                                                                                                                                                                    </div> 
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>    

                                                                                                                                                                    <!-- developer -->


                                                                                                                                                                    <tr>
                                                                                                                                                                        <td width="98%">
                                                                                                                                                                            <table width="980px" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                                                                                <tbody>
                                                                                                                                                                                    <tr>
                                                                                                                                                                                        <td width="100%" height="30">&nbsp;</td>
                                                                                                                                                                                    </tr>
                                                                                                                                                                                    <tr>
                                                                                                                                                                                        <td width="980">
                                                                                                                                                                                            <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                                                                                                                                                                <tbody>
                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                        <td colspan="3">
                                                                                                                                                                                                        <b>BMS API</b>
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                    </tr>    
                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                        <td width="850">
                                                                                                                                                                                                        <hr style="background: #d6202d;height: 2px;border: none;color:#d6202d;">
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        <td width="50" align="center">
                                                                                                                                                                                                        &nbsp;<img src="' . $companyLogo . '" alt="edynamics" width="auto" height="30" />
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        <td width="100">
                                                                                                                                                                                                        <hr style="background: #d6202d;height: 2px;border: none;color:#d6202d;">
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                </tbody>
                                                                                                                                                                                            </table>

                                                                                                                                                                                        </td>
                                                                                                                                                                                    </tr>
                                                                                                                                                                                </tbody>
                                                                                                                                                                            </table>
                                                                                                                                                                        </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                    </body>
                                                                                                                                                                    </html>');

        $mpdf->SetHTMLFooter();
        $mpdf->Output(base_path() . "/common/api-" . $pdfName . ".pdf", "F");
        $folderName = "Push-Apis";
        $fileName = S3::s3FileUpload(base_path() . "/common/api-" . $pdfName . ".pdf", "api-" . $pdfName . ".pdf", $folderName);
        $filePath = config('global.s3Path') . "/" . $folderName . "/" . $fileName;
        $input['pdf_name'] = "api-" . $pdfName . ".pdf";
        $result = PushApiSetting::create($input);

        $last3 = PushApiSetting::latest('id')->first();
        $input['main_record_id'] = $last3->id;
        $input['record_type'] = 1;
        $result1 = PushApiSettingsLog::create($input);

        if (!empty($result)) {
            $result = ['success' => true, 'message' => 'Api created successfully'];
            return json_encode($result);
        } else {
            $result = ['success' => true, 'message' => 'something went wrong'];
            return json_encode($result);
        }
    }

    public function updateApi() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $empl = [];
        foreach ($request['pushApiData']['employee_id'] as $employees) {
            array_push($empl, $employees['id']);
        }
        $request['pushApiData']['employee_id'] = implode(',', $empl);
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input = array_merge($request['pushApiData'], $create);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" . time();
        $pdfName = substr(str_shuffle($chars), 0, 4);
        $mpdf = new \mPDF('c', 'A4', '', '', 0, 0, 10, 10, 0, 0);
        $mpdf->SetDisplayMode('fullpage');
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $employee = Employee::where('id', '=', $loggedInUserId)->first();
        $emplEmail = Employee::where('id', '=', $request['pushApiData']['error_notification_email'])->first();
        $secretkey = $request['pushApiData']['key'];

        if (!empty($employee->personal_landline_no)) {
            if ($employee->personal_landline_no != '0') {
                $landline = $employee->personal_landline_no;
            } else {
                $landline = '';
            }
        } else {
            $landline = '';
        }

        $sourcer = [];


        $source = DB::connection('masterdb')->table('mlst_bmsb_enquiry_sales_sources')->get();
        foreach ($source as $source) {
            $subsource = [];
            $sub = DB::table('enquiry_sales_sub_sources')->where('enquiry_sales_source_id', '=', $source->id)->select('sub_source')->get();
            foreach ($sub as $subsrc) {
                array_push($subsource, $subsrc->enquiry_subsource);
            }
            $sourceWise = ['source' => $source->sales_source_name, 'subsource' => $subsource];
            array_push($sourcer, $sourceWise);
        }

        if ($request['pushApiData']['first_name_mandatory'] == 1) {
            $first_name_mandatory = 'Mandatory';
        } else {
            $first_name_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['first_name_mandatory'] == 1) {
            $last_name_mandatory = 'Mandatory';
        } else {
            $last_name_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['mobile_number_mandatory'] == 1) {
            $mobile_number_mandatory = 'Mandatory';
        } else {
            $mobile_number_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['email_id_mandatory'] == 1) {
            $email_id_mandatory = 'Mandatory';
        } else {
            $email_id_mandatory = 'Not Mandatory';
        }
        if ($request['pushApiData']['email_verification'] == 1) {
            $email_verification = 'Mandatory';
            $email_veri = 1;
        } else {
            $email_verification = 'Not Mandatory';
            $email_veri = 0;
        }
        if ($request['pushApiData']['mobile_verification'] == 1) {
            $mobile_verification = 'Mandatory';
            $mob_veri = 1;
        } else {
            $mobile_verification = 'Not Mandatory';
            $mob_veri = 0;
        }
        if ($request['pushApiData']['dial_outbound_call'] == 1) {
            $dial_outbound_call = 'Mandatory';
        } else {
            $dial_outbound_call = 'Not Mandatory';
        }
        $sourceSubSource = '';
        if (!empty($sourcer)) {
            foreach ($sourcer as $EnquirySource_row) {

                $sourceSubSource .= "<tr><td style='border:1px solid #555;font-size: 16px;border-top:none;'><b>" . $EnquirySource_row['source'] . "</b><span style='color:blue'>(Source)</span></td></tr>";

                if (count($EnquirySource_row['subsource']) > 0) {
                    foreach ($EnquirySource_row['subsource'] as $subsources) {

                        $sourceSubSource .= "<tr><td   style='border:1px solid #555;font-size: 16px;border-top:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $subsources . " <span style='color:blue'>(Sub Source)</span></td></tr>";
                    }
                }
            }
        } else {
            $sourceSubSource .= '';
        }


        $projects = Project::get();
        $project = '';
        for ($i = 0; $i < count($projects); $i++) {

            $project .= "<tr width='98%'><td style='border:1px solid #555;font-size: 16px;border-top:none;'><b>" . $projects[$i]['project_name'] . "</b><span style='color:blue'>(Project)</span></td></tr>";

            $blocks = DB::table("project_blocks as p")
                    ->join('laravel_developement_master_edynamics.mlst_bmsb_block_types as block', 'block.id', '=', 'p.block_type_id')
                    ->select('block.block_name')
                    ->where('p.project_id', '=', $projects[$i]['id'])
                    ->get();

            if (count($blocks) > 0) {
                foreach ($blocks as $block) {

                    $project .= "<tr width='98%'><td   style='border:1px solid #555;font-size: 16px;border-top:none;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $block->block_name . " <span style='color:blue'>(Sub Source)</span></td></tr>";
                }
            }
        }

        $projectName = '';
        $projectResult = DB::table('projects')->get();
        if (!empty($projectResult['0']->project_name)) {
            $projectName = $projectResult['0']->project_name;


            $blocksTypes = DB::table("project_blocks as p")
                    ->join('laravel_developement_master_edynamics.mlst_bmsb_block_types as block', 'block.id', '=', 'p.block_type_id')
                    ->select('block.block_name')
                    ->where('p.project_id', '=', $projectResult['0']->id)
                    ->get();
            if (!empty($blocksTypes)) {
                $block_type = $blocksTypes['0']->block_name;
            } else {
                $block_type = '';
            }
        } else {
            $projectName = '';
        }

        $placement = DB::table('campaign_placement')->first();

        if (!empty($placement->placement_name)) {
            $placement_name = $placement->placement_name;
        } else {
            $placement_name = '';
        }
        $device = DB::table('campaign_devices')->first();
        if (!empty($device->device_name)) {
            $device_name = $device->device_name;
        } else {
            $device_name = '';
        }
        $keywords = DB::table('campaign_keywords')->first();

        if (!empty($keywords->keywords_name)) {
            $keywords_name = $keywords->keywords_name;
        } else {
            $keywords_name = '';
        }

        $api_record = $request['pushApiData']['id'];
        $source = DB::connection('masterdb')->table('mlst_bmsb_enquiry_sales_sources')->select('sales_source_name', 'id')->first();
        $subsource = DB::table('enquiry_sales_sub_sources')->select('sub_source', 'id')->where('enquiry_sales_source_id', '=', $source->id)->first();

        $sourceName = $source->sales_source_name;
        if (!empty($subsource->enquiry_subsource)) {
            $subsourceName = $subsource->enquiry_subsource;
        } else {
            $subsourceName = '';
        }

        if ($request['pushApiData']['country_code_mandatory'] == 1) {
            $country_code_mandatory = 'Mandatory';
        } else {
            $country_code_mandatory = 'Not Mandatory';
        }

        $client = \App\Models\ClientInfo::where('id', $GLOBALS['client_id'])->first();

        $companyLogo = config('global.s3Path') . '/client/' . $GLOBALS['client_id'] . '/' . $client->company_logo;


        $mpdf->WriteHTML('<html xmlns="http://www.w3.org/1999/xhtml"><head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Push Api Documentation</title>
                </head>
                <body>
                    <table width="100%" bgcolor="#fff" align="center" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader">
                        <tbody>
                            <tr>
                                <td width="100%">
                                    <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                        <tbody>
                                            <tr>
                                                <td width="100%" height="10"></td>
                                            </tr>
                                            <tr>
                                                <td width="1000">
                                                    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                        <tbody>
                                                            <tr>
                                                                <td width="500">
                                                                    &nbsp;
                                                                </td>                                                              
                                                                <td width="500" align="right">
                                                                    <p style="text-align: right"><b>BMS API</b></p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                </td>
                                            </tr>       
                                            <tr>
                                                <td width="1000">
                                                    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100">
                                                                    <hr style="background: #d6202d;height: 2px;border: none;color:#d6202d;">
                                                                </td>
                                                                <td width="100" align="center">
                                                                    &nbsp;<img src="' . $companyLogo . '" alt="edynamics" width="auto" height="60" />
                                                                </td>
                                                                <td width="800">
                                                                    <hr style="background: #d6202d;height: 2px;border: none;color:#d6202d;">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%">
                                    <table bgcolor="#fff" width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit" >
                                        <tbody>
                                            <tr>
                                                <td width="1000">
                                                    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                        <tbody>
                                                            <tr>
                                                                <td width="1000">
                                                                    <table width="1000" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="100%" height="10"></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td>
                                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td valign="middle" align="left" width="50%" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:left; color:#000" class="logo">
                                                                                                    <div>
                                                                                                        <p><b>Document For &nbsp;:&nbsp;</b>' . $request['pushApiData']['api_name'] . ' </p>
                                                                                                    </div>
                                                                                                </td>
                                                                                                <td width="10%">&nbsp;</td>
                                                                                                <td valign="middle" align="right" width="20%" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:right; color:#000" class="logo">
                                                                                                    <div>
                                                                                                        <p><b>API Key  &nbsp;:&nbsp;</b>' . $secretkey . ' </p>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>                                                                               
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <table width="80%" cellpadding="0" cellspacing="0" border="0" align="left" class="devicewidth">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td valign="middle" align="left" width="20%"  style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:left; color:#000" class="logo">
                                                                                                    <div>
                                                                                                        <p><b>Document Generated On  &nbsp;:&nbsp;</b>' . date('d-m-Y h:i:s A') . '   <b>By </b>' . Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name . '</p>
                                                                                                    </div>
                                                                                                </td>

                                                                                            </tr>                                                                               
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    <table width="100%" style="font-size: 16px;" cellpadding="0" cellspacing="0" border="0" align="left" class="devicewidth">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td  valign="middle" align="left" width="100%" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:left; color:#000" class="logo">
                                                                                                   <p><b>Example Url</b>: http://' . $_SERVER['SERVER_NAME'] . ':8000/api/pushapi/BmsPushApi?<b>api_record=' . $api_record . '</b>&<b>secret_key=' . trim($input['key']) . '</b>&<b>first_name=' . $employee->first_name . '</b>&</p>
                                                                                                   <p><b>last_name=' . $employee->last_name . '</b>&<b>country_code=</b>91&<b>mobile_no=</b>' . $employee->personal_mobile1 . '&<b>mobile_no_verification_status=</b>0&<b>landline=</b>' . $landline . '&<b>email_id=</b></p> 
                                                                                                       <p>' . $employee->personal_email1 . '&<b>email_id_verification_status=</b>0&<b>source=' . $sourceName . '</b>&<b>sub_source=</b>' . $subsourceName . '&<b>source_description=</b>testing enquiry by ' . $employee->first_name . ' ' . $employee->last_name . '&<b>referrer_mobile_number=</b>' . $employee->personal_mobile1 . '&<b>campaign_country=</b></p>
                                                                                                      <p>india&<b>campaign_state</b>=Maharashtra&<b>campaign_city=</b>Mumbai&<b>campaign_id=</b>campaing1234&<b>campaign_keyword= ' . $keywords_name . '</b>&<b>campaign_device=' . $device_name . '</b>&<b>campaign_placement=</b>' . $placement_name . '&<b>project_name=</b>' . $projectName . '&<b>block_type=</b>' . $block_type . '&<b>remarks=</b>test&</p>
                                                                                                      <p><b>ip_address=</b>' . $_SERVER['REMOTE_ADDR'] . '&<b>other_1=</b>test&<b>other_2=</b>test&<b>other_3=</b>test</b></p> 
                                                                                                </td>
                                                                                            </tr>                                                                               
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><table width="100%" cellpadding="0" cellspacing="0" border="0" align="left" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td  align="left" width="100%" style="font-family: Helvetica, Arial, sans-serif; font-size: 16px; padding: 10px; text-align:left; color:#000" class="logo">
                                                                                                                                        <div>
                                                                                                                                            <p><b>Parameters With Description  &nbsp;:&nbsp;</b> </p>
                                                                                                                                        </div>
                                                                                                                                    </td>

                                                                                                                                </tr>                                                                               
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                </td>
                                                                                                                                </tr>
                                                                                                                                </tbody>
                                                                                                                                </table>
                                                                                                                                </td>
                                                                                                                                </tr>
                                                                                                                                </tbody>
                                                                                                                                </table>
                                                                                                                                </td>
                                                                                                                                </tr>
                                                                                                                                </tbody>
                                                                                                                                </table>
                                                                                                                                </td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="center" style="background: #d6202d; color: #fff;">
                                                                                                                                                    <th style="border:1px solid #555; color: #fff;">Parameters</th>
                                                                                                                                                    <th style="border:1px solid #555; color: #fff;">Description</th>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%"  style="border:1px solid #555; font-size: 16px;border-top:none;">
                                                                                                                                                        <b>api_record</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>This is system generated parameter please do not change, keep it as it is for this API.</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%"  style="border:1px solid #555; font-size: 16px;border-top:none;">
                                                                                                                                                        <b>secret_key</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Please refer the example URL or Top right corner of the document</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>first_name</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>First name of the customer</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>last_name</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Last name of the customer</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>country_code</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Country code <span style="color:blue">(Ex. Country code for INDIA is 91)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>mobile_no</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Mobile number  (Numeric)
                                                                                                                                                        </span>
                                                                                                                                                        <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.6)</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>mobile_no_verification_status</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span> This is a flag which defines the mobile number is verified or not by default this is set = 0 if the mobile number is verified = 1
                                                                                                                                                            in this parameter </span>

                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>landline</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Landline number <span style="color:blue">(Numeric With STD code)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>email_id</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Email id <span style="color:blue">(Proper Format Ex. test@gmail.com)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>email_id_verification_status</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span> This is a flag which defines the email id is verified or not by default this is set = 0 if the email id is verified = 1
                                                                                                                                                            in this parameter </span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>source</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Source name</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>sub_source</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Sub source name</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>source_description</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Description about source</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>referrer_mobile_number</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Mobile number of a person who is referring this customer</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_country</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Country of campaign <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.1)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_state</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>State of campaign <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.1)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_city</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>City of campaign <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.1)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_id</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Campaigning id of your social media campaigning</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_keyword</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Keyword of the campaign for which you got this click/conversion <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.2)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_placement</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Placement of the campaign for which you got this click/conversion <span style="color:blue">(Please refer <b>Developer Guidelines</b> Point No.3)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>campaign_device</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Device of the campaign <span style="color:blue">(Ex. Web browser,Mobile browser,Mobile app)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>

                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>project_name</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Name of the project <span style="color:blue">(Value from the project list given below)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>block_type</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Name of the block type <span style="color:blue">(Value from the block type list given below)</span></span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>remarks</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Remarks of the customer</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>ip_address</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>IP address of the web page visitor who filling the form </span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr> 

                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>other1</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Optional 1</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>other2</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Optional 2</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <b>other3</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;border-top:none;">
                                                                                                                                                        <span>Optional 3</span>
                                                                                                                                                    </td>                                                   
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>
                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>   
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <div >    
                                                                                                                            <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td width="980">
                                                                                                                                            <table width="100%" bgcolor="#fff"  align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth" modulebg="edit" >
                                                                                                                                                <tbody>
                                                                                                                                                    <tr align="center" style="background: #d6202d; color: #fff;">
                                                                                                                                                        <th style="border:1px solid #555;  font-size: 16px; color: #fff;">List of source & subsource in BMS</th>
                                                                                                                                                    </tr>
                                                                                                                                                </tbody>
                                                                                                                                            </table>

                                                                                                                                        </td>
                                                                                                                                    </tr>' . $sourceSubSource . '
                                                                                                                            </table>
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                                <tbody>
                                                                                                                                    <tr>
                                                                                                                                        <td width="100%" height="10"></td>
                                                                                                                                    </tr>
                                                                                                                                      <br/><br/>
                                                                                                                                    <tr>
                                                                                                                                        <td width="1000"><br/><br/>

                                                                                                                                            <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                                <tbody>
                                                                                                                                                    <tr align="center" style="background: #d6202d; color: #fff;">
                                                                                                                                                        <th style="border:1px solid #555;font-size: 16px; color: #fff;">List of projects & block types</th>
                                                                                                                                                    </tr>' . $project . '
                                                                                                                                                </tbody>
                                                                                                                                            </table>

                                                                                                                                        </td>
                                                                                                                                    </tr>
                                                                                                                                </tbody>
                                                                                                                            </table>
                                                                                                                        </div>
                                                                                                                    </td>
                                                                                                                </tr>


                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <br/><br/>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" >
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="left" >
                                                                                                                                                    <td><b style="font-family: Helvetica, Arial, sans-serif;">Settings currently applicable for this API &nbsp;:&nbsp;</b></td>
                                                                                                                                                </tr>



                                                                                                                                            </tbody>
                                                                                                                                        </table>

                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>   
<br/><br/>
                                                                                                                <tr>
                                                                                                                    <td width="100%"><br/><br/>

                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                            <tbody>


                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer First Name </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $first_name_mandatory . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>

                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Last Name </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $last_name_mandatory . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Last Name </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $country_code_mandatory . '</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Mobile Number </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $mobile_number_mandatory . '</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Mobile Number 10 Digit Minimum & Maximum Validation</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Mandatory</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Mobile Number First Digit Should Be Start With 9 or 8 or 7 Validation </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Mandatory</span>
                                                                                                                                                    </td>
                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Email Id </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $email_id_mandatory . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Source </b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Mandatory</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Customer Sub Source</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Mandatory</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Mobile Number Verification</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $mobile_verification . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Email Id Verification</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $email_verification . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>


                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Dial Outbound Call On Receiving Enquiry</b>

                                                                                                                                                    </td>
                                                                                                                                                    <td width="50%" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>' . $dial_outbound_call . '</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>               


                                                                                                                                            </tbody>
                                                                                                                                        </table>

                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>   
                                                                                                                <!-- error codes--><br/><br/>
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" >
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="left" >
                                                                                                                                                    <td><b style="font-family: Helvetica, Arial, sans-serif;font-size: 16px;">Error Codes : 
                                                                                                                                                            <br> Note:</b> Error related emails will be sent to ' . $emplEmail->personal_email1 . '
                                                                                                                                                    </td>
                                                                                                                                                </tr>



                                                                                                                                            </tbody>
                                                                                                                                        </table>

                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>    


<br/><br/>
                                                                                                                <tr>
                                                                                                                    <td width="100%">

                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" style="font-size:16px;font-family: Helvetica, Arial, sans-serif;">
                                                                                                                                            <tbody>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <th width="60" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>Error Code</b>
                                                                                                                                                    </th>
                                                                                                                                                    <th width="920" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Description</span>
                                                                                                                                                    </th>

                                                                                                                                                </tr>

                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="60" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>401</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="920" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>BMS API disabled or secret key is wrong</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="60" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>500</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="920" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Value for one or multiple parameters is not provided</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>
                                                                                                                                                <tr align="center">
                                                                                                                                                    <td width="60" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <b>200</b>
                                                                                                                                                    </td>
                                                                                                                                                    <td width="920" style="border:1px solid #555;font-size: 16px;">
                                                                                                                                                        <span>Enquiry inserted successfully</span>
                                                                                                                                                    </td>

                                                                                                                                                </tr>

                                                                                                                                            </tbody>
                                                                                                                                        </table>

                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>    

                                                                                                                <!-- end error codes -->
                                                                                                                <!-- start developers -->
                                                                                                                <br/><br/><br/><br/><br/>
                                                                                                                <tr>
                                                                                                                    <td width="100%">
                                                                                                                        <table width="1000" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="100%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="1000">

                                                                                                                                        <table width="980" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" >
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="left" >
                                                                                                                                                    <td><b style="font-family: Helvetica, Arial, sans-serif;font-size: 16px;">Developers Guidelines :</b></td>
                                                                                                                                                </tr>
                                                                                                                                            </tbody>
                                                                                                                                        </table>

                                                                                                                                    </td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>    

                                                                                                                <tr>
                                                                                                                    <td width="100%">

                                                                                                                        <table width="980" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                            <tbody>
                                                                                                                                <tr>
                                                                                                                                    <td width="98%" height="10"></td>
                                                                                                                                </tr>
                                                                                                                                <tr>
                                                                                                                                    <td width="980">
                                                                                                                                        <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner" >
                                                                                                                                            <tbody>

                                                                                                                                                <tr align="left" >
                                                                                                                                                    <td>
                                                                                                                                                        <div>
                                                                                                                                                            <b> 1.</b><span>.Please refer this URL http://bmsbuilder.in/office.php/bmsPushApi/list?secret_key=c23EXsh3DN5u Send values for campaigning
country, campaigning state, campaigning city from database only. Value should be matching to the database value which is available for
your reference on the URL.  </span>
                                                                                                                                                            <b><br>2.</b><span>Please refer this URL http://bmsbuilder.in/office.php/bmsPushApi/list_keyword?secret_key=c23EXsh3DN5u Send values for
campaigning keywords from database only. Value should be matching to the database value which is available for your reference on the
URL.</span>
                                                                                                                                                            <b> <br>3.</b><span>Please refer this URL http://bmsbuilder.in/office.php/bmsPushApi/list_placement?secret_key=c23EXsh3DN5u Send values for
campaigning placement from database only. Value should be matching to the database value which is available for your reference on
the URL.</span>
                                                                                                                                                            <b> <br>4.</b><span>Refer the above parameters guidelines or Settings currently applicable for this API section properly to apply mandatory validations on
your form fields.</span> 
                                                                                                                                                            <br><b>5.</b><span>To verify customers mobile number or email id, there is no need to implement or integrate any thing from your side. Verification sms
and emails will be sent from the BMS system automatically and when customer clicks on the verification link email id or mobile number
will be flagged as verified directly</span>
                                                                                                                                                                <br><b>6.</b><span>Please note that if you send mobile number with country code as +91 (India) then mobile number should be 10 characters, system will
not accept less or more characters then 10. But if you are sending any other country code then +91 (India), you are allowed so send 12
characters in mobile number field. Please apply your form validations as per the same.</span>
                                                                                                                                                                    </div> 
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                    </td>
                                                                                                                                                                    </tr>    

                                                                                                                                                                    <!-- developer -->


                                                                                                                                                                    <tr>
                                                                                                                                                                        <td width="98%">
                                                                                                                                                                            <table width="980px" bgcolor="" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
                                                                                                                                                                                <tbody>
                                                                                                                                                                                    <tr>
                                                                                                                                                                                        <td width="100%" height="30">&nbsp;</td>
                                                                                                                                                                                    </tr>
                                                                                                                                                                                    <tr>
                                                                                                                                                                                        <td width="980">
                                                                                                                                                                                            <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidthinner">
                                                                                                                                                                                                <tbody>
                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                        <td colspan="3">
                                                                                                                                                                                                        <b>BMS API</b>
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                    </tr>    
                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                        <td width="850">
                                                                                                                                                                                                        <hr style="background: #d6202d;height: 2px;border: none;color:#d6202d;">
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        <td width="50" align="center">
                                                                                                                                                                                                        &nbsp;<img src="' . $companyLogo . '" alt="edynamics" width="auto" height="30" />
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                        <td width="100">
                                                                                                                                                                                                        <hr style="background: #d6202d;height: 2px;border: none;color:#d6202d;">
                                                                                                                                                                                                        </td>
                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                </tbody>
                                                                                                                                                                                            </table>

                                                                                                                                                                                        </td>
                                                                                                                                                                                    </tr>
                                                                                                                                                                                </tbody>
                                                                                                                                                                            </table>
                                                                                                                                                                        </td>
                                                                                                                                                                    </tr>
                                                                                                                                                                    </tbody>
                                                                                                                                                                    </table>
                                                                                                                                                                    </body>
                                                                                                                                                                    </html>');

        $mpdf->SetHTMLFooter();
        $mpdf->Output(base_path() . "/common/api-" . $pdfName . ".pdf", "F");
        $folderName = "Push-Apis";
        $fileName = S3::s3FileUpload(base_path() . "/common/api-" . $pdfName . ".pdf", "api-" . $pdfName . ".pdf", $folderName);
        $filePath = config('global.s3Path') . "/" . $folderName . "/" . $fileName;
        $input['pdf_name'] = "api-" . $pdfName . ".pdf";
        $result = PushApiSetting::where('id', '=', $request['pushApiData']['id'])->update($input);


        if (!empty($result)) {
            $result = ['success' => true, 'message' => 'Api created successfully'];
            return json_encode($result);
        } else {
            $result = ['success' => true, 'message' => 'something went wrong'];
            return json_encode($result);
        }
    }

    public function getEmailConfiguration() {
        $res = DB::table('email_configuration')->get();
        if (!empty($res)) {
            $result = ['success' => true, 'result' => $res];
        } else {
            $result = ['success' => true, 'mssg' => "No record found"];
        }
        return json_encode($result);
    }

    public function update($id) {
        return view("Api::update")->with("apiId", $id);
    }

    public function getapiData() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        $getApilist = PushApiSetting::
                where('id', $request['id'])
                ->first();
        if (!empty($getApilist)) {
            $result = ['success' => true, 'result' => $getApilist];
        } else {
            $result = ['success' => true, 'mssg' => "No record found"];
        }
        return json_encode($result);
    }

    public function actionIndex() {
        $key = urldecode($_GET['secret_key']);

        $obj_push_api = PushApiSetting::where('key', '=', $_GET['secret_key'])->where('status', '=', '1')->first();
        if (empty($obj_push_api)) {
            $this->sendResponse(401, 'BMS API disabled or secret key is wrong.', $obj_push_api);
        }
        $bms_push_request_url = "http://" . $_SERVER['SERVER_NAME'] . "/office.php/lmsPushApi?api_record=" . $_GET['api_record'] . "&secret_key=" . $_GET['secret_key'] . "&first_name=" . $_GET['first_name'] . "&last_name=" . $_GET['last_name']
                . "&country_code=" . $_GET['country_code'] . "&mobile_no=" . $_GET['mobile_no'] . "&mobile_no_verification_status=" . $_GET['mobile_no_verification_status'] . "&landline=" . $_GET['landline'] . "&email_id=" . $_GET['email_id'] . "&email_id_verification_status=" . $_GET['email_id_verification_status'] . "&source=" . $_GET['source']
                . "&sub_source=" . $_GET['sub_source'] . "&source_description=" . $_GET['source_description'] . "&referrer_mobile_number=" . $_GET['referrer_mobile_number'] . "&campaign_country=" . $_GET['campaign_country'] . "&"
                . "campaign_state=" . $_GET['campaign_state'] . "&campaign_city=" . $_GET['campaign_city'] . "&campaign_id=" . $_GET['campaign_id']
                . "&campaign_keyword=" . $_GET['campaign_keyword'] . "&campaign_device=" . $_GET['campaign_device'] . "&campaign_placement=" . $_GET['campaign_placement']
                . "&project_name=" . $_GET['project_name'] . "&block_type=" . $_GET['block_type'] . "&remarks=" . $_GET['remarks'] . "&ip_address=" . $_GET['ip_address'] . "&other_1=" . $_GET['other_1'] . "&other_2=" . $_GET['other_2'] . "&other_3=" . $_GET['other_3'];

        $_GET['requested_url'] = "'" . $bms_push_request_url . "'";

        if (!empty($obj_push_api)) {
            if ($obj_push_api->first_name_mandatory == 1 && empty(@trim($_GET['first_name']))) {
                $this->sendResponse(500, 'Customer First Name Not Found.', $obj_push_api, $_GET);
            }
            if (!empty($obj_push_api->last_name_mandatory) && (empty(@trim($_GET['last_name'])))) {

                $this->sendResponse(500, 'Customer Last Name Not Found.', $obj_push_api, $_GET);
            }
            $mobile_no = trim($_GET['mobile_no']);
            $country_code = trim($_GET['country_code']);

            if ($obj_push_api->mobile_number_mandatory == 1 && empty($mobile_no)) {
                $this->sendResponse(500, 'Customer Mobile Number Not Found.', $obj_push_api, $_GET);
            } else {
                if ($country_code != '91' && $country_code != '') {
                    $mobile_no = substr($mobile_no, -12);
                    if (!is_numeric($mobile_no)) {
                        $this->sendResponse(500, 'Customer Mobile number validation failure. Please send proper mobile number and try again.', $obj_push_api, $_GET);
                    } else {
                        $_GET['mobile_no'] = $mobile_no;
                    }
                } else if (preg_match('/^[0-9]{10}+$/', $mobile_no) == '0') {
                    $this->sendResponse(500, 'Customer Mobile number validation failure. Please send proper mobile number and try again.', $obj_push_api, $_GET);
                }
            }

            $email_id = trim($_GET['email_id']);
            if (empty($email_id) && $obj_push_api->email_id_mandatory == 1) {
                $this->sendResponse(500, 'Customer Email id Not Found.', $obj_push_api, $_GET);
            } else if (empty(filter_var($email_id, FILTER_VALIDATE_EMAIL))) {
                $this->sendResponse(500, 'Customer Email id validation failure. Please send proper email id and try again.', $obj_push_api, $_GET);
            }
            if (!empty($_GET['source'])) {
                $source = urldecode($_GET['source']);
                $source = trim($source);
                $source = DB::connection('masterdb')->table('mlst_bmsb_enquiry_sales_sources')->where('sales_source_name', '=', $_GET['source'])->first();

                if (!empty($source)) {
                    $_GET['source'] = $source->id;
                } else {
                    $this->sendResponse(500, 'Enquiry Source Not Match.', $obj_push_api, $_GET);
                }
            } else {
                $this->sendResponse(500, 'Enquiry Source Not Found.', $obj_push_api, $_GET);
            }
            if (preg_match('/www\.|http:|ftp:|https:/', $_GET['remarks']) || preg_match('/script|Script/', $_GET['remarks'])) {
                $this->sendResponse(500, 'Please send proper remarks', $obj_push_api, $_GET);
            } else {
                $_GET['remarks'] = strip_tags($_GET['remarks']);
            }
            if (!empty($_GET['sub_source'])) {
                $sub_source = urldecode($_GET['sub_source']);
                $sub_source = trim($sub_source);
                $subsource = DB::table('enquiry_sales_subsources')->where('enquiry_subsource', '=', $sub_source)->first();
                if (!empty($subsource)) {
                    $_GET['sub_source'] = $subsource->id;
                }
            }
            if (!empty($_GET['project_name'])) {
                $project_name = urldecode($_GET['project_name']);
                $project_name = trim($project_name);

                $project = DB::table('projects')->where('project_name', '=', $project_name)->first();

                if (!empty($project)) {
                    $_GET['project_id'] = $project->id;
                }
            }
            if (!empty($_GET['campaign_keyword'])) {
                $campaign_keyword = urldecode($_GET['campaign_keyword']);
                $campaign_keyword = trim($campaign_keyword);

                $obj_keywords = DB::table('campaign_keywords')->where('keywords_name', '=', $campaign_keyword)->first();
                if (!empty($obj_keywords)) {
                    $_GET['campaign_keyword'] = $obj_keywords->id;
                } else {
                    $_GET['campaign_keyword'] = '';
                }
            }
            if (!empty($_GET['campaign_device'])) {
                $campaign_device = urldecode($_GET['campaign_device']);
                $campaign_device = trim($campaign_device);
                $obj_device = DB::table('campaign_devices')->where('device_name', '=', $campaign_device)->first();
                if (!empty($obj_device)) {
                    $_GET['campaign_device'] = $obj_device->id;
                } else {
                    $_GET['campaign_device'] = $obj_device->id;
                }
            }
            if (!empty($_GET['campaign_placement'])) {
                $campaign_placement = urldecode($_GET['campaign_placement']);
                $campaign_placement = trim($campaign_placement);
                $obj_placement = DB::table('campaign_placement')->where('placement_name', '=', $campaign_placement)->first();

                if (!empty($obj_placement)) {
                    $_GET['campaign_placement'] = $obj_placement->id;
                } else {
                    $_GET['campaign_placement'] = '';
                }
            }
            $enquiry_object = $this->operation($_GET, $obj_push_api, $project);


            if (!empty($_GET['other_1']) && !empty($_GET['other_2'])) {
//                $enquiry_project_obj = Enquiry::join('enquiry_details as detail', 'detail.enquiry_id', '=', 'enquiries.id')->where('enquiry_id', '=', $enquiry_object->enquiry_id)->where('model_id', '=', $project->id);

                $this->sendResponse(200, 'Enquiry inserted successfully.', $obj_push_api, $_GET);
            } else {
                $this->sendResponse(200, 'Enquiry inserted successfully.', $obj_push_api, $_GET);
            }
        } else {
            $api_record = $_GET['api_record'];
        }
    }

    private function sendResponse($status, $message, $obj_api, $request) {
        $return['status'] = $status;
        $return['message'] = $message;
        ob_start();
        if ($status != '200') {
            if (!empty($obj_api)) {
                $this->errorNofificationMail($status, $message, $obj_api);
            }
        } else {
            if (!empty($obj_api)) {
                $this->successNofificationMail($status, $message, $obj_api, $request);
            }
        }
        ob_get_clean();
        echo json_encode($return);
        exit;
    }

    public function operation($request, $obj_api, $project) {
        $mobile_no = $request['mobile_no'];
        $email_id = $request['email_id'];
        $source_desc = trim($request['source_description']);
        $source_id = $request['source'];
        $sub_source = $request['sub_source'];
        $remark = $request['remarks'];
        $employeearray = @explode(',', $obj_api->employee_id);
        $employelist = $obj_api->employee_id;
        $followup_info = $obj_api->id;

        $employeeRR = Enquiry::join('enquiry_followups as followup', 'enquiries.id', '=', 'followup.enquiry_id')
                ->whereIN('followup.followup_by_employee_id', array($employelist))
                ->where('followup_entered_through', '=', 4)
                ->select('enquiries.sales_employee_id')
                ->orderBy('enquiries.id', 'DESC')
                ->first();

        $empcount = @count($employeearray) - 1;


        if (!empty($employeeRR)) {
            if (@in_array($employeeRR->sales_employee_id, $employeearray)) {
                $key_position = @array_search($employeeRR->sales_employee_id, $employeearray);
                $temp = $key_position + 1;
                if ($temp > $empcount)
                    $roundRobin = $employeearray[0];
                else
                    $roundRobin = $employeearray[$temp];
            } else
                $roundRobin = $employeearray[0];
        } else
            $roundRobin = $employeearray[0];

        if (empty($roundRobin))
            $roundRobin = $employeearray[0];

        $obj_employee = Employee::where('id', $roundRobin)->first();


        if (!empty($obj_employee)) {

            if (!empty($mobile_no)) {
                $obj_customer = CustomersContact::join('customers as cus', 'cus.id', '=', 'customers_contacts.customer_id')
                        ->where('customers_contacts.mobile_number', '=', $mobile_no)
                        ->first();

                if (empty($obj_customer)) {
                    $obj_customer = CustomersContact::join('customers as cus', 'cus.id', '=', 'customers_contacts.customer_id')
                            ->where('customers_contacts.landline_number', '=', $request['landline'])
                            ->first();
                }
            }
            if (!empty($email_id) && empty($obj_customer)) {
                $obj_customer = CustomersContact::join('customers as cus', 'cus.id', '=', 'customers_contacts.customer_id')
                        ->where('customers_contacts.email_id', '=', $email_id)
                        ->first();
            }
           
            if (!empty($obj_customer)) {

                if ($obj_api->existing_open_customer_action == 1) {
                    $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_desc, $sub_source, $obj_api, $remark);
//                    $this->insertEnquiryModels($obj_enquiry, $project, $request);
                    if (!$request['email_id_verification_status'] && !$request['mobile_no_verification_status']) {
                        
                    }
                    return $obj_enquiry;
                } else {

                    $obj_enquiry = Enquiry::where('customer_id', '=', $obj_customer->customer_id)->orderBy('id', 'desc')->first();
                    $obj_enquiry = '';
                    if (!empty($obj_enquiry)) {
                        $obj_employee = Employee::where('id', '=', $obj_enquiry->sales_employee_id)->first();
//                        $this->insertEnquiryModels($obj_enquiry, $project, $request);

                        if (!$request['email_id_verification_status'] && !$request['mobile_no_verification_status'])
                            return $obj_enquiry;
                    }
                    else {
                        if ($obj_api->existing_lost_customer_action == 1) {
                            $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_desc, $sub_source, $obj_api, $remark);
//                            $this->insertEnquiryModels($obj_enquiry, $project, $request);
                        } else {

                            $obj_enquiry = Enquiry::where('customer_id', '=', $obj_customer->customer_id)->orderBy('id', 'desc')->first();
                            if (!empty($obj_enquiry)) {
//                                $this->insertEnquiryModels($obj_enquiry, $project, $request);
                            }
                        }
                        return $obj_enquiry;
                    }
                }
            } else {
                $country = $request['country_code'];
                if ($country != '91' && $country != '') {
                    $customer_type = 1;
                }
                $obj_customer = new Customer();
                $obj_customer->first_name = $request['first_name'];
                $obj_customer->last_name = $request['last_name'];
                $obj_customer->client_id = 1;
                $obj_customer->save();

                $obj_customerContacts = new CustomersContact();
                $obj_customerContacts->customer_id = $obj_customer->id;
                $obj_customerContacts->mobile_number = $request['mobile_no'];
                $obj_customerContacts->mobile_verification_status = $request['mobile_no_verification_status'];
                $obj_customerContacts->landline_number = $request['landline'];
                $obj_customerContacts->email_id = $request['email_id'];
                $obj_customerContacts->email_verification_status = $request['email_id_verification_status'];

                $obj_customerContacts->save();

                $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_desc, $sub_source, $obj_api, $remark, 0);
                if (!$request['email_id_verification_status'] && !$request['mobile_no_verification_status']) {
                    
                }
                return $obj_enquiry;
            }
        }
    }

    public function insertEnquiry($obj_customer, $obj_employee, $source_id, $source_desc, $sub_source, $obj_api, $remark, $custMsg = '', $status = 0) {
        $input = PushApiSetting::doAction($obj_customer, $obj_employee, $source_id, $source_desc, $sub_source, $obj_api, $remark);
        $create = CommonFunctions::insertMainTableRecords(1);
        $input['enquiryData'] = array_merge($input['enquiryData'], $create);
        $obj_enquiry = Enquiry::create($input['enquiryData']);
        $input['followupData'] = array_merge($input['followupData'], $create);
        $enq = Enquiry::latest('id')->first();
        $input['followupData']['enquiry_id'] = $enq->id;
        $obj_followups = EnquiryFollowup::create($input['followupData']);
        return $obj_followups;
    }

    public function errorNofificationMail($status, $message, $obj_api) {
        $encodeUrl = urlencode($_GET['requested_url']);
        $decodeUrl = urldecode($encodeUrl);
        $decodeUrl = str_replace(' ', '', $decodeUrl);
        $obj_bms_api_logs = new PushApiErrorNotificationLogs;
        $obj_bms_api_logs->lms_push_api_settings_id = $obj_api->id;
        $obj_bms_api_logs->requested_url = $_GET['requested_url'];
        $obj_bms_api_logs->requested_data = json_encode($_GET);
        $obj_bms_api_logs->error_code = $status;
        $obj_bms_api_logs->error_message = $message;
        $obj_bms_api_logs->requested_url_date = date('Y-m-d h:i:s');
        $obj_bms_api_logs->save();
        $error_notification_email = @explode(',', $obj_api->error_notification_email);
        $currenttime = date('d-m-Y @ H:i:s a');

        if (!empty($_GET['first_name'])) {
            $fistname = $_GET['first_name'];
        } else {
            $fistname = $status;
        }
        if (!empty($_GET['last_name'])) {
            $lastname = $_GET['last_name'];
        } else {
            $lastname = $status;
        }
        if (!empty($_GET['mobile_no'])) {
            $mobile_no = trim($_GET['mobile_no']);
            $country_code = trim($_GET['country_code']);

            if ($country_code != '91' && $country_code != '') {
                $mobile_no = substr($mobile_no, -12);

                if (!is_numeric($mobile_no)) {
                    $mobile_no = $status;
                } else {
                    $mobile_no = $_GET['mobile_no'];
                }
            } else {
                if (preg_match('/^[0-9]{10}+$/', $mobile_no) == '0') {
                    $mobile_no = $status;
                } else {
                    $mobile_no = $_GET['mobile_no'];
                }
            }
        } else {
            $mobile_no = $status;
        }
        if (!empty($_GET['email_id'])) {
            if (!filter_var($_GET['email_id'], FILTER_VALIDATE_EMAIL)) {
                $email_id = $status;
            } else {
                $email_id = $_GET['email_id'];
            }
        } else {
            $email_id = $status;
        }
        if (!empty($_GET['source'])) {
            $source = $_GET['source'];
        } else {
            $source = $status;
        }
        if (!empty($_GET['sub_source'])) {
            $sub_source = $_GET['sub_source'];
        } else {
            $sub_source = $status;
        }

        if (!empty($error_notification_email)) {
            $default_content = '';
            $templatedata = array();
            $username = "";
            $password = "";
            $email = DB::table('email_configuration')->where('id', '=', $obj_api->from_email_id)->first();
            if (!empty($obj_api->from_email_id)) {
                $username = $email->email;
                $password = $email->password;
            }
            if (!empty($_GET['source'])) {
                $sales_source_name = $_GET['source'];
            } else {
                $sales_source_name = '';
            }
            if (!empty($_GET['sub_source'])) {
                $enquiry_subsource = $_GET['sub_source'];
            } else {
                $enquiry_subsource = '';
            }
            $templatedata['employee_id'] = $obj_api->error_notification_email;
            $templatedata['client_id'] = config('global.client_id');
            $templatedata['template_setting_customer'] = 0; //50;
            $templatedata['template_setting_employee'] = 50;
            $templatedata['customer_id'] = '1';
            $templatedata['project_id'] = 0;
            $templatedata['sms_status'] = '1';
            $templatedata['email_status'] = '1';
            $templatedata['arrExtra'][0] = array(
                '[#api_name#]',
                '[#currenttime#]',
                '[#status#]',
                '[#message#]',
                '[#fistname#]',
                '[#lastname#]',
                '[#mobile_no#]',
                '[#email_id#]',
                '[#source#]',
                '[#sub_source#]',
                '[#requested_url#]',
                '[#s3Path#]',
                '[#pdf_name#]',
            );
            $templatedata['arrExtra'][1] = array(
                $obj_api->api_name,
                date('Y-m-d h:i:s'),
                $status,
                $message,
                $_GET['first_name'],
                $_GET['last_name'],
                $_GET['mobile_no'],
                $_GET['email_id'],
                $sales_source_name,
                $enquiry_subsource,
                $decodeUrl,
                config('global.s3Path'),
                $obj_api->pdf_name,
            );
            $r = 1;
            $result = CommonFunctions::templateData($templatedata);
            return json_encode($result);
        }
    }

    public function successNofificationMail($status, $message, $obj_api, $request) {

        $enquiry = Enquiry::latest()->first();
        $sales_employee_id = $enquiry['sales_employee_id'];
        $emp = Employee::select('employees.first_name', 'employees.last_name', 'employees.personal_mobile1', 'employees.personal_email1', 'de.designation')
                ->leftjoin('laravel_developement_master_edynamics.mlst_bmsb_designations as de', 'employees.designation_id', '=', 'de.id')
                ->where('employees.id', '=', $sales_employee_id)
                ->first();

        $source = DB::table('laravel_developement_master_edynamics.mlst_bmsb_enquiry_sales_sources')->where('id', '=', $request['source'])->first();
        if (!empty($source)) {
            $sales_source_name = $source->sales_source_name;
        } else {
            $sales_source_name = '';
        }
        if (!empty($request['project_id'])) {
            $projectDetails = Project::select('pw.project_address', 'pw.short_description', 'pw.project_logo', 'pw.project_contact_numbers', 'pw.project_brochure', 'pw.project_banner_images', 'pw.google_map_short_url')
                    ->leftjoin('project_web_pages as pw', 'projects.id', '=', 'pw.project_id')
                    ->where('projects.id', '=', $request['project_id'])
                    ->first();
            $project_address = $projectDetails->project_address;
            $short_description = $projectDetails->short_description;
            $project_logo = $projectDetails->project_logo;
            $project_brochure = $projectDetails->project_brochure;
            $google_map_short_url = $projectDetails->google_map_short_url;
            $project_contact_numbers = $projectDetails->project_contact_numbers;
            if (!empty($projectDetails->project_banner_images)) {
                $project_banner_images = explode(',', $projectDetails->project_banner_images);
                $project_banner_images = $project_banner_images['0'];
            }
            $project_banner_images = $projectDetails->project_banner_images;
        } else {
            $project_address = '';
            $short_description = '';
            $project_logo = '';
            $project_brochure = '';
            $google_map_short_url = '';
            $project_contact_numbers = '';
        }
        $project_link = 'http://' . $_SERVER['SERVER_NAME'] . ':8000/project-details/' . $request['project_id'];
        $project_logo = config('global.s3Path') . '/project/project_logo/' . $project_logo;
        $project_brochure = config('global.s3Path') . '/project/project_brochure/' . $project_brochure;
        $project_banner_images = config('global.s3Path') . '/project/project_banner_images/' . $project_banner_images;

        $templatedata['employee_id'] = $emp->id;
        $templatedata['client_id'] = config('global.client_id');
        $templatedata['customer_status'] = '1';
        $templatedata['employee_status'] = '1';
        $templatedata['project_id'] = 0;
        $templatedata['sms_status'] = 1;
        $templatedata['email_status'] = 1;
        $templatedata['employee_mobno'] = $emp->personal_mobile1;
        $templatedata['employee_email'] = $emp->personal_email1;
        $templatedata['arrExtra'][0] = array(
            '[#apiName#]',
            '[#customerName#]',
            '[#customerMob1#]',
            '[#customerEmail1#]',
            '[#customerMsg#]',
            '[#enquirySource#]',
            '[#enquiryDescription#]',
            '[#greeting#]',
            '[#employeeName#]',
            '[#employeeMobile#]',
            '[#employeeEmail#]',
            '[#employeeDesignation#]',
            '[#projectName#]',
            '[#projectBlockType#]',
            '[#projectAddress#]',
            '[#projectShortDesc#]',
            '[#projectLink#]',
            '[#projectLogo#]',
            '[#projectBroucher#]',
            '[#projectBannerImage#]',
            '[#projectGoogleMap#]',
            '[#projectContactNo#]',
            '[#companyLogo#]',
            '[#companyMarketingName#]',
            '[#companyAddress#]',
            '[#website#]',
        );
        $templatedata['arrExtra'][1] = array(
            $obj_api->api_name,
            $request['first_name'] . " " . $request['last_name'],
            $request['mobile_no'],
            $request['email_id'],
            $request['remarks'],
            $sales_source_name,
            $request['source_description'],
            "Thank You",
            $emp->first_name . " " . $emp->last_name,
            $emp->personal_mobile1,
            $emp->personal_email1,
            $emp->designation,
            $request['project_name'],
            $request['block_type'],
            $project_address,
            $short_description,
            $project_link,
            $project_logo,
            $project_brochure,
            $project_banner_images,
            $google_map_short_url,
            $project_contact_numbers,
        );

        $result = CommonFunctions::texttemplateData($templatedata, $obj_api, $request);

        return json_encode($result);
    }

}
