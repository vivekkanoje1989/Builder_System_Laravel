<?php

namespace App\Modules\CloudTelephony\Controllers;

use Mail;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EmployeesDevice;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\UploadedFile;
use File;
use DB;
use Illuminate\Http\Request;
use App\Models\CtTuneType;
use App\Models\CtForwardingType;
use App\Models\EnquirySubSource;
use App\Models\CtSetting;
use App\Models\backend\Employee;
use App\Models\CtEmployeesExtension;
use App\Models\Customer;
use App\Models\CustomersContact;
use App\Models\LstTitle;
use App\Models\Enquiry;
use App\Models\CtLogsInbound;
use App\Models\ClientInfo;
use App\Classes\CommonFunctions;
use App\Models\CtMenuSetting;
use App\Models\EnquiryFollowup;
use App\Classes\S3;
use App\Models\TemplatesSetting;
use App\Models\TemplatesCustom;
use App\Models\TemplatesDefault;
use App\Models\EmailConfiguration;
use App\Classes\Gupshup;
use Auth;
use App\Models\CtLogsOutbound;
use Maatwebsite\Excel\Facades\Excel;

class CloudCallingLogsController extends Controller {

    public function __construct() {
        $this->middleware('web');
    }

     public static $procname;
     public $allusers = array();
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    function _sendResponse($status = 200, $body = '', $content_type = 'text/html') {
        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        // set the status
        header($status_header);
        // set the content type
        header('Content-type: ' . $content_type);
        header("Access-Control-Allow-Origin: *");
        // pages with body are easy
        if ($body != '') {
            // send the body
            echo $body;
            exit;
        }
        // we need to create the body if none is passed
        else {
            // create some body messages
            $message = '';

            // this is purely optional, but makes the pages a little nicer to read
            // for your users.  Since you won't likely send a lot of different status codes,
            // this also shouldn't be too ponderous to maintain
            switch ($status) {
                case 401:
                    $message = 'You must be authorized to view this page.';
                    break;
                case 404:
                    $message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
                    break;
                case 500:
                    $message = 'The server encountered an error processing your requesct_menu_settings.';
                    break;
                case 501:
                    $message = 'The requested method is not implemented.';
                    break;
            }

            // servers don't always have a signature turned on (this is an apache directive "ServerSignature On")
            $signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

            // this should be templatized in a real-world solution
            $body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/stricct_menu_settings.dtd">
                            <html>
                                <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                                    <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
                                </head>
                                <body>
                                    <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
                                    <p>' . $message . '</p>
                                    <hr />
                                    <address>' . $signature . '</address>
                                </body>
                            </html>';

            echo $body;
            exit;
        }
    }

    function _getStatusCodeMessage($status) {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    function _getObjectEncoded($model, $array) {

        return json_encode($array);
    }

    function cURLcheckBasicFunctions() {
        if (!function_exists("curl_init") &&
                !function_exists("curl_setopt") &&
                !function_exists("curl_exec") &&
                !function_exists("curl_close"))
            return false;
        else
            return true;
    }

    public function roundrobin($str_mobiles, $last_connected_no) {

        if (!empty($str_mobiles) && !empty($last_connected_no)) {
            $arr_mobiles = $str_mobiles;
            $last_connected_position = array_search($last_connected_no, $arr_mobiles);
        }

        $mobiles_count = count($arr_mobiles);
        $start = 0;
        $end = $mobiles_count - 1;
        $two_loop = 0;
        if ($last_connected_position == $end) {
            $two_loop = 0;
            $start = 0;
            $end = $mobiles_count - 1;
        } else if ($last_connected_position >= $start && $last_connected_position < $end) {
            $two_loop = 1;
            $start = $last_connected_position + 1;
            $end = $mobiles_count - 1;
            $s_start = 0;
            $s_end = $last_connected_position;
        }
        if ($two_loop == 0) {
            for ($i = $start; $i <= $end; $i++) {
                $final_arr[$i] = $arr_mobiles[$i];
            }
        } else if ($two_loop == 1) {
            for ($i = $start; $i <= $end; $i++) {
                $final_arr[$i] = $arr_mobiles[$i];
            }
            for ($i = $s_start; $i <= $s_end; $i++) {
                $final_arr[$i] = $arr_mobiles[$i];
            }
        }
        return $final_arr;
    }

    public function getMissedcall_agent($missedcall_agent, $virtual_number, $ext) {
        if ($ext == 'None') {
            $ext = 0;
        }
        $last_connected_row = CtLogsInbound::where("virtual_number", $virtual_number)
                        ->Where('customer_call_status', '!=', 'Connected')
                        ->Where("extension_number", $ext)
                        ->orderBy('id', 'DESC')->limit(1)->offset(1)->get();
        
        if (count($last_connected_row) > 0)
            $last_connected_no = $last_connected_row[0]['employee_id'];
        else
            $last_connected_no = 0;
        
        $menu_admin_arr = @explode(',', $missedcall_agent);
        if (!empty($menu_admin_arr)) {
            foreach ($menu_admin_arr as $admin_id) {
                $admin_mobile_model = Employee::where("id", $admin_id)->first();
                
                if(!empty($admin_mobile_model->office_mobile_no) && $admin_mobile_model->office_mobile_no != 'null'){
                   // $menu_all_mobile[] = $admin_mobile_model->username;
                     $menu_all_mobile[] = $admin_mobile_model->office_mobile_no;
                }else if(!empty($admin_mobile_model->personal_mobile1) && $admin_mobile_model->personal_mobile1 != 'null'){
                    $menu_all_mobile[] = $admin_mobile_model->personal_mobile1;
                }
            }
        } else {
            $menu_all_mobile = array();
        }


        if (!empty($menu_all_mobile) && $last_connected_no != 0) {
            $agent_numbers = $this->roundrobin($menu_all_mobile, $last_connected_no);
        }

        if (!empty($agent_numbers)) {

            $agent_numbers = @implode(',', $agent_numbers);
        } else {
            $agent_numbers = @implode(',', $menu_all_mobile);
        }

        return $agent_numbers;
    }

    public function Index() {
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parts = parse_url($url);
        parse_str($parts['query'], $_GET);
        
        if (!empty($_GET)) {
            $call_date = $_GET['date'];
            $call_time = $_GET['time'];
            $virtual_number = $_GET['knumber'];
            $caller_number = $_GET['caller_number'];
            $caller_duration = $_GET['conversation_duration'];
            $agent_list = $_GET['agent_list'];
            $call_connected_to = $_GET['agent_connected'];
            $call_status = $_GET['call_status'];
            $call_recording_url = $_GET['recording_url'];
            $caller_circle = $_GET['caller_circle'];
            $enquiry_flag = $_GET['enquiry_flag'];

            if (!empty($_GET['ivr_type']))
                $ivr_type = $_GET['ivr_type'];
            else
                $ivr_type = 1;

            $extension = $_GET['extension_no'];
            $sub_extension = $_GET['sub_extension_no'];

            if (!empty($_GET['bridged_number']))
                $bridged_number = $_GET['bridged_number'];
            else
                $bridged_number = "";


            if (!empty($_GET['bridge_join_time']) && !empty($_GET['bridge_hangup_time'])) {
                $bridge_join_time = strtotime($_GET['bridge_join_time']);
                $bridge_hangup_time = strtotime($_GET['bridge_hangup_time']);
                $duration = $bridge_hangup_time - $bridge_join_time;
                $bridging_duration = gmdate("H:i:s", $duration);
            } else {
                $bridging_duration = "";
            }
            if (!empty($_GET['caller_operator']))
                $caller_operator = $_GET['caller_operator'];
            else
                $caller_operator = "";

            if (is_numeric($bridged_number)) {
                $bridged_number = substr($bridged_number, -10);
            } else {
                $bridged_number = 'NA';
            }




            $virtual_number = substr($virtual_number, -12);
            $caller_number = substr($caller_number, -10);
            $call_connected_to = substr($call_connected_to, -10);

            $model_id = 0;
            $subsource_id = 0;
            $source_id = 0;
            $source_description = '';
            $basepath = base_path() . "/common/tunes/";

            $model = new CtLogsInbound;
            $model->call_date = $call_date;
            $model->call_time = $call_time;
            $model->virtual_number = $virtual_number;
            $model->customer_number = $caller_number;
            $model->customer_call_duration = $caller_duration;
            $model->employee_list = $agent_list;
            $model->employee_number = $call_connected_to;
            $model->customer_call_status = $call_status;

            $model->customer_circle = $caller_circle;
            $model->enquiry_flag = $enquiry_flag;
            $model->extension_number = $extension;

            $model->bridge_employee_number = $bridged_number;
            $model->bridge_call_duration = $bridging_duration;
            $model->customer_operator = $caller_operator;
            // start recording move code sip
            $file_path = $call_recording_url;
            $url_file_path = urldecode($file_path);
            $file_name = basename($url_file_path) . '.mp3';

            if ($call_status == 'Connected') {
                $model->call_recording_url = $file_name;
            }
            $model->total_call_duration = $caller_duration;
            $model->call_log_push_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $model->call_push_url_date_time = date('Y-m-d H:i:s');


            if($ivr_type == 4 &&  $extension == 'None' || empty($extension))
            {
                $model->customer_call_status = 'Non Working Hours Call';
                $model->save();
            }

            if($call_status == "Invalid agent list"){
                 $model->customer_call_status = 'Missed';
                 $model->save();
            }
            
            $model->save();

            
            $svirtual_model = CtSetting::where("forwarding_number_knowlarity", $model->virtual_number)->first();
          
            if (!empty($extension) && $extension != 'None') {
                if ($call_status == 'NotConnected' && $ivr_type == 4 && $svirtual_model->msc_facility_status != 1) 
                {
                     
                    $model->client_id = $svirtual_model->client_id;
                    $model->save();
                    
                    $mobile_number = $this->getMissedcall_agent($svirtual_model->msc_default_employee_id, $model->forwarding_number_knowlarity, $ext = $extension);
                   
                    $agent = @explode(',', $mobile_number);
                    $model->employee_number = $agent[0]; //[0];// $obj_employee_missed->mobile_no;
                    $model->save();
                    
                    
                    $service_emp = \App\Model\backend\Employee::where(['username' => $model->employee_number])->orWhere(['office_mobile_no' => $model->employee_number])->orWhere(['personal_mobile1' => $model->employee_number])->first();
                    
                    
                    if (!empty($caller_number)) {
                        $service_cust_no = substr($caller_number, -10);
                        $service_customer_model = CustomersContact::where(['mobile_number' => $service_cust_no])->first();
                        $service_client_id = $service_emp->client_id;
                        $i = 1;
                        while ($i < 10) {
                            $appointment_setting_model = \App\Models\ServiceAppointmentSetting::where(['client_id' => $service_client_id])->first();
                            date_default_timezone_set('Asia/Kolkata');
                            
                            $interval_id =  $appointment_setting_model->appointment_interval_id;
                            $interval_data = \App\Models\MlstLmsaAppointmentInterval::where('id', $interval_id)->first();
                            $interval =$interval_data->interval; //in min
                            $start_time = $appointment_setting_model->appointment_start_time;
                            $start_time = date('H:i:s', strtotime($start_time));
                            $end_time = $appointment_setting_model->appointment_end_time;
                            $end_time = date('H:i:s', strtotime($end_time));
                            //$off_day = $appointment_setting_model->weekly_off_day;
                            $next_date = date("Y-m-d", strtotime("+$i day"));
                            //$day = date("l", strtotime($next_date));
//                            if ($off_day == $day) {
//                                $i++;
//                                $next_date = date("Y-m-d", strtotime("+$i day"));
//                            }
                            $appdate = date('Y-m-d', strtotime(date('Y-m-d')));
                            $booked_slot = \App\Models\ServiceAppointment::select('appointment_time', DB::raw('count(appointment_time) as appcount'))
                                ->where('appointment_date', '=',$appdate)
                                ->groupBy('appointment_time')
                                ->orderBy('appointment_time')
                                ->get();
                            $time_slot = array();
                            while ($start_time <= $end_time) {
                                $current_date = date('Y-m-d');
                                $current_time = date('H:i');
                                //if ($appdate == $current_date) {
                                //    $start_h = date('H:i', strtotime($start_time));
                                //    if ($start_h >= $current_time) {
                                //        $time_slot[] = $start_time;
                                //    }
                                    $start_time = date("H:i:s", strtotime("+$interval minutes", strtotime($start_time)));
                                //} else {
                                    $time_slot[] = $start_time;
                                //    $start_time = date("H:i:s", strtotime("+$interval minutes", strtotime($start_time)));
                                //}
                            }
                            $booked_time = array();
                            if(!empty($booked_slot)){
                                foreach ($booked_slot as $booked) {

                                    if (($booked['appcount'] == $appointment_setting_model->vehicle_per_interval)) {
                                        $booked_time[] = $booked['appointment_time'];
                                    }
                                }
                                $final_time_slot_diff = array_diff($time_slot, $booked_time);
                            }else{
                                $final_time_slot_diff = $time_slot;
                            }
                            
                            $final_time_slot = array();
                             $i=0;
                            foreach ($final_time_slot_diff as $final_time_slot_row) {
                                $final_time_slot[] = date('h:i A', strtotime($final_time_slot_row));
                                $i++;
                            }
                            if (!empty($final_time_slot)) {
                                $appointment_date = $next_date;
                                $appointment_time = $final_time_slot[0];
                                break;
                            } else {
                                $i++;
                                continue;
                            }
                        }

                        if (empty($service_customer_model)) {
                            $sflag = 0;
                            $service_customer_model = new Customer();
                            $service_customer_model->source_id = $svirtual_model->source_id;
                            $service_customer_model->subsource_id = $svirtual_model->sub_source_id;
                            $service_customer_model->source_description = $svirtual_model->source_disc;
                            $service_customer_model->client_id = $service_client_id;
                            $service_customer_model->customer_type = 2;
                            $service_customer_model->created_by = $service_emp->id;
                            $service_customer_model->created_date = date('Y-m-d');
                            $service_customer_model->save();
                            $service_customer_id = $service_customer_model->id;
                            $obj_customer = new CustomersContact();
                            $obj_customer->client_id = $service_client_id;
                            $obj_customer->customer_id = $service_customer_model->id;
                            $obj_customer->mobile_number_lable = 1;
                            $obj_customer->mobile_number = $caller_number;
                            $obj_customer->save();
                            
                            $service_appointment_model = new \App\Models\ServiceAppointment();
                            $service_appointment_model->customer_id=$service_customer_model->id;
                            $service_appointment_model->service_vehicles_id=0;
                            $service_appointment_model->client_locations_id=$appointment_setting_model->client_locations_id;
                            $service_appointment_model->appointment_channel_id=9;
                            $service_appointment_model->appointment_status_id=1;
                            $service_appointment_model->service_type=1;
                            $service_appointment_model->pickup_required=0;
                            $service_appointment_model->pickup_address_id=0;
                            $service_appointment_model->drop_required=0;
                            $service_appointment_model->drop_address_id=0;
                            $service_appointment_model->appointment_date = $appointment_date;
                            $service_appointment_model->appointment_time = $appointment_time;
                            $service_appointment_model->created_date = date('Y-m-d');
                            $service_appointment_model->created_by = $service_emp->id;
                            $service_appointment_model->save();
                        } else {
                                $service_customer_id = $service_customer_model->customer_id;
                                if($service_customer_model->customer_type == 1){
                                    $service_customer_model->customer_type = 3;
                                    $service_customer_model->save();
                                }
                                $service_vehicle = \App\Models\ServiceVehicle::where(['customer_id' => $service_customer_model->id])->get();
                                $cnt = count($service_vehicle);
                                if ($cnt == 1) {
                                    $vehicle_id = $service_vehicle[0]['id'];
                                } else {
                                    $vehicle_id = 0;
                                }
                                $stoday = date('Y-m-d');
                                $service_appointment_model = \App\Models\ServiceAppointment::where('customer_id', $service_customer_model->id)
                                                ->where('appointment_date','>=', $stoday)->first();

                                if (empty($service_appointment_model)) {
                                    $sflag = 0;
                                    $service_appointment_model = new \App\Models\ServiceAppointment;
                                    $service_appointment_model->customer_id = $service_customer_model->id;
                                    $service_appointment_model->service_vehicles_id = $vehicle_id;
                                    $service_appointment_model->appointment_date = $appointment_date;
                                    $service_appointment_model->appointment_time = $appointment_time;
                                    $service_appointment_model->appointment_status_id=1;
                                    $service_appointment_model->service_type=1;
                                    $service_appointment_model->appointment_channel_id = 9;
                                    $service_appointment_model->pickup_required=0;
                                    $service_appointment_model->pickup_address_id=0;
                                    $service_appointment_model->drop_required=0;
                                    $service_appointment_model->drop_address_id=0;
                                    $service_appointment_model->created_date = date('Y-m-d');
                                    $service_appointment_model->created_by = $service_emp->id;
                                    $service_appointment_model->save();
                                } else {
                                    $sflag = 1;
                                }
                        }

                    //    $shorturl = $_SERVER['HTTP_HOST'] . '/office.php/site/updateappointment?mobile_no=' . $service_cust_no . '&email_id=' . $service_customer_model->email_1 . '&access_key=' . $access_key;
                        $shorturl = $_SERVER['HTTP_HOST'] . '/services';
//                        $shorturl = "http://businessapps.co.in";
                        //$longUrl = $shorturl;
                        $return_val = $this->shortenUrl($shorturl);
                        $shorturl = $return_val['id'];
                        
                        if ($sflag == 0) {
//                            $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $service_client_id, 'event_id' => 27])->one();
//                            if ($alert_settings_customer->alert_type == 0) {
//                                $sms_template_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
//                            } else {
//                                $sms_template_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
//                            }
//
//                            $alert_settings_employee = \common\models\AlertsSettingsModel::find()->where(['client_id' => $service_client_id, 'event_id' => 28])->one();
//                            if ($alert_settings_employee->alert_type == 0) {
//                                $sms_template_employee = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_employee->event_id])->one();
//                            };
//
//                            $template_emp = $sms_template_employee->sms_body;
//                            $arr_static_tags_search_emp = array(
//                                '[#greeting#]',
//                                '[#employeeName#]',
//                                '[#custName#]',
//                                '[#custMobile#]',
//                                '[#companyMktName#]',
//                                '[#appointmentDate#]',
//                                '[#appointmentTime#]',
//                                '[#custFormLink#]'
//                            );
//
//                            $arr_static_tags_replace_emp = array(
//                                $greeting_msg,
//                                $service_emp->fullname,
//                                $service_customer_model->first_name . ' ' . $service_customer_model->last_name,
//                                $service_customer_model->mobile_1,
//                                $service_client->marketing_name,
//                                date('Y-m-d', strtotime($service_appointment_model->appointment_date)),
//                                date('h:i A', strtotime($service_appointment_model->appointment_time)),
//                                $shorturl
//                            );
//                            $template_emp = str_replace($arr_static_tags_search_emp, $arr_static_tags_replace_emp, $template_emp);
//
//                            Yii::$app->LMS->sendSMST($smsbody = $template_emp, $mobile_no = $service_emp->username, $user_id = $service_emp->id, $customer = 'No', $customer_id = 0);
//
//                            $template_cust = $sms_template_customer->sms_body;
//                            $sms_template_cust = str_replace($arr_static_tags_search_emp, $arr_static_tags_replace_emp, $template_cust);
//                            Yii::$app->LMS->sendSMST($smsbody = $sms_template_cust, $mobile_no = $service_customer_model->mobile_1, $user_id = $service_emp->id, $customer = 'Yes', $customer_id = $service_customer_model->id);
                                $templatedata['employee_id'] = $service_emp->id;
                                $templatedata['client_id'] = $service_emp->client_id;
                                $templatedata['template_setting_customer'] = 19;//27;
                                $templatedata['template_setting_employee'] = 20;//28;
                                $templatedata['customer_id'] = $service_customer_id;
                                $templatedata['model_id'] = 0;

                                $templatedata['arrExtra'][0] = array(
//                                    '[#customerName#]',
//                                    '[#customerMobile#]',
                                    '[#ServiceFormLink#]',
                                    '[#appointmentDate#]',
                                    '[#appointmentTime#]',
                                );

                                $templatedata['arrExtra'][1] = array(
//                                    "",
//                                    $caller_number,
                                    $shorturl,
                                    date('Y-m-d', strtotime($service_appointment_model->appointment_date)),
                                    date('h:i A', strtotime($service_appointment_model->appointment_time)),
                                );

                                $result = CommonFunctions::templateData($templatedata);
                            
                        } elseif ($sflag == 1) {
//                            $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $service_client_id, 'event_id' => 29])->one();
//                            if ($alert_settings_customer->alert_type == 0) {
//                                $sms_template_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
//                            } else {
//                                $sms_template_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
//                            }
//
//                            $arr_static_tags_search_emp = array(
//                                '[#greeting#]',
//                                '[#employeeName#]',
//                                '[#custName#]',
//                                '[#custMobile#]',
//                                '[#companyMktName#]',
//                                '[#appointmentDate#]',
//                                '[#appointmentTime#]',
//                                '[#custFormLink#]'
//                            );
//
//                            $arr_static_tags_replace_emp = array(
//                                $greeting_msg,
//                                $service_emp->fullname,
//                                $service_customer_model->first_name . ' ' . $service_customer_model->last_name,
//                                $service_customer_model->mobile_1,
//                                $service_client->marketing_name,
//                                date('Y-m-d', strtotime($service_appointment_model->appointment_date)),
//                                date('h:i A', strtotime($service_appointment_model->appointment_time)),
//                                $shorturl
//                            );
//                            $template_cust = $sms_template_customer->sms_body;
//                            $sms_template_cust = str_replace($arr_static_tags_search_emp, $arr_static_tags_replace_emp, $template_cust);
//                            Yii::$app->LMS->sendSMST($smsbody = $sms_template_cust, $mobile_no = $service_customer_model->mobile_1, $user_id = $service_emp->id, $customer = 'Yes', $customer_id = $service_customer_model->id);
                                //print_r($service_customer_id);exit;
                                $templatedata['employee_id'] = $service_emp->id;
                                $templatedata['client_id'] = $service_emp->client_id;
                                $templatedata['template_setting_customer'] = 21;//29;
                                $templatedata['template_setting_employee'] = 0;
                                $templatedata['customer_id'] = $service_customer_id;
                                $templatedata['model_id'] = 0;

                                $templatedata['arrExtra'][0] = array(
                                    '[#customerFormLink#]',
                                    '[#appointmentDate#]',
                                    '[#appointmentTime#]',
                                );

                                $templatedata['arrExtra'][1] = array(
                                    $shorturl,
                                    date('Y-m-d', strtotime($service_appointment_model->appointment_date)),
                                    date('h:i A', strtotime($service_appointment_model->appointment_time)),
                                );

                                $result = CommonFunctions::templateData($templatedata);
                        }
                        header("Content-type: text/xml; charset=utf-8");
                        echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
                        exit;
                    }
                }
            }


            //Upload mp3
            $url = '';
            $arrs = explode('&', $model->call_log_push_url);
            foreach ($arrs as $arr => $value) {
                $dada = explode('=', $value);
                if ($dada[0] == 'recording_url' && $dada[1] != '') {
                    $url = $dada[1];
                }
            }
            if ($url != '' && strpos($url, "http") !== false) {
                try {
                    $org_file_path = urldecode($url);
                    $live_file = basename($org_file_path) . '.mp3';
                    $temp_file = $basepath . $model->call_recording_url;

                    //file_put_contents($temp_file, fopen($org_file_path, 'r'));
                    //$temp_file = $basepath . $live_file;
                    $model->call_recording_url = $live_file;
                    $model->call_recording_url_status = 1;
                    $model->save();
                    $s3FolderName = 'recorded_file';
                    $name = S3::s3FileUpload($org_file_path, $live_file, $s3FolderName);
                } catch (Exception $e) {
                    //  echo 'Caught exception: ',  $e->getMessage(), "\n";
                }
            }
            // end recording move code

            if ($model->virtual_number != '') {
                $obj_virtual_number = CtSetting::where("forwarding_number_knowlarity", $model->virtual_number)->first();
                $source_id = $obj_virtual_number->source_id;
                $source_description = $obj_virtual_number->source_disc;
                $model->source_id = $source_id;

                if(!empty($obj_virtual_number->sub_source_id))
                {
                    $subsource_id = $obj_virtual_number->sub_source_id;
                }
                
                $model->sub_source_id = $subsource_id;

                $model->client_id = $obj_virtual_number->client_id;
                $client_id = $model->client_id;
                $model->save();

                if ($call_status == 'Missed' || $call_status == 'Invalid agent list' and $model->extension_number == 'None') {
                    
                    if(!empty($obj_virtual_number->employees)){
                        $mobile_number = $this->getMissedcall_agent($obj_virtual_number->employees, $model->virtual_number, $ext = 0);
                        $agent = @explode(',', $mobile_number);
                        $model->employee_number = $agent[0]; 
                        $model->save();
                    }else{
                        $mobile_number = $this->getMissedcall_agent($obj_virtual_number->msc_default_employee_id, $model->virtual_number, $ext = 0);
                        $agent = @explode(',', $mobile_number);
                        $model->employee_number = $agent[0];
                        $model->save();
                    }
                } else if ($model->extension_number != 'None' && $ivr_type != 4) {
                    
                    if ($call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Invalid agent list') {
                        $obj_extension = CtMenuSetting::where(array('ct_settings_id' => $obj_virtual_number->id, 'ext_number' => $model->extension_number))->first();
                        if($obj_extension->msc_employee_type == 0){
                            $mobile_number = $this->getMissedcall_agent($obj_extension->employees, $model->virtual_number, $ext = $model->extension_number);
                            $agent = @explode(',', $mobile_number);
                            $model->employee_number = $agent[0]; 
                            $model->save();
                        }else{
                            $mobile_number = $this->getMissedcall_agent($obj_extension->msc_default_employee_id, $model->virtual_number, $ext = $model->extension_number);
                            $agent = @explode(',', $mobile_number);
                            $model->employee_number = $agent[0]; 
                            $model->save();
                        }
                    }
                } else if ($call_status == 'NotConnected' and $obj_virtual_number->msc_facility_status == 1) {
                    $mobile_number = $this->getMissedcall_agent($obj_virtual_number->msc_default_employee_id, $model->virtual_number, $ext = 0);
                    $agent = @explode(',', $mobile_number);
                    $model->employee_number = $agent[0]; //[0];// $obj_employee_missed->mobile_no;
                    $model->save();
                }else if($call_status == 'NotConnected' and $ivr_type == 4 and $model->extension_number != 'None' ){
                    $obj_extension = CtMenuSetting::where(array('ct_settings_id' => $obj_virtual_number->id, 'ext_number' => $model->extension_number))->first();
                    if($obj_extension->msc_employee_type == 0){
                            $mobile_number = $this->getMissedcall_agent($obj_extension->employees, $model->virtual_number, $ext = $model->extension_number);
                            $agent = @explode(',', $mobile_number);
                            $model->employee_number = $agent[0]; 
                            $model->save();
                    }else{
                        $mobile_number = $this->getMissedcall_agent($obj_extension->msc_default_employee_id, $model->virtual_number, $ext = $model->extension_number);
                        $agent = @explode(',', $mobile_number);
                        $model->employee_number = $agent[0]; 
                        $model->save();
                    }
                }else if($call_status == 'NotConnected' and $ivr_type == 4){
                    if(!empty($obj_virtual_number->employees)){
                        $mobile_number = $this->getMissedcall_agent($obj_virtual_number->employees, $model->virtual_number, $ext = 0);
                        $agent = @explode(',', $mobile_number);
                        $model->employee_number = $agent[0]; 
                        $model->save();
                    }else{
                        $mobile_number = $this->getMissedcall_agent($obj_virtual_number->msc_default_employee_id, $model->virtual_number, $ext = 0);
                        $agent = @explode(',', $mobile_number);
                        $model->employee_number = $agent[0];
                        $model->save();
                    }
                }
            }
            // start enquiry inserting code

            if ($call_status == 'Connected' || $call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Invalid agent list') {

                if(!empty($model->bridge_employee_number) && $model->bridge_employee_number != 'None' && $model->bridge_employee_number != '' && $model->bridge_employee_number != 'null')
                $obj_employee = Employee::where(array('employee_status' => 1))->Where(['office_mobile_no' => $model->bridge_employee_number])->orWhere(['personal_mobile1' => $model->bridge_employee_number])->first();
                

                if (empty($obj_employee)) {
                    
                     if(!empty($model->employee_number) && $model->employee_number != 'None' && $model->employee_number != '' && $model->employee_number != 'null' )
                    $obj_employee = Employee::where(array('employee_status' => 1))->Where(['office_mobile_no' => $model->employee_number])->orWhere(['personal_mobile1' => $model->employee_number])->first();
                    
                } else if (empty($obj_employee)) {

                    $mobile_number = $this->getMissedcall_agent($obj_virtual_number->msc_default_employee_id, $model->virtual_number, $ext = 0);
                    $agent = @explode(',', $mobile_number);
                    $model->employee_number = $agent[0]; //[0];// $obj_employee_missed->mobile_no;
                    $model->save();

                    if(!empty($model->employee_number) && $model->employee_number != 'None' && $model->employee_number != '' && $model->employee_number != 'null' )
                    $obj_employee = Employee::where(array('employee_status' => 1))->Where(['office_mobile_no' => $model->employee_number])->orWhere(['personal_mobile1' => $model->employee_number])->first();
                }

                

                if (!empty($obj_employee)) {

                    if ($call_status == 'Connected' || $call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Invalid agent list') {
                        $model->employee_id = $obj_employee->id;
                        $model->save();
                    }

                    $obj_customer = '';
                    $obj_customer = CustomersContact::where(array('mobile_number' => $model->customer_number, 'client_id' => $obj_virtual_number->client_id))->first();

                    if (empty($obj_customer))
                        $obj_customer = CustomersContact::where(array('mobile_number' => $model->landline_number, 'client_id' => $obj_virtual_number->client_id))->first();


                    // existing customer
                    if (!empty($obj_customer)) {
                        $obj_enquiry = Enquiry::where('customer_id', $obj_customer->customer_id)->orderBy('id', 'SORT_DESC')->first();  //Open
                        if (!empty($obj_enquiry) and $obj_virtual_number->alert_to_enq_owner == 0 and $call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Invalid agent list') {
                            
                            if(!empty($model->employee_number) && $model->employee_number != 'None' && $model->employee_number != '' && $model->employee_number != 'null' )
                            $obj_employee = Employee::where(array('employee_status' => 1))->Where(['office_mobile_no' => $model->employee_number])->orWhere(['personal_mobile1' => $model->employee_number])->first();
                            
                            //print_r($obj_employee);exit;
                        } else if (!empty($obj_enquiry) and $obj_virtual_number->alert_to_enq_owner == 1 and $call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Invalid agent list') {
                            $obj_employee_temp = Employee::where(array('id' => $obj_enquiry->sales_employee_id, 'client_id' => $obj_virtual_number->client_id, 'employee_status' => 1))->first();
                            if (!empty($obj_employee_temp)) {
                                $obj_employee = Employee::where(array('id' => $obj_enquiry->sales_employee_id, 'client_id' => $obj_virtual_number->client_id, 'employee_status' => 1))->first();
                                
                                 if(!empty($obj_employee->office_mobile_no) && $obj_employee->office_mobile_no != 'null'){
                                     $model->employee_number = $obj_employee->office_mobile_no;
                                  }else if(!empty($obj_employee->personal_mobile1) && $obj_employee->personal_mobile1 != 'null'){
                                      $model->employee_number = $obj_employee->personal_mobile1;
                                  }
                                
                                //$model->employee_number = $obj_employee->username; //[0];// $obj_employee_missed->mobile_no;
                                $model->save();
                            }
                        }

                        
                        //start non working hours settings
                            $call_time = date('H',strtotime($model->call_time));
                            $non_working_start_time = $obj_virtual_number->non_working_start_time;
                            $non_working_end_time = $obj_virtual_number->non_working_end_time;

                         if (($call_time >= $non_working_start_time && $call_time <= '23' && !empty($non_working_start_time)) || ($call_time >= '00' && $call_time < $non_working_end_time && !empty($non_working_end_time)))
                         {
                            $exist=1;
                            $nonworkinghours = 1;
                             $this->insertFollowups( $obj_enquiry, $obj_employee, $obj_customer, $exist , $model,$obj_virtual_number );
                            
                            $this->sendEmailAndSms( $model, $obj_employee, $obj_enquiry, $obj_customer, $project_id, $exist ,$nonworkinghours);

                         }else {
                        if ($call_status == 'Connected' || $call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Invalid agent list') {
                            $model->employee_id = $obj_employee->id;
                            $model->save();
                        }

                        if (!empty($obj_enquiry) and $call_status == 'Connected' and $obj_virtual_number->ec_call_status == 0) {
                            if ($obj_enquiry->sales_employee_id == $model->employee_id) {

                                if ($obj_virtual_number->open_enquiry_owner_emp_action == 1) {

                                    // new enquiry	
                                    $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                                    $exist = 1;
                                    $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    // start new Folloups

                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                } else {

                                    $exist = 1;
                                    $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                }
                            } else {

                                if ($obj_virtual_number->open_enquiry_other_emp_action == 1) {

                                    $obj_enquiry->sales_employee_id = $model->employee_id;
                                    $obj_enquiry->save();
                                    $exist = 1;

                                    $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    // start new Folloups													   
                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                } else if ($obj_virtual_number->open_enquiry_other_emp_action == 2) {
                                    // new enquiry	
                                    $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);
                                    // end new enquiry		
                                    // start new Project enquiry								
                                    // $this->insertEnquiryProject( $obj_enquiry, $project_id, $block_id );					
                                    // end new Project enquiry	
                                    $exist = 1;
                                    $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    // start new Folloups

                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                } else {

                                    $exist = 1;
                                    $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                }
                            }
                        } 
                        else if (!empty($obj_enquiry)) {
                            $exist = 1;
                            $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                            $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                        } else {
                            $obj_enquiry = Enquiry::where('customer_id', $obj_customer->customer_id)->orderBy('id', 'SORT_DESC')->first(); //Lost

                            if (!empty($obj_enquiry)) {

                                if ($obj_enquiry->sales_employee_id == $model->employee_id) {
                                    if ($obj_virtual_number->lost_enquiry_owner_emp_action == 1) {
                                        // new enquiry	
                                        $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                                        $exist = 1;
                                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);


                                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                    } else {

                                        $exist = 1;
                                        //$obj_enquiry->enq_status = 'Open';
                                        //$obj_enquiry->save(false);
                                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                    }
                                } else {
                                    if ($obj_virtual_number->lost_enquiry_other_emp_action == 1) {

                                        //$obj_enquiry->enq_status = 'Open';
                                        //$obj_enquiry->save(false);
                                        $exist = 1;
                                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                        // start new Folloups													   
                                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                    } else if ($obj_virtual_number->lost_enquiry_other_emp_action == 2) {
                                        $obj_enquiry->sales_employee_id = $model->employee_id;
                                        //$obj_enquiry->enq_status = 'Open';
                                        $obj_enquiry->save(false);
                                        $exist = 1;
                                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                        // start new Folloups

                                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                    } else {

                                        // new enquiry	
                                        $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                                        $exist = 1;
                                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                        // start new Folloups

                                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                    }
                                }
                            } else {
                                // start new enquiry
                                $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                                $exist = 1;
                                $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                // start new Folloups

                                $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                // end new Folloups	
                            }
                        }
                       }
                        
                    } else if ($model->enquiry_flag == 1 and $call_status == 'Connected') {
                        // start new customer
                        $obj_customer_info = new Customer();
                        $obj_customer_info->source_id = $source_id;
                        $obj_customer_info->subsource_id = $obj_virtual_number->sub_source_id;
                        $obj_customer_info->source_description = $obj_virtual_number->source_disc;
                        $obj_customer_info->client_id = $client_id;
                        $obj_customer_info->customer_type = 1;
                        $obj_customer_info->created_by = $model->employee_id;
                        $obj_customer_info->created_date = date('Y-m-d');
                        $obj_customer_info->save();

                        $obj_customer = new CustomersContact();
                        $obj_customer->client_id = $client_id;
                        $obj_customer->customer_id = $obj_customer_info->id;
                        $obj_customer->mobile_number_lable = 1;
                        $obj_customer->mobile_number = $model->customer_number;
                        $obj_customer->save();

                        $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);
                        $exist = 0;
                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                        // start new Folloups

                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                        // end new Folloups	
                    } 
                    else if ($call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Connected' || $call_status == 'Invalid agent list') {
                        
                    //for ivr type 4
                        if ($call_status == 'NotConnected' and $ivr_type == 4) {
                            $non_working_start_time = $obj_virtual_number->non_working_start_time;
                            $non_working_end_time = $obj_virtual_number->non_working_end_time;
                            //for non working hours settings sms and email
                            $call_time = date('H',strtotime($model->call_time));
                        
                            if (($call_time >= $non_working_start_time && $call_time <= '23' && !empty($non_working_start_time)) || ($call_time >= '00' && $call_time < $non_working_end_time && !empty($non_working_end_time)))
                           {//if call in no working hours
                                    $enquiry_status = CtSetting::where('id', $obj_virtual_number->id)->first();
                                    $enq_status = $enquiry_status->nwh_call_insert_enquiry;
                                    if ($enq_status == 1) {
                                        // start new customer
                                        $obj_customer_info = new Customer();
                                        $obj_customer_info->source_id = $source_id;
                                        $obj_customer_info->subsource_id = $obj_virtual_number->sub_source_id;
                                        $obj_customer_info->source_description = $obj_virtual_number->source_disc;
                                        $obj_customer_info->client_id = $client_id;
                                        $obj_customer_info->customer_type = 1;
                                        $obj_customer_info->created_by = $model->employee_id;
                                        $obj_customer_info->created_date = date('Y-m-d');
                                        $obj_customer_info->save();

                                        $obj_customer = new CustomersContact();
                                        $obj_customer->client_id = $client_id;
                                        $obj_customer->customer_id = $obj_customer_info->id;
                                        $obj_customer->mobile_number_lable = 1;
                                        $obj_customer->mobile_number = $model->customer_number;
                                        $obj_customer->save();

                                        $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                                        $exist = 0;
                                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                        // start new Folloups

                                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                        // end new Folloups
                                    } 
                                    else{
                                        $nonworkinghours = 1;
                                        $exist = 0;
                                        $this->sendMissedSms($model, $obj_employee, $exist,$nonworkinghours);
                                    }
                                    
                            }else{
                                
                                if ($model->extension_number != 'None') {
                                        $enquiry_status = CtMenuSetting::where(array('ct_settings_id' => $obj_virtual_number->id, 'extension_no' => $model->extension_number))->first();
                                        $enq_status = $enquiry_status->msc_call_insert_enquiry;
                                    } else if ($model->extension_number == 'None') {
                                        $enquiry_status = CtSetting::where('id', $obj_virtual_number->id)->first();
                                        $enq_status = $enquiry_status->missed_call_insert_enquiry;
                                    }

                                    if ($enq_status == 1) {
                                        // start new customer
                                        $obj_customer_info = new Customer();
                                        $obj_customer_info->source_id = $source_id;
                                        $obj_customer_info->subsource_id = $obj_virtual_number->sub_source_id;
                                        $obj_customer_info->source_description = $obj_virtual_number->source_disc;
                                        $obj_customer_info->client_id = $client_id;
                                        $obj_customer_info->customer_type = 1;
                                        $obj_customer_info->created_by = $model->employee_id;
                                        $obj_customer_info->created_date = date('Y-m-d');
                                        $obj_customer_info->save();

                                        $obj_customer = new CustomersContact();
                                        $obj_customer->client_id = $client_id;
                                        $obj_customer->customer_id = $obj_customer_info->id;
                                        $obj_customer->mobile_number_lable = 1;
                                        $obj_customer->mobile_number = $model->customer_number;
                                        $obj_customer->save();

                                        $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                                        $exist = 0;
                                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                        // start new Folloups

                                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                        // end new Folloups
                                    } 
                                    else{
                                        $nonworkinghours = 0;
                                        $exist = 0;
                                        $this->sendMissedSms($model, $obj_employee, $exist,$nonworkinghours);
                                    }
                            
                            }
                        }else
                        if ($obj_virtual_number->missed_call_insert_enquiry == 1) {
                            // start new customer
                            $obj_customer_info = new Customer();
                            $obj_customer_info->source_id = $source_id;
                            $obj_customer_info->subsource_id = $obj_virtual_number->sub_source_id;
                            $obj_customer_info->source_description = $obj_virtual_number->source_disc;
                            $obj_customer_info->client_id = $client_id;
                            $obj_customer_info->customer_type = 1;
                            $obj_customer_info->created_by = $model->employee_id;
                            $obj_customer_info->created_date = date('Y-m-d');
                            $obj_customer_info->save();

                            $obj_customer = new CustomersContact();
                            $obj_customer->client_id = $client_id;
                            $obj_customer->customer_id = $obj_customer_info->id;
                            $obj_customer->mobile_number_lable = 1;
                            $obj_customer->mobile_number = $model->customer_number;
                            $obj_customer->save();
                            // end new customer
                            // start new enquiry
                            $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);


                            $exist = 0;
                            $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                            // start new Folloups

                            $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                            // end new Folloups
                        } else {
                            // don't insert enquiry
                            $this->sendMissedSms($model, $obj_employee, 0);
                            header("Content-type: text/xml; charset=utf-8");
                            echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
                            exit;
                        }
                    }
                }
            }
        }
        // end enquiry inserting code
    }

    public function outbound() {

        # mail('vivek@edynamics.co.in', 'Out bound call from '.$_SERVER[HTTP_HOST], 'testing Out bound call from '.$_SERVER[HTTP_HOST]);
        # $this->SMST('Out bound call from '.$_SERVER[HTTP_HOST],'78430999988',0,'NO','');
        $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parts = parse_url($url);
        parse_str($parts['query'], $_GET);
        set_time_limit(0);
        

        $call_date = $_GET['date'];
        $call_time = $_GET['time'];
        $caller_number = substr($_GET['caller_number'], -10);

        $caller_duration = $_GET['conversation_duration'];
        $call_connected_to = $_GET['agent_number'];
        $call_status = $_GET['call_status'];
        $call_recording_url = $_GET['recording_url'];
        $caller_circle = $_GET['caller_circle'];
        $module_enquiry_id = $_GET['enquiry_id'];

        $module_id = 10;
        $enquiry_id = $module_enquiry_id;

        $sip = $_GET['sip'];
        $caller_id = $_GET['caller_id'];

        $operator = $_GET['operator'];
        $customer_call_duration = $caller_duration;
        $agent_call_duration = $_GET['agent_duration'];
        $call_uuid = $_GET['callid'];
        $hangup_cause_leg_a = $_GET['hangup_cause_legA'];
        $hangup_cause_leg_b = $_GET['hangup_cause_legB'];
 
        //$caller_number = substr($caller_number, -10);
        $call_connected_to = trim($call_connected_to);
        $call_connected_to = substr($call_connected_to, -10);
  
        if (!empty($caller_id))
            $caller_id = substr($caller_id, -10);
        else
            $caller_id = '';
       
        $model = \App\Models\CtLogsOutbound::where(array('enquiry_id' => $enquiry_id,'employee_call_status' => '','call_date'=>date('Y-m-d')))->orderBy('id', 'DESC')->limit(1)->first();
//        echo '<pre>';
//        print_r($model);
//        exit;
        if (empty($model)) {
            $model = new \App\Models\CtLogsOutbound();
            $model->enquiry_id = $enquiry_id;
        }
        

        $model->call_date = $call_date;
        $model->call_time = $call_time;
        $model->customer_number = $caller_number;
        $model->total_call_duration = $caller_duration;
        $model->employee_number = $call_connected_to;
        $model->customer_call_status = $call_status;
        $model->employee_call_status = $call_status;
        $model->customer_circule = $caller_circle;
        //$model->enquiry_id			= $enquiry_id;		
        $model->sip_status = 0;
        $model->caller_id = $caller_id;

        $model->customer_operator = $operator;
        $model->employee_operator = $operator;
        $model->customer_call_duration = $customer_call_duration;
        $model->employee_call_duration = $agent_call_duration;
        $model->call_uuid = $call_uuid;
        $model->employee_hangup_cause = $hangup_cause_leg_a;
        $model->customer_hangup_cause = $hangup_cause_leg_b;
        $model->call_request_url = 1;

        // start recording move code		
        $file_path = $call_recording_url;
        $file_name = basename($file_path) . '.mp3';
        $folder = 'cloud_calling_logs';

        $model->call_recording_url = $file_name;

        $model->call_log_push_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        
        $v_number = '91'.$caller_id;
        $virtual_no_for_client_model = CtSetting::where(array('forwarding_number_knowlarity' => $v_number))->first();
        
        $client_id = $virtual_no_for_client_model->client_id;
        
        
      
        
        $obj_employee = Employee::where(['client_id' => $client_id])->where(['office_mobile_no' => $call_connected_to,'employee_status'=>1])->first();
        
        if(empty($obj_employee)){
            $obj_employee = Employee::where(['client_id' => $client_id])->where(['personal_mobile1' => $call_connected_to,'employee_status'=>1])->first();
        }
        
        $virtual_no_model = CtSetting::where(array('default_number' => 1, 'client_id' => $client_id))->first();
        
        $model->client_id = $client_id;
        $model->employee_id = $obj_employee->id;
        $model->save();
        
//        echo '<pre>here';
//        print_r($model);
//        echo $enquiry_id;exit;
        
        //$model = \App\Models\CtLogsOutbound::where(array('enquiry_id' => $enquiry_id))->orderBy('id', 'DESC')->limit(1)->offset(0)->first();
        $virtual_no = $virtual_no_for_client_model->forwarding_number_knowlarity;
        $enquiry_remark="";
        
        $empfullname = $obj_employee->first_name.' '.$obj_employee->last_name; 
        
        if ($virtual_no == '91'.$caller_id) {
            $virtual_number = substr($virtual_no_for_client_model->forwarding_number_knowlarity, -10);

                $enq_model = Enquiry::where(array('id' => $enquiry_id))->with('customerName','customerContact')->first();
                $fullName = $enq_model->customerName->first_name." ".$enq_model->customerName->last_name;
                if ($model->customer_call_status == 'Connected') {
                    $msg_body = 'Dear ' . $fullName . ', ';
                    $msg_body .= 'Your conversation held with ' . $empfullname . '(' . $virtual_number . ')';
                    $enquiry_remark = 'Outgoing call done through system remark is awaited by ' . $empfullname;
                    //Yii::$app->LMS->sendSMST($smsbody = $msg_body, $mobile_no = $model->caller_number, $user_id = $model->admin_user_id, $customer = 'Yes', $customer_id = $enq_model->customerDetail->id);
                } elseif ($model->customer_call_status == 'Missed') {
                    //$enquiry_remark = 'Out bound call made by '.$enq_model->admin_user_info->fullName.' but '.' customer not picking call OR out of coverage.';
                    $enquiry_remark = 'Outgoing call done through system by ' . $empfullname . ' but customer not picked-up or not reachable. Next followup is scheduled after one hour.';
                } elseif ($model->customer_call_status == 'None') {
                    $enquiry_remark = 'Out bound call made by ' . $empfullname . ' but ' . ' employee disconnected or not picked the call.';
                    $enquiry_remark = 'Outgoing call done through system but ' . $empfullname . ' is not picking up or not reachable. Next followup is scheduled after one hour.';
                }
       
                $result = $this->insertFollowupsByOutbound($enq_model, $obj_employee, $model->id, $enquiry_remark);
             if($model->customer_call_status == 'Connected'){
                $templatedata['employee_id'] = $obj_employee->id;
                $templatedata['client_id'] = $obj_employee->client_id;
                $templatedata['template_setting_customer'] = 31;//30;
                $templatedata['template_setting_employee'] = 32;//31;
                $templatedata['customer_id'] = $enq_model->customer_id;
                $templatedata['model_id'] = 0;

                $templatedata['arrExtra'][0] = array(
                );

                $templatedata['arrExtra'][1] = array(
                );

                $result = CommonFunctions::templateData($templatedata);
              //end template
            }
        }
        header("Content-type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
        exit;
       // $this->moveOutboundMP3();
    }

    public function insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description = '', $cloud_virtual_no_model) {

        $clientmodel = ClientInfo::where(['id' => $cloud_virtual_no_model->client_id])->first();

        $obj_enquiry = new Enquiry();
        $obj_enquiry->client_id = $obj_employee->client_id;
        $obj_enquiry->created_at = date('Y-m-d H:i:s'); //enquiry created date(in_date in LMS, created)
        $obj_enquiry->created_date = date('Y-m-d');
        $obj_enquiry->sales_enquiry_date = date('Y-m-d');
        $obj_enquiry->created_by = $obj_employee->id;
        $obj_enquiry->sales_source_id = $source_id;
        $obj_enquiry->sales_subsource_id = $cloud_virtual_no_model->sub_source_id;
        $obj_enquiry->sales_source_description = $source_description;
        // $obj_enquiry->customer_code 					= $obj_customer->customer_id;
        $obj_enquiry->customer_id = $obj_customer->customer_id;
        $obj_enquiry->sales_employee_id = $obj_employee->id;
        $obj_enquiry->sales_category_id = 1;
        $obj_enquiry->sales_status_id = 1;

        $obj_enquiry->finance_employee_id = 0;
        $obj_enquiry->exchange_employee_id = 0;
        $obj_enquiry->finance_required = 0;
        $obj_enquiry->exchange_required = 0;
        $obj_enquiry->save();
        
        $obj_enquiry_details = new \App\Models\EnquiryDetail();
        $obj_enquiry_details->enquiry_id = $obj_enquiry->id;
        $obj_enquiry_details->brand_id = $clientmodel->brand_id;
        $obj_enquiry_details->model_id = $cloud_virtual_no_model->model_project_id;
        $obj_enquiry_details->sub_model_id = 0;
        $obj_enquiry_details->veriant_id = 0;
        $obj_enquiry_details->sub_veriant_id = 0;
        $obj_enquiry_details->transmission_id = 0;
        $obj_enquiry_details->engine_id = 0;
        $obj_enquiry_details->fuel_id = 0;
        $obj_enquiry_details->color_id = 0;
        $obj_enquiry_details->created_date = date('Y-m-d');
        $obj_enquiry_details->created_by = $obj_employee->id;
        $obj_enquiry_details->save();
        return $obj_enquiry;
    }

    public function insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $cloud_virtual_no_model) {
        $customerinfo = Customer::where('id', $obj_customer->customer_id)->first();
        $obj_followups = new EnquiryFollowup();
        $obj_followups->followup_date_time = date("Y-m-d H:i:s");
        $obj_followups->call_recording_log_type = 1;
        $obj_followups->call_recording_id = $model->id;
        $obj_followups->enquiry_id = $obj_enquiry->id;
        $previous_followups = EnquiryFollowup::where('enquiry_id', $obj_enquiry->id)->orderBy('id', 'DESC')->first();
        if (!empty($previous_followups)){
            $obj_followups->sales_category_id = $previous_followups->sales_category_id;
            $obj_followups->sales_status_id = $previous_followups->sales_status_id;
        }
        else{
            $obj_followups->sales_category_id = 1;
            $obj_followups->sales_status_id = 1;
        }

        $sourceName = "";
        $subsourceName = "";
        $sourceDesc = "";

        if(!empty($obj_enquiry)){
                if(empty($obj_enquiry->sales_source_id))
                    $obj_enquiry->sales_source_id = '';
                else
                    $sourceName = $obj_enquiry->sourceName->sales_source_name;
                 
                if(empty($obj_enquiry->sales_subsource_id))
                     $obj_enquiry->sales_subsource_id = '';
                else
                    $subsourceName = $obj_enquiry->subsourceName->enquiry_subsource;
                
                if(empty($obj_enquiry->sales_source_description))
                     $obj_enquiry->sales_source_description = '';
                else
                    $sourceDesc = $obj_enquiry->sales_source_description;
                
            }
        
            if(!empty( $cloud_virtual_no_model->virtual_display_number)){
                $virtual_display_number = $cloud_virtual_no_model->virtual_display_number;
            }else
            {
                $virtual_display_number = '';
            }
        
        
        $obj_followups->followup_by = $obj_employee->id;

        if ($model->customer_call_status == 'Missed' || $model->customer_call_status == 'NotConnected') {
            if ($exist == 1) {
                $obj_followups->remarks = 'You have missed a call from ' . ' ' . $customerinfo->first_name . ' ' . $customerinfo->last_name . ' ( ' . $obj_customer->mobile_number . ' ) on virtual number  ( '.$virtual_display_number.' ) through ('.$sourceName . ' - ' . $subsourceName.' ) Please call Back ASAP.';
            } else {
                $obj_followups->remarks = 'New enquiry recieved through missed call by ( ' . $model->customer_number . ' ) on virtual number  ( '.$virtual_display_number.' ) through ('.$sourceName . ' - ' . $subsourceName.' ) Please call Back ASAP & enter remark.';
            }
        } else if ($model->customer_call_status == 'Connected') {
            if ($exist == 1) {
                $obj_followups->remarks = 'Incoming call received from ' . ' ' . $customerinfo->first_name . ' ' . $customerinfo->last_name . ' ( ' . $obj_customer->mobile_number . ' ) on virtual number  ( '.$virtual_display_number.' ) through ('.$sourceName . ' - ' . $subsourceName.' ) Attended By ' . $obj_employee->first_name;
            } else {
                $obj_followups->remarks = 'New enquiry recieved through incoming call by ( ' . $obj_customer->mobile_number . ' ) on virtual number  ( '.$virtual_display_number.' ) through ('.$sourceName . ' - ' . $subsourceName.' ) Attended By ' . $obj_employee->first_name;
            }
        }


        $h = date('H');
        $a = date('A');
   
        $time = '';
        $date = date('Y-m-d');
        
        if($h>=9 && $h<18){
            $time = ( $h + 1 ) . ':00:00';
        }else if($h > 0 && $h < 9)
        {
            $time = '10:00:00';
        }else if($h >= 18 && $h <= 23)
        {
            $time = '10:00:00';
            $date = date('Y-m-d', strtotime("+1 day"));
        }else
        {
            $time = '10:00:00';
        }
        
        $obj_followups->next_followup_date = $date;
        $obj_followups->next_followup_time = $time;

        $obj_followups->save();

        header("Content-type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
        exit;
    }

    public function insertFollowupsByOutbound($obj_enquiry, $obj_employee, $cloud_calling_logs_id, $enquiry_remark) {

        $c2c_log_model = \App\Models\CtLogsOutbound::where(array('id' => $cloud_calling_logs_id))->first();
        
        $obj_followups = new EnquiryFollowup();

        $h = date('H');
        $a = date('A');
   
        $time = '';
        $date = date('Y-m-d');
        
        if($h>=9 && $h<18){
            $time = ( $h + 1 ) . ':00:00';
        }else if($h > 0 && $h < 9)
        {
            $time = '10:00:00';
         }else if($h >= 18 && $h <= 23)
        {
            $time = '10:00:00';
            $date = date('Y-m-d', strtotime("+1 day"));
        }else
        {
            $time = '10:00:00';
        }

        $obj_followups->next_followup_date = $date;
        $obj_followups->next_followup_time = $time;
        
        $obj_followups->followup_date_time = date("Y-m-d H:i:s");
        $obj_followups->call_recording_log_type = 2;
        $obj_followups->call_recording_id = $c2c_log_model->id;
        $obj_followups->enquiry_id = $obj_enquiry->id;
        $obj_followups->remarks = $enquiry_remark;
        $previous_followups = EnquiryFollowup::where('enquiry_id', $obj_enquiry->id)->orderBy('id', 'DESC')->first();
        if (!empty($previous_followups)){
            $obj_followups->sales_category_id = $previous_followups->sales_category_id;
            $obj_followups->sales_status_id = $previous_followups->sales_status_id;
        }
        else{
            $obj_followups->sales_category_id = 1;
            $obj_followups->sales_status_id = 1;
        }


        $obj_followups->sales_status_id = $obj_enquiry->sales_status_id;
        $obj_followups->followup_by = $obj_employee->id;
        $obj_followups->followup_entered_through = 9;
        $obj_followups->save();
        
        return true;
    }

    public function sendMissedSms($model, $obj_employee, $exist = 0, $nonworkinghours = 0) {
        /*
         * $exist=0   new 
         * $exist=1   exist customer
         * 
         */
        $sourceName = "";
        $subsourceName = "";
        if($model->source_id > 0){
            $getSource = \App\Models\MlstLmsaEnquirySalesSource::where('id',$model->source_id)->first();
            if(!empty($getSource)){
                $sourceName = $getSource->sales_source_name;
            }
        }
        if($model->sub_source_id > 0){
            $getsubSource = \App\Models\EnquirySalesSubsource::where('id',$model->sub_source_id)->first();
            if(!empty($getsubSource)){
                $subsourceName = $getsubSource->enquiry_subsource;
            }
        }

        //send sms to customer
        if ($exist == 0) {

            if ($model->call_status == 'Connected') {
                //customer  
                $templatedata['employee_id'] = $obj_employee->id;
                $templatedata['client_id'] = $obj_employee->client_id;
                $templatedata['template_setting_customer'] = 10;// 32;
                $templatedata['template_setting_employee'] = 9;//33;
                $templatedata['customer_id'] = 0;
                $templatedata['model_id'] = 0;

                $templatedata['arrExtra'][0] = array(
                    '[#customerName#]',
                    '[#customerMobile#]',
                    '[#enuiqrySource#]',
                    '[#enuiqrySubSource#]',
                    '[#greeting#]'
                );

                $templatedata['arrExtra'][1] = array(
                    "",
                    $model->caller_number,
                    $sourceName,
                    $subsourceName,
                    $greeting_msg
                );

                $result = CommonFunctions::templateData($templatedata);
            } else if ($model->call_status == 'NotConnected' && $nonworkinghours == 1) {
                //customer  
                $templatedata['employee_id'] = $obj_employee->id;
                $templatedata['client_id'] = $obj_employee->client_id;
                $templatedata['template_setting_customer'] = 15;//30;
                $templatedata['template_setting_employee'] = 11;//31;
                $templatedata['customer_id'] = 0;
                $templatedata['model_id'] = 0;

                $templatedata['arrExtra'][0] = array(
                    '[#customerName#]',
                    '[#customerMobile#]',
                    '[#enuiqrySource#]',
                    '[#enuiqrySubSource#]',
                    '[#greeting#]'
                );

                $templatedata['arrExtra'][1] = array(
                    "Customer",
                    $model->caller_number,
                    $sourceName,
                    $subsourceName,
                    $greeting_msg
                );

                $result = CommonFunctions::templateData($templatedata);
            } else {
                //customer  
                $templatedata['employee_id'] = $obj_employee->id;
                $templatedata['client_id'] = $obj_employee->client_id;
                $templatedata['template_setting_customer'] = 15;//30;
                $templatedata['template_setting_employee'] = 11;//31;
                $templatedata['customer_id'] = 0;
                $templatedata['model_id'] = $model->model_project_id;

                $templatedata['arrExtra'][0] = array(
                    '[#customerName#]',
                    '[#customerMobile#]',
                    '[#enuiqrySource#]',
                    '[#enuiqrySubSource#]',
                    '[#greeting#]'
                );

                $templatedata['arrExtra'][1] = array(
                    "Customer",
                    $model->caller_number,
                    $sourceName,
                    $subsourceName,
                    $greeting_msg
                );

                $result = CommonFunctions::templateData($templatedata);
            }
        }
        //customer

        header("Content-type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
    }

    public function sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id = 0, $exist = 0) {

        /*
         * $exist=0   new 
         * $exist=1   exist customer
         * 
         */

        /* ||---Customer--|| */

         $short_url_result = '';
        if ($exist == 1) {
            if ($model->customer_call_status == 'Connected') {
                //existing customer connected
                //customer  
                //$next_url = $server_url . "customer_info_form?t=" . urlencode($string) . "&d=" . urlencode(base64_encode($obj_customer->id)) . "&eq=" . urlencode(base64_encode($obj_enquiry->id));
                //$longUrl = $next_url;
                $server_url =    $_SERVER['HTTP_HOST'].'/website/customerform/'.base64_encode($obj_customer->customer_id);
//                $server_url = 'http://businessapps.co.in';
                $return_val = $this->shortenUrl($server_url);
                $short_url_result = $return_val['id'];
                $templatedata['employee_id'] = $obj_employee->id;
                $templatedata['client_id'] = $obj_employee->client_id;
                $templatedata['template_setting_customer'] =  6;//19;
                $templatedata['template_setting_employee'] = 12;//20;
                $templatedata['customer_id'] = $obj_customer->customer_id;
                $templatedata['model_id'] = $model_id;
                $templatedata['obj_enquiry'] = $obj_enquiry;


                $templatedata['arrExtra'][0] = array(
                    '[#customerFormLink#]'
                );
                $templatedata['arrExtra'][1] = array(
                    $short_url_result
                );

                $result = CommonFunctions::templateData($templatedata);
            } else if ($model->customer_call_status == 'Missed' || $model->customer_call_status == 'NotConnected') {
                //existing customer missed call
                //customer 
                //echo "<pre>"; print_r($model);exit;
//                $server_url = 'http://businessapps.co.in';
                $server_url =    $_SERVER['HTTP_HOST'].'/website/customerform/'.base64_encode($obj_customer->customer_id);
                $return_val = $this->shortenUrl($server_url);
                $short_url_result = $return_val['id'];
                //$short_url_result = $return_val['id'];
                
                $templatedata['employee_id'] = $obj_employee->id;
                $templatedata['client_id'] = $obj_employee->client_id;
                $templatedata['template_setting_customer'] = 16;//21;
                $templatedata['template_setting_employee'] = 17;//22;
                $templatedata['customer_id'] = $obj_customer->customer_id;
                $templatedata['model_id'] = $model_id;
                $templatedata['obj_enquiry'] = $obj_enquiry;

                $templatedata['arrExtra'][0] = array(
                    '[#customerFormLink#]'
                );
                $templatedata['arrExtra'][1] = array(
                    $short_url_result
                );

                $result = CommonFunctions::templateData($templatedata);
            }
        }
        if ($exist == 0) {
            if ($model->customer_call_status == 'Connected') {
                //new customer connected call
                //customer  
                $server_url =    $_SERVER['HTTP_HOST'].'/website/customerform/'.base64_encode($obj_customer->customer_id);
               // $server_url = 'http://businessapps.co.in';
                $return_val = $this->shortenUrl($server_url);
                $short_url_result = $return_val['id'];
               // $short_url_result = "#";//$return_val['id'];
                
                $templatedata['employee_id'] = $obj_employee->id;
                $templatedata['client_id'] = $obj_employee->client_id;
                $templatedata['template_setting_customer'] = 7;//17;
                $templatedata['template_setting_employee'] = 8;//18;
                $templatedata['customer_id'] = $obj_customer->customer_id;
                $templatedata['model_id'] = $model_id;
                $templatedata['obj_enquiry'] = $obj_enquiry;

                $templatedata['arrExtra'][0] = array(
                    '[#customerFormLink#]'
                );
                $templatedata['arrExtra'][1] = array(
                    $short_url_result
                );

                $result = CommonFunctions::templateData($templatedata);
            } else if ($model->customer_call_status == 'Missed' || $model->customer_call_status == 'NotConnected') {

                $server_url =    $_SERVER['HTTP_HOST'].'/website/customerform/'.base64_encode($obj_customer->customer_id);
              //  $server_url = 'http://businessapps.co.in';
                $return_val = $this->shortenUrl($server_url);
                $short_url_result = $return_val['id'];
           //     $short_url_result = "#";//$return_val['id'];
                
                $templatedata['employee_id'] = $obj_employee->id;
                $templatedata['client_id'] = $obj_employee->client_id;
                $templatedata['template_setting_customer'] = 13;//15;
                $templatedata['template_setting_employee'] = 14;//16;
                $templatedata['customer_id'] = $obj_customer->customer_id;
                $templatedata['model_id'] = $model_id;
                $templatedata['obj_enquiry'] = $obj_enquiry;

                $templatedata['arrExtra'][0] = array(
                    '[#customerFormLink#]'
                );
                $templatedata['arrExtra'][1] = array(
                    $short_url_result
                );

                $result = CommonFunctions::templateData($templatedata);
            }
        }

        /* customer */
    }

    public function moveOutboundMP3() {
        
        $recoreds = \App\Models\CtLogsOutbound::where(['employee_call_status' => 'Connected'])->orderBy('id', 'desc')->limit(500)->offset(0)->get();
        
        if (!empty($recoreds)) {
            $i = 1;
            foreach ($recoreds as $recored) {
                if ($recored->call_log_push_url != '') {
                    $url = '';
                    $arrs = explode('&', $recored->call_log_push_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                    if ($url != '' && strpos($url, "http") !== false) {
                        try {
                                $org_file_path = urldecode($url);
                                $live_file = basename($org_file_path) . '.mp3';
                                $s3FolderName = 'recorded_file';
                                $name = S3::s3FileUpload($org_file_path, $live_file, $s3FolderName);
                                $recored->call_recording_url = $live_file;
                                $recored->save();
                                $i++;
                                header("Content-type: text/xml; charset=utf-8");
                                echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
                                exit;
                            } catch (Exception $e) {
                                 echo 'Caught exception: ',  $e->getMessage(), "\n";
                            }
                    } else {
                         echo '<br>recording id =>'.$recored->id.' failed to transfer.<br>';
                    }
                }
            }
            
        } 
    }

    public function moveMP3() {

        $recoreds = CloudCallingLogsModel::where(['mp3_status' => 0, 'call_status' => 'Connected'])->orderBy(['id' => SORT_DESC])->limit(500)->offset(0)->get();

        if (!empty($recoreds)) {
            $i = 1;
            //   echo '<br>Inbound recording moving to AWS S3 started...<br>'; 
            foreach ($recoreds as $recored) {
                if ($recored->call_recording_url != '') {
                    $url = '';
                    $arrs = explode('&', $recored->request_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                    if ($url != '') {
                        try {
                            $org_file_path = urldecode($url);
                            $live_file = basename($org_file_path) . '.mp3';
                            $temp_file = $this->temp_path . $recored->call_recording_url;
                            file_put_contents($temp_file, fopen($org_file_path, 'r'));
                            // $folder ='cloud_calling/call_logs/inbound';							
                            // Yii::app()->s3->awsupload( $temp_file, $folder, $live_file );	
                            $temp_file = $this->temp_path . $live_file;

                            $awsModel = new Aws();
                            $awsPath = 'cloud_calling/call_logs/inbound/';
                            $isUploadedPhoto = $awsModel->uploadFile($awsPath, $temp_file);

                            $recored->call_recording_url = $live_file;
                            $recored->mp3_status = 1;
                            $recored->save(false);
                            @unlink($temp_file);
                            $i++;
                            // echo '<br>recording id =>'.$recored->id.' transferred.<br>';
                        } catch (Exception $e) {
                            //  echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }
                    } else {
                        //   echo '<br>recording id =>'.$recored->id.' failed to transfer.<br>';
                    }
                }
            }
            //    echo "Total $i recordings moved successfully.";                           
            //  echo '<br>Inbound recording moving Ended...<br>';
        } else {
            // echo '<br>No Inbound recordings found<br>';
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

    public function myIncomingLogs() {
        return view("CloudTelephony::inboundlogs")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function teamIncomingLogs() {
        return view("CloudTelephony::teaminboundlogs")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function myInboundLogs() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
             if ($request['filterFlag'] == 1) {
                 CloudCallingLogsController::$procname = "proc_team_inboundlogs";
                return $this->filteredData();
                exit;
            }
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
           
        }
        $getInboundLoglist = array();
        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage']; 
        $getCountInboundLogs = CtLogsInbound::leftjoin('lmsauto_master_final.mlst_lmsa_enquiry_sales_sources as ls', 'ls.id', '=', 'ct_logs_inbounds.source_id')
                            ->leftjoin('employees as emp', 'emp.id', '=', 'ct_logs_inbounds.employee_id')
                            ->leftjoin('enquiry_sales_subsources as subs', 'subs.id', '=', 'ct_logs_inbounds.sub_source_id')
                            ->leftjoin('customers_contacts as cc', 'cc.mobile_number', '=', 'ct_logs_inbounds.customer_number')
                            ->leftjoin('customers as cust', 'cust.id', '=', 'cc.customer_id')
                            ->orderBy('ct_logs_inbounds.id','DESC')
                            ->where('ct_logs_inbounds.employee_id', $emp_id)
                            ->count(); 
        
        $getInboundLogs = CtLogsInbound::leftjoin('lmsauto_master_final.mlst_lmsa_enquiry_sales_sources as ls', 'ls.id', '=', 'ct_logs_inbounds.source_id')
                        ->leftjoin('employees as emp', 'emp.id', '=', 'ct_logs_inbounds.employee_id')
                        ->leftjoin('enquiry_sales_subsources as subs', 'subs.id', '=', 'ct_logs_inbounds.sub_source_id')
                        ->leftjoin('customers_contacts as cc', 'cc.mobile_number', '=', 'ct_logs_inbounds.customer_number')
                        ->leftjoin('customers as cust', 'cust.id', '=', 'cc.customer_id')
                        ->orderBy('ct_logs_inbounds.id','DESC')
                        ->select('ct_logs_inbounds.id','ct_logs_inbounds.call_log_push_url', DB::raw('DATE_FORMAT(ct_logs_inbounds.call_date, "%d-%m-%Y") as call_date'), DB::raw('DATE_FORMAT(ct_logs_inbounds.call_time, "%h:%i %p") as call_time'), 'ct_logs_inbounds.customer_call_status', 'ct_logs_inbounds.customer_call_duration', 'ct_logs_inbounds.virtual_number', 'ct_logs_inbounds.customer_number', 'ct_logs_inbounds.call_recording_url', 'emp.first_name', 'emp.last_name', 'ls.sales_source_name','subs.enquiry_subsource', 'cust.first_name as cfirst_name', 'cust.last_name as clast_name','emp.title_id as emp_title_id','cust.title_id as cust_title_id')
                        ->where('ct_logs_inbounds.employee_id', $emp_id)
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
        
      
        $i = 0;
        if (!empty($getInboundLogs)) {
            foreach ($getInboundLogs as $getInboundLog) {
                $url = '';
                    $arrs = explode('&', $getInboundLog->call_log_push_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                $getInboundLogs[$i]->call_recording_url = $url;//config('global.s3Path') . '/recorded_file/' . $getInboundLog->call_recording_url;
                $getInboundLogs[$i]->employee_name = $getInboundLog->first_name . ' ' . $getInboundLog->last_name;
                $getInboundLogs[$i]->customer_name = $getInboundLog->cfirst_name . ' ' . $getInboundLog->clast_name;
                $getInboundLogs[$i]->emptitle_id = $getInboundLog->emp_title_id;
                $getInboundLogs[$i]->custtitle_id = $getInboundLog->cust_title_id;
                
                unset($getInboundLogs[$i]->first_name);
                unset($getInboundLogs[$i]->last_name);
                unset($getInboundLogs[$i]->cfirst_name);
                unset($getInboundLogs[$i]->clast_name);
                unset($getInboundLogs[$i]->emp_title_id);
                unset($getInboundLogs[$i]->cust_title_id);
                $i++;
            }
        }
        if(!empty($getInboundLogs[0])){
            $result = ['success' => true, 'records' => $getInboundLogs, 'totalCount' => $getCountInboundLogs];
        }else{
            $result = ['success' => false, 'records' => $getInboundLogs, 'totalCount' => $getCountInboundLogs];
        }
        return json_encode($result);
    }

    public function teamInboundLogs() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
            
        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
             if ($request['filterFlag'] == 1) {
                 CloudCallingLogsController::$procname = "proc_team_inboundlogs";
                return $this->filteredData();
                exit;
            }
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
           
        }
        $this->tuserid($emp_id);
        $alluser = $this->allusers;
        $getInboundLoglist = array();
        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage']; 
        $getCountInboundLogs = CtLogsInbound::leftjoin('lmsauto_master_final.mlst_lmsa_enquiry_sales_sources as ls', 'ls.id', '=', 'ct_logs_inbounds.source_id')
                        ->leftjoin('enquiry_sales_subsources as subs', 'subs.id', '=', 'ct_logs_inbounds.sub_source_id')
                        ->leftjoin('employees as emp', 'emp.id', '=', 'ct_logs_inbounds.employee_id')
                        ->leftjoin('customers_contacts as cc', 'cc.mobile_number', '=', 'ct_logs_inbounds.customer_number')
                        ->leftjoin('customers as cust', 'cust.id', '=', 'cc.customer_id')
                        ->orderBy('ct_logs_inbounds.id','DESC')
                        ->whereIN('ct_logs_inbounds.employee_id', $alluser)
                        ->count();
        
        $getInboundLogs = CtLogsInbound::leftjoin('lmsauto_master_final.mlst_lmsa_enquiry_sales_sources as ls', 'ls.id', '=', 'ct_logs_inbounds.source_id')
                        ->leftjoin('enquiry_sales_subsources as subs', 'subs.id', '=', 'ct_logs_inbounds.sub_source_id')
                        ->leftjoin('employees as emp', 'emp.id', '=', 'ct_logs_inbounds.employee_id')
                        ->leftjoin('customers_contacts as cc', 'cc.mobile_number', '=', 'ct_logs_inbounds.customer_number')
                        ->leftjoin('customers as cust', 'cust.id', '=', 'cc.customer_id')
                        ->orderBy('ct_logs_inbounds.id','DESC')
                        ->select('ct_logs_inbounds.id','ct_logs_inbounds.call_log_push_url', DB::raw('DATE_FORMAT(ct_logs_inbounds.call_date, "%d-%m-%Y") as call_date'), DB::raw('DATE_FORMAT(ct_logs_inbounds.call_time, "%h:%i %p") as call_time'), 'ct_logs_inbounds.customer_call_status', 'ct_logs_inbounds.customer_call_duration', 'ct_logs_inbounds.virtual_number', 'ct_logs_inbounds.customer_number', 'ct_logs_inbounds.call_recording_url', 'emp.first_name', 'emp.last_name', 'ls.sales_source_name','subs.enquiry_subsource', 'cust.first_name as cfirst_name', 'cust.last_name as clast_name','emp.title_id as emp_title_id','cust.title_id as cust_title_id')
                        ->whereIN('ct_logs_inbounds.employee_id', $alluser)
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
        $i = 0;
        if (!empty($getInboundLogs)) {
            foreach ($getInboundLogs as $getInboundLog) {
                $url = '';
                    $arrs = explode('&', $getInboundLog->call_log_push_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                $getInboundLogs[$i]->call_recording_url = $url;//config('global.s3Path') . '/recorded_file/' . $getInboundLog->call_recording_url;
                $getInboundLogs[$i]->employee_name = $getInboundLog->first_name . ' ' . $getInboundLog->last_name;
                $getInboundLogs[$i]->customer_name = $getInboundLog->cfirst_name . ' ' . $getInboundLog->clast_name;
                $getInboundLogs[$i]->emptitle_id = $getInboundLog->emp_title_id;
                $getInboundLogs[$i]->custtitle_id = $getInboundLog->cust_title_id;
                unset($getInboundLogs[$i]->first_name);
                unset($getInboundLogs[$i]->last_name);
                unset($getInboundLogs[$i]->cfirst_name);
                unset($getInboundLogs[$i]->clast_name);
                unset($getInboundLogs[$i]->emp_title_id);
                unset($getInboundLogs[$i]->cust_title_id);
                $i++;
            }
        }
        
        
        if(!empty($getInboundLogs[0])){
            $result = ['success' => true, 'records' => $getInboundLogs, 'totalCount' => $getCountInboundLogs];
        }else{
            $result = ['success' => false, 'records' => $getInboundLogs, 'totalCount' => $getCountInboundLogs];
        }
        return json_encode($result);
    }
    
    
    
    
    public function outboundCalltrigger() {
        
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        date_default_timezone_set('Asia/Kolkata');
        
        $employee_id = $request["employee_id"];
        $agent_number = $request["employee_number"];
        $customer_number = $request["customer_number"];
        $domain_name = $request["domain_name"];
        $enquiry_id = $request["enquire_id"];
        $client_id = $request["client_id"];
        $call_date = date('Y-m-d');
        $call_time = date('H:i:s');
       
        //$validate = EmployeeModel::find()->where(['authkey' => $authkey])->one();
        
        $validate = Employee::where(['id' => $employee_id])->first();

        if (!empty($validate)) {

            //.....................Getting virtual number......................................
            $virtual_number = CtSetting::where(['client_id' => $validate->client_id, 'default_number' => 1])->first();
            $caller_id = $virtual_number->forwarding_number_knowlarity;
            //................................................................................
            //preparing query for inserting new call log. 	
            if(!empty($caller_id)){
            $prev_call_check = \App\Models\CtLogsOutbound::where(['employee_id' => $employee_id])->orderBy('id', 'desc')->first();

            $sql = new \App\Models\CtLogsOutbound();
            $sql->employee_id = $employee_id;
            $sql->client_id = $client_id;
            $sql->call_date = $call_date;
            $sql->call_time = $call_time;
            $sql->customer_number = $customer_number;
            $sql->employee_number = $agent_number;
            $sql->enquiry_id = $enquiry_id;
            $sql->sip_status = 1;
            $sql->caller_id = $caller_id;
            $sql->save();
            //getting last inserted call log of logged in user to checking last call time interval
            // print_r($prev_call_check);exit;
            
            if (!empty($prev_call_check)) {

                $prev_call_check_row = $prev_call_check;
                //Checking for is last call active since 90 sec
                $timeFirst = strtotime($call_date . $call_time);

                $timeSecond = strtotime($prev_call_check_row->call_date . $prev_call_check_row->call_time);

                $differenceInSeconds = $timeFirst - $timeSecond;
                //echo $differenceInSeconds; exit;
                if ($differenceInSeconds > 90) {

                    $prev_call_check_row->call_request_url = 2;
                    $prev_call_check_row->save();

                    if (isset($prev_call_check_row)) {
                        $request = "auth_key=aabb23a8a029-8bd4-4e44-97ccaa_bapps&agent_number=+91" . $agent_number . "&customer_number=+91" . $customer_number . '&caller_id=+' . $caller_id . '&domain_name=' . $domain_name . '&enquire_id=' . $enquiry_id;
                        $url = "http://etsrds.kapps.in/webapi/bapps/api/bapps_c2c_cbk.py?" . $request;
                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $xml_response = curl_exec($ch);
                        $xml = simplexml_load_string($xml_response);
                        curl_close($ch);

                        $result = ['success' => true,'message' =>'Call triggered successfully, please wait...',  'request_url' => $url];
                        
                    } else {
                        $result = ['success' => false,'message' =>'Problem in call connecting'];
                    }
                } else {
                    $result = ['success' => false,'message' =>'Previous call already in progress'];
                }
            } else {

                //inserting new call log

                if (!empty($sql->id)) {
                    $request = "auth_key=aabb23a8a029-8bd4-4e44-97ccaa_bapps&agent_number=+91" . $agent_number . "&customer_number=+91" . $customer_number . '&sip=1&caller_id=+' . $caller_id . '&domain_name=' . $domain_name . '&enquire_id=' . $enquiry_id;
                    $url = "http://etsrds.kapps.in/webapi/bapps/api/bapps_c2c_cbk.py?" . $request;
                    $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $xml_response = curl_exec($ch);
                        $xml = simplexml_load_string($xml_response);
                        curl_close($ch);
                    $result = ['success' => true,'message' =>'Call triggered successfully, please wait...',  'request_url' => $xml_response.$request];
                } else {
                    $result = ['success' => false,'message' =>'Problem in call connecting'];
                }
            }
            }else{
                $result = ['success' => false,'message' =>'You have no permission to call'];
            }
        } else {
            $result = ['success' => false,'message' =>'Login expired, please logout & login again'];
        }
        return json_encode($result);
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

    
    
    // outbound call logs listing start
    
    public function myOutgoingLogs() {
        return view("CloudTelephony::outboundlogs")->with("loggedInUserId", Auth::guard('admin')->user()->id);
}

    public function teamOutgoingLogs() {
        return view("CloudTelephony::teamoutboundlogs")->with("loggedInUserId", Auth::guard('admin')->user()->id);
    }

    public function myOutboundLogs() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
             if ($request['filterFlag'] == 1) {
                 CloudCallingLogsController::$procname = "proc_team_outboundlogs";
                return $this->filteredoutboundData();
                exit;
            }
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
            
        }
        $getOutboundLoglist = array();
        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage']; 
        $getCountOutboundLogs = CtLogsOutbound::leftjoin('employees as emp', 'emp.id', '=', 'ct_logs_outbounds.employee_id')
                            ->leftjoin('customers_contacts as cc', 'cc.mobile_number', '=', 'ct_logs_outbounds.customer_number')
                            ->leftjoin('customers as cust', 'cust.id', '=', 'cc.customer_id')
                            ->orderBy('ct_logs_outbounds.id','DESC')
                            ->where('ct_logs_outbounds.employee_id', $emp_id)
                            ->count(); 
        
        $getOutboundLogs = CtLogsOutbound::leftjoin('employees as emp', 'emp.id', '=', 'ct_logs_outbounds.employee_id')
                        ->leftjoin('customers_contacts as cc', 'cc.mobile_number', '=', 'ct_logs_outbounds.customer_number')
                        ->leftjoin('customers as cust', 'cust.id', '=', 'cc.customer_id')
                        ->groupBy('ct_logs_outbounds.id')
                        ->orderBy('ct_logs_outbounds.id','DESC')
                        ->select('ct_logs_outbounds.id','ct_logs_outbounds.call_log_push_url', DB::raw('DATE_FORMAT(ct_logs_outbounds.call_date, "%d-%m-%Y") as call_date'), DB::raw('DATE_FORMAT(ct_logs_outbounds.call_time, "%h:%i %p") as call_time'), 'ct_logs_outbounds.customer_call_status', 'ct_logs_outbounds.customer_call_duration', 'ct_logs_outbounds.customer_number', 'ct_logs_outbounds.call_recording_url', 'emp.first_name', 'emp.last_name', 'cust.first_name as cfirst_name', 'cust.last_name as clast_name','emp.title_id as emp_title_id','cust.title_id as cust_title_id')
                        ->where('ct_logs_outbounds.employee_id', $emp_id)
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
        $i = 0;
        if (!empty($getOutboundLogs)) {
            foreach ($getOutboundLogs as $getOutboundLog) {
                $url = '';
                    $arrs = explode('&', $getOutboundLog->call_log_push_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                $getOutboundLogs[$i]->call_recording_url = $url;//config('global.s3Path') . '/recorded_file/' . $getOutboundLog->call_recording_url;
                $getOutboundLogs[$i]->employee_name = $getOutboundLog->first_name . ' ' . $getOutboundLog->last_name;
                $getOutboundLogs[$i]->customer_name = $getOutboundLog->cfirst_name . ' ' . $getOutboundLog->clast_name;
                $getOutboundLogs[$i]->emptitle_id =  $getOutboundLog->emp_title_id;
                $getOutboundLogs[$i]->custtitle_id = $getOutboundLog->cust_title_id;
                unset($getOutboundLogs[$i]->first_name);
                unset($getOutboundLogs[$i]->last_name);
                unset($getOutboundLogs[$i]->cfirst_name);
                unset($getOutboundLogs[$i]->clast_name);
                unset($getOutboundLogs[$i]->emp_title_id);
                unset($getOutboundLogs[$i]->cust_title_id);
                $i++;
            }
        }
        
       
        if(!empty($getOutboundLogs[0])){
            $result = ['success' => true, 'records' => $getOutboundLogs, 'totalCount' => $getCountOutboundLogs];
        }else{
            $result = ['success' => false, 'records' => $getOutboundLogs, 'totalCount' => $getCountOutboundLogs];
        }
        
        
        return json_encode($result);
    }

    public function teamOutboundLogs() {

        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);

        if (!empty($request["employee_id"])) {
            $emp_id = $request["employee_id"];
             if ($request['filterFlag'] == 1) {
                 CloudCallingLogsController::$procname = "proc_team_outboundlogs";
                return $this->filteredoutboundData();
                exit;
            }
        } else {
            $emp_id = Auth::guard('admin')->user()->id;
        }

        $this->tuserid($emp_id);
        $alluser = $this->allusers;
        $getOutboundLoglist = array();
        $startFrom = ($request['pageNumber'] - 1) * $request['itemPerPage']; 
        $getCountOutboundLogs = CtLogsOutbound::leftjoin('employees as emp', 'emp.id', '=', 'ct_logs_outbounds.employee_id')
                        ->leftjoin('customers_contacts as cc', 'cc.mobile_number', '=', 'ct_logs_outbounds.customer_number')
                        ->leftjoin('customers as cust', 'cust.id', '=', 'cc.customer_id')
                        ->orderBy('ct_logs_outbounds.id','DESC')
                        ->whereIN('ct_logs_outbounds.employee_id', $alluser)
                        ->count();
        
        $getOutboundLogs = CtLogsOutbound::leftjoin('employees as emp', 'emp.id', '=', 'ct_logs_outbounds.employee_id')
                        ->leftjoin('customers_contacts as cc', 'cc.mobile_number', '=', 'ct_logs_outbounds.customer_number')
                        ->leftjoin('customers as cust', 'cust.id', '=', 'cc.customer_id')
                        ->groupBy('ct_logs_outbounds.id')
                        ->orderBy('ct_logs_outbounds.id','DESC')
                        ->select('ct_logs_outbounds.id','ct_logs_outbounds.call_log_push_url', DB::raw('DATE_FORMAT(ct_logs_outbounds.call_date, "%d-%m-%Y") as call_date'), DB::raw('DATE_FORMAT(ct_logs_outbounds.call_time, "%h:%i %p") as call_time'), 'ct_logs_outbounds.customer_call_status', 'ct_logs_outbounds.customer_call_duration', 'ct_logs_outbounds.customer_number', 'ct_logs_outbounds.call_recording_url', 'emp.first_name', 'emp.last_name', 'cust.first_name as cfirst_name', 'cust.last_name as clast_name','emp.title_id as emp_title_id','cust.title_id as cust_title_id')
                        ->whereIN('ct_logs_outbounds.employee_id', $alluser)
                        ->take($request['itemPerPage'])->offset($startFrom)
                        ->get();
        $i = 0;
        if (!empty($getOutboundLogs)) {
            foreach ($getOutboundLogs as $getOutboundLog) {
                $url = '';
                    $arrs = explode('&', $getOutboundLog->call_log_push_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                $getOutboundLogs[$i]->call_recording_url = $url;//config('global.s3Path') . '/recorded_file/' . $getOutboundLog->call_recording_url;
                $getOutboundLogs[$i]->employee_name = $getOutboundLog->first_name . ' ' . $getOutboundLog->last_name;
                $getOutboundLogs[$i]->customer_name = $getOutboundLog->cfirst_name . ' ' . $getOutboundLog->clast_name;
                $getOutboundLogs[$i]->emptitle_id = $getOutboundLog->emp_title_id;
                $getOutboundLogs[$i]->custtitle_id = $getOutboundLog->cust_title_id;
                unset($getOutboundLogs[$i]->first_name);
                unset($getOutboundLogs[$i]->last_name);
                unset($getOutboundLogs[$i]->cfirst_name);
                unset($getOutboundLogs[$i]->clast_name);
                unset($getOutboundLogs[$i]->emp_title_id);
                unset($getOutboundLogs[$i]->cust_title_id);
                $i++;
            }
        }
        if(!empty($getOutboundLogs[0])){
            $result = ['success' => true, 'records' => $getOutboundLogs, 'totalCount' => $getCountOutboundLogs];
        }else{
            $result = ['success' => false, 'records' => $getOutboundLogs, 'totalCount' => $getCountOutboundLogs];
        }
        return json_encode($result);
    }
    
    // outbound call logs listing end
    
     /*
      Date:4 july 2017 
      Export to excel cloud Telephony Log */
    
    public function inLogexportToExcel(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $data = $request['result']; 
        // echo '<pre>';print_r($data); exit;
        $reportName = $request['reportName'];
        $currentDate = date('_d_m_Y_h_i_s_A');
      
         if(!empty($request['first_name']))
           $first_name = $request['first_name'];
       else
           $first_name = Auth::guard('admin')->user()->first_name;
       
       if(!empty($request['last_name']))
           $last_name = $request['last_name'];
       else
        $last_name = Auth::guard('admin')->user()->last_name;
             
       $fileName = $reportName . $currentDate . "_by_" .  $first_name. "_" . $last_name;
                  
        ob_end_clean();        
        Excel::create($fileName, function($excel) use ($data,$reportName) {
            $excel->sheet($reportName, function($sheet) use ($data, $reportName) {
                $sheet->mergeCells('A1:L1');
                $sheet->setHeight("1", 45);
                $sheet->cells('A1:L1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontColor('#161515'); 
                    $cells->setBackground('#50a7ff');
                    $cells->setBorder('thick', 'thick', 'thick', 'thick');// Set all borders (top, right, bottom, left)
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '22',
                    ));
                });
               
                $sheet->mergeCells('A2:L2');
                
                $title = str_replace('_', ' ', $reportName);
                $sheet->row(1, array('LMS Auto - '.$title));
               
                $sheet->appendRow(["Sr.No","Call Date & Time","Virtual Number","Caller Number","Title","Customer Name","Call Status","Title","Call Answered By",
                    "Call Duration","Source Name","Sub Source"]);
                
           
                $sheet->row(3, function ($row) {
                    $row->setAlignment('center');
                    $row->setBackground('#77b9fb');
                    $row->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '12',
                    ));
                });
                
                $i = 1;
                // putting users data as next rows
                foreach ($data as $user) {
                    $srno = ["srno" => $i++];
                                    
                    if(!empty($user['enquiry_subsource'])){
                        $subsource=$user['enquiry_subsource'];
                    }else{
                        $subsource="--";
                    }
                    if(!empty($user['customer_name'])){
                        $customer_name=$user['customer_name'];
                    }else{
                        $customer_name="--";
                    }
                    
                    if(!empty($user['employee_name'])){
                       $employee_name=$user['employee_name'];   
                   }else{
                       $employee_name="--";
                   }
                   if(!empty($user['virtual_number'])){
                       $virtual_number=$user['virtual_number'];
                   }else{
                        $virtual_number="--";
                   }
                   
                   if(!empty($user['customer_call_status'])){
                       $customer_call_status=$user['customer_call_status'];
                   }else{
                       $customer_call_status="--";
                   }
                  
                 
                   
                   if(!empty($user['emptitle_id'])){
                     $emptitle = \App\Models\MlstTitle::select('title')->where('id', '=', $user['emptitle_id'])->first();  
                     if(!empty($emptitle->title))
                      $emp_title= $emptitle->title; 
                     else
                         $emp_title=" ";
                   }else{
                       $emp_title=" ";
                   }
                   
                    if(!empty($user['custtitle_id'])){
                     $custtitle = \App\Models\MlstTitle::select('title')->where('id', '=', $user['custtitle_id'])->first();  
                     if(!empty($custtitle->title))
                      $cust_title= $custtitle->title; 
                     else
                         $cust_title=" ";
                   }else{
                       $cust_title=" ";
                   }
                                                        
                    if(Auth::guard('admin')->user()->customer_contact_numbers == 0){
                        $mobileno="91-xxxxxx".substr($user["customer_number"],strlen($user["customer_number"])-4);
                    }else{
                       $mobileno= $user["customer_number"];
                    }
                                                        
                    $getFilterData = [
                    $user["call_date"]." ".$user["call_time"],
                    $virtual_number,
                    $mobileno,
                    $cust_title,    
                    $customer_name,
                    $customer_call_status,
                    $emp_title,    
                    $employee_name,
                    $user['customer_call_duration'],
                    $user['sales_source_name'],
                    $subsource,   
                        
                   ];
                    
                    $user = array_merge($srno,$getFilterData);
                    
                    
                    $sheet->appendRow($user);
                }
            });
        })->save('XLS', "downloads/");
       
        /*save file in aws */
         $folderName="/sales/calllogexportReport/";
         
         $basepath = base_path()."/public/downloads/".$fileName.".xls"; 
                
         $fileName=$fileName.".xls";  
         
        $awsFile = S3::s3FileUpload($basepath, $fileName, $folderName);
        
         \File::delete($basepath);
        /*end aws file*/
           
            $file_url = config('global.s3Path').$folderName.$fileName;
            if(!empty($request['loggedInUserId']))
                $loggedInUserId = $request['loggedInUserId'];
            else
                $loggedInUserId = Auth::guard('admin')->user()->id;
         
           
            $exportdate=date('d-m-Y');
            $exporttime=date('H:i:s');
            $ReportName =str_replace('_', ' ', $reportName);
                        
            $templatedata['employee_id'] = $loggedInUserId;
            $templatedata['client_id'] = config('global.client_id');
            $templatedata['template_setting_customer'] = 0;
            $templatedata['template_setting_employee'] = 30;
            $templatedata['customer_id'] = 0;
            $templatedata['model_id'] = 0;
            $templatedata['emp_attached_file']=$file_url;
            $templatedata['arrExtra'][0] = array(
                '[#exportFromSection#]',
                '[#exportDate#]',
                '[#exportTime#]',
               
            );
            $templatedata['arrExtra'][1] = array(
              $ReportName,
              $exportdate,
              $exporttime,
            );
           
           $Templateresult = CommonFunctions::templateData($templatedata);
           $result = ['success' => true, 'sheetName' => $fileName, "fileUrl" => $file_url,'message' => "Data exported successfully.."];
        
        return response()->json($result);
      
        
    }
    
    
    public function filteredData() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $this->allusers = array();
        $filterData = $request['filterData'];
        
        

        if (empty($request['employee_id'])) { // For Web
            $loggedInUserId = Auth::guard('admin')->user()->id;
            if ($request['isTeamType'] == 1) {
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;
            }
            if (!empty($filterData["virtual_no"])) {
                $virtualNumber = explode("_", $filterData["virtual_no"]);
            }
            if (!empty($filterData["callstatus"])) {
                $callstatus = explode("_", $filterData["callstatus"]);
            }
            
           
            $filterData["virtual_no"] = !empty($filterData["virtual_no"]) ? $virtualNumber[0] : "";
            $filterData["callstatus"] = !empty($filterData['callstatus']) ? $callstatus[0] : "";
           
        } else { // For App
            $request["getProcName"] = CloudCallingLogsController::$procname;
            $loggedInUserId = $request['employee_id'];
            if (!empty($request['isTeamType']) && $request['isTeamType'] == 1) {
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;
            }
            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
                $loggedInUserId = implode(',', array_map(function($el) {
                            return $el['id'];
                        }, $filterData['empId']));
            }
            $filterData["virtual_no"] = !empty($filterData["virtual_no"]) ? $filterData["virtual_no"] : "";
            $filterData["callstatus"] = !empty($filterData['callstatus']) ? $filterData["callstatus"] : "";
            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        }
        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
            $loggedInUserId = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $filterData['empId']));
        }

        $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
        $filterData["toDate"] = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
       
        
        
        $getInboundLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","'  . $filterData["fromDate"] . '","' .
                $filterData["toDate"] . '","' . $filterData["callstatus"] . '","' .$filterData["virtual_no"] . '","' . $request['pageNumber'] . '","'.$request['itemPerPage'] . '")');
       
        $enqCnt= DB::select("select FOUND_ROWS() totalCount");
        $enqCnt = $enqCnt[0]->totalCount;
        
        $i = 0;
        if (!empty($getInboundLogs)) {
            foreach ($getInboundLogs as $getInboundLog) {
                $url = '';
                    $arrs = explode('&', $getInboundLog->call_log_push_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                $getInboundLogs[$i]->call_recording_url = $url;//config('global.s3Path') . '/recorded_file/' . $getInboundLog->call_recording_url;
                $getInboundLogs[$i]->employee_name = $getInboundLog->first_name . ' ' . $getInboundLog->last_name;
                $getInboundLogs[$i]->customer_name = $getInboundLog->cfirst_name . ' ' . $getInboundLog->clast_name;
                $getInboundLogs[$i]->emptitle_id = $getInboundLog->emp_title_id;
                $getInboundLogs[$i]->custtitle_id = $getInboundLog->cust_title_id;
                unset($getInboundLogs[$i]->first_name);
                unset($getInboundLogs[$i]->last_name);
                unset($getInboundLogs[$i]->cfirst_name);
                unset($getInboundLogs[$i]->clast_name);
                unset($getInboundLogs[$i]->emp_title_id);
                unset($getInboundLogs[$i]->cust_title_id);
                $i++;
            }
        }
        
        
        if(!empty($getInboundLogs[0])){
            $result = ['success' => true, 'records' => $getInboundLogs, 'totalCount' => $enqCnt];
        }else{
            $result = ['success' => false, 'records' => $getInboundLogs, 'totalCount' => $enqCnt];
        }
        return json_encode($result);
    }
    
    public function filteredoutboundData() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $this->allusers = array();
        $filterData = $request['filterData'];
        if (empty($request['employee_id'])) { // For Web
            $loggedInUserId = Auth::guard('admin')->user()->id;
            if ($request['isTeamType'] == 1) {
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;
            }
          
            $filterData["customer_number"] = !empty($filterData["customer_number"]) ? $filterData["customer_number"] : "";
            $filterData["callstatus"] = !empty($filterData['callstatus']) ? $filterData["callstatus"] : "";
           
        } else { // For App
            $request["getProcName"] = CloudCallingLogsController::$procname;
            $loggedInUserId = $request['employee_id'];
            if (!empty($request['isTeamType']) && $request['isTeamType'] == 1) {
                $this->tuserid($loggedInUserId);
                $alluser = $this->allusers;
                $loggedInUserId = !empty($alluser) ? implode(',', $alluser) : $loggedInUserId;
            }
            if (isset($filterData['empId']) && !empty($filterData['empId'])) {
                $loggedInUserId = implode(',', array_map(function($el) {
                            return $el['id'];
                        }, $filterData['empId']));
            }
           
            $filterData["customer_number"] = !empty($filterData["customer_number"]) ? $filterData["customer_number"] : "";
            $filterData["callstatus"] = !empty($filterData['callstatus']) ? $filterData["callstatus"] : "";
            $request['pageNumber'] = ($request['pageNumber'] - 1) * $request['itemPerPage'];
        }
        if (isset($filterData['empId']) && !empty($filterData['empId'])) {
            $loggedInUserId = implode(',', array_map(function($el) {
                        return $el['id'];
                    }, $filterData['empId']));
        }

        $filterData["fromDate"] = !empty($filterData['fromDate']) ? date('Y-m-d', strtotime($filterData['fromDate'])) : "";
        $filterData["toDate"] = !empty($filterData['toDate']) ? date('Y-m-d', strtotime($filterData['toDate'])) : "";
       
        
        
        $getOutboundLogs = DB::select('CALL ' . $request["getProcName"] . '("' . $loggedInUserId . '","'  . $filterData["fromDate"] . '","' .
                $filterData["toDate"] . '","' . $filterData["callstatus"] . '","' . $request['pageNumber'] . '","'.$request['itemPerPage'].'","'.$filterData["customer_number"] . '")');
       
        $Cnt= DB::select("select FOUND_ROWS() totalCount");
        $logCnt = $Cnt[0]->totalCount;
        
        $i = 0;
        if (!empty($getOutboundLogs)) {
            foreach ($getOutboundLogs as $getOutboundLog) {
                $url = '';
                    $arrs = explode('&', $getOutboundLog->call_log_push_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                $getOutboundLogs[$i]->call_recording_url = $url;//config('global.s3Path') . '/recorded_file/' . $getOutboundLog->call_recording_url;
                $getOutboundLogs[$i]->employee_name = $getOutboundLog->first_name . ' ' . $getOutboundLog->last_name;
                $getOutboundLogs[$i]->customer_name = $getOutboundLog->cfirst_name . ' ' . $getOutboundLog->clast_name;
                $getOutboundLogs[$i]->emptitle_id = $getOutboundLog->emp_title_id;
                $getOutboundLogs[$i]->custtitle_id = $getOutboundLog->cust_title_id;
                unset($getOutboundLogs[$i]->first_name);
                unset($getOutboundLogs[$i]->last_name);
                unset($getOutboundLogs[$i]->cfirst_name);
                unset($getOutboundLogs[$i]->clast_name);
                unset($getOutboundLogs[$i]->emp_title_id);
                unset($getOutboundLogs[$i]->cust_title_id);
                $i++;
            }
        }
        if(!empty($getOutboundLogs[0])){
            $result = ['success' => true, 'records' => $getOutboundLogs, 'totalCount' => $logCnt];
        }else{
            $result = ['success' => false, 'records' => $getOutboundLogs, 'totalCount' => $logCnt];
        }
        return json_encode($result);
        
    }
    
        
        
     public function getTeamEmployees() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $this->allusers = array();
        if (empty($request['empId'])) {
            $loggedInUserId = Auth::guard('admin')->user()->id;
        } else {
            $loggedInUserId = $request['empId'];
        }
        
        $this->tuserid($loggedInUserId);
        $alluser = $this->allusers;
      
        if (!empty($alluser)) {
            $client_id = config('global.client_id');
            $getEmployees = Employee::whereIn('id', $alluser)
                    ->where([["client_id", "=", $client_id], ["employee_status", "=", 1]])
                    ->select('id', 'first_name', 'last_name', 'designation_id', 'team_lead_id')
                    ->get();
           
            if (!empty($getEmployees)) {
                $result = ['success' => true, 'records' => $getEmployees];
            } else {
                $result = ['success' => false, 'message' => 'Something went wrong'];
            }
             return json_encode($result);
        }
    }
    
    public function outLogexportToExcel(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata, true);
        $data = $request['result']; 
       // echo '<pre>';print_r($data); exit;
        $reportName = $request['reportName'];
        $currentDate = date('_d_m_Y_h_i_s_A');
      
         if(!empty($request['first_name']))
           $first_name = $request['first_name'];
       else
           $first_name = Auth::guard('admin')->user()->first_name;
       
       if(!empty($request['last_name']))
           $last_name = $request['last_name'];
       else
        $last_name = Auth::guard('admin')->user()->last_name;
             
       $fileName = $reportName . $currentDate . "_by_" .  $first_name. "_" . $last_name;
                 
        ob_end_clean();        
        Excel::create($fileName, function($excel) use ($data,$reportName) {
            $excel->sheet($reportName, function($sheet) use ($data, $reportName) {
                $sheet->mergeCells('A1:I1');
                $sheet->setHeight("1", 45);
                $sheet->cells('A1:I1', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontColor('#161515'); 
                    $cells->setBackground('#50a7ff');
                    $cells->setBorder('thick', 'thick', 'thick', 'thick');// Set all borders (top, right, bottom, left)
                    $cells->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '22',
                    ));
                });
               
                $sheet->mergeCells('A2:I2');
                
                $title = str_replace('_', ' ', $reportName);
                $sheet->row(1, array('LMS Auto - '.$title));
               
                $sheet->appendRow(["Sr.No","Call Date & Time","Customer Number","Title","Customer Name","Call Status","Title","Call By",
                    "Call Duration"]);
                
           
                $sheet->row(3, function ($row) {
                    $row->setAlignment('center');
                    $row->setBackground('#77b9fb');
                    $row->setFont(array(
                        'family'     => 'Calibri',
                        'size'       => '10',
                    ));
                });
                
                $i = 1;
                // putting users data as next rows
                foreach ($data as $user) {
                    $srno = ["srno" => $i++];
                  
                    if(!empty($user['customer_name'])){
                        $customer_name=$user['customer_name'];
                    }else{
                        $customer_name="--";
                    }
                    
                    if(!empty($user['employee_name'])){
                       $employee_name=$user['employee_name'];   
                   }else{
                       $employee_name="--";
                   }
                  
                   
                   if(!empty($user['customer_call_status'])){
                       $customer_call_status=$user['customer_call_status'];
                   }else{
                       $customer_call_status="--";
                   }
                   
                     if(!empty($user['emptitle_id'])){
                     $emptitle = \App\Models\MlstTitle::select('title')->where('id', '=', $user['emptitle_id'])->first();  
                     if(!empty($emptitle->title))
                      $emp_title= $emptitle->title; 
                     else
                         $emp_title=" ";
                   }else{
                       $emp_title=" ";
                   }
                   
                    if(!empty($user['custtitle_id'])){
                     $custtitle = \App\Models\MlstTitle::select('title')->where('id', '=', $user['custtitle_id'])->first();  
                     if(!empty($custtitle->title))
                      $cust_title= $custtitle->title; 
                     else
                         $cust_title=" ";
                   }else{
                       $cust_title=" ";
                   }
                   
                    if(Auth::guard('admin')->user()->customer_contact_numbers == 0){
                        $mobileno="91-xxxxxx".substr($user["customer_number"],strlen($user["customer_number"])-4);
                    }else{
                       $mobileno= $user["customer_number"];
                    }
                                                        
                                                        
                    $getFilterData = [
                    $user["call_date"]." ".$user["call_time"],
                    $mobileno,
                    $cust_title,    
                    $customer_name,
                    $customer_call_status,
                    $emp_title,    
                    $employee_name,
                    $user['customer_call_duration'],
                                           
                   ];
                    
                    $user = array_merge($srno,$getFilterData);
                    
                    
                    $sheet->appendRow($user);
                }
            });
        })->save('XLS', "downloads/");
       
        /*save file in aws */
         $folderName="/sales/calllogexportReport/";
         
         $basepath = base_path()."/public/downloads/".$fileName.".xls"; 
                
         $fileName=$fileName.".xls";  
         
        $awsFile = S3::s3FileUpload($basepath, $fileName, $folderName);
        
         \File::delete($basepath);
        /*end aws file*/
           
            $file_url = config('global.s3Path').$folderName.$fileName;
            if(!empty($request['loggedInUserId']))
                $loggedInUserId = $request['loggedInUserId'];
            else
                $loggedInUserId = Auth::guard('admin')->user()->id;
         
           
            $exportdate=date('d-m-Y');
            $exporttime=date('H:i:s');
            $ReportName =str_replace('_', ' ', $reportName);
                        
            $templatedata['employee_id'] = $loggedInUserId;
            $templatedata['client_id'] = config('global.client_id');
            $templatedata['template_setting_customer'] = 0;
            $templatedata['template_setting_employee'] = 30;
            $templatedata['customer_id'] = 0;
            $templatedata['model_id'] = 0;
            $templatedata['emp_attached_file']=$file_url;
            $templatedata['arrExtra'][0] = array(
                '[#exportFromSection#]',
                '[#exportDate#]',
                '[#exportTime#]',
               
            );
           $templatedata['arrExtra'][1] = array(
              $ReportName,
              $exportdate,
              $exporttime,
            );
           
           $Templateresult = CommonFunctions::templateData($templatedata);
        
            $result = ['success' => true, 'sheetName' => $fileName, "fileUrl" => $file_url,'message' => "Data exported successfully.."];
        
        return response()->json($result);
      
        
    }
    
    public function getVirtualnumbers(){
        $virtualNumbers = CtSetting::select('id','virtual_display_number','forwarding_number_knowlarity')->get();
        $callStatus = array('Connected'=>'Connected','Missed'=>'Missed','Non Working Hours Call'=>'Non Working Hours Call','NotConnected'=>'NotConnected');
        if(!empty($virtualNumbers)){
             $result = ['success' => true, 'records' => $virtualNumbers,'callstatus'=>$callStatus];
        }else
        {
            $result = ['success' => true, 'message' => "Something Went Wrong !!"];
        }
    
        return json_encode($result);
    }

    

}

