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

class CloudCallingLogsController extends Controller {

    public function __construct() {
        $this->middleware('web');
    }

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

        if (!empty($last_connected_row))
            $last_connected_no = $last_connected_row[0]['employee_id'];
        else
            $last_connected_no = 0;

        $menu_admin_arr = @explode(',', $missedcall_agent);
        foreach ($menu_admin_arr as $admin_id) {
            $admin_mobile_model = Employee::where("id", $admin_id)->first();
            $menu_all_mobile[] = $admin_mobile_model->username;
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
        date_default_timezone_set('Asia/Kolkata');
            $h = date('h');
            $a = date('A');
            if ($h >= 05 and $h < 12 and $a == 'AM')
                $greeting_msg = "Good Morning";
            else if (( $h == 12 || $h < 04 ) and $a == 'PM')
                $greeting_msg = "Good Afternoon";
            else if ($h >= 04 and $h < 10 and $a == 'PM')
                $greeting_msg = "Good Evening";
            else
                $greeting_msg = '';
        
        $alertdata['customer_id'] = 1;
        $alertdata['employee_id'] = 1;
        $alertdata['client_id'] = 1;
        $alertdata['email_body'] = "test";
        $alertdata['sms_body'] = "test";
        $alertdata['arrExtra'][0] = array(
            '[#greeting#]',
        );
        $alertdata['arrExtra'][1] = array(
            $greeting_msg,
        );

        $alertsdata = CommonFunctions::templateData($alertdata); //Yii::$app->LMS->Template($alertdata);
        exit;
    if(!empty($_GET)){
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
        
        if(!empty($_GET['ivr_type']))
            $ivr_type = $_GET['ivr_type'];
        else
            $ivr_type = 1;
        
        $extension = $_GET['extension_no'];
        $sub_extension = $_GET['sub_extension_no'];
        
        if(!empty($_GET['bridged_number']))
            $bridged_number = $_GET['bridged_number'];
        else
            $bridged_number = "";
        
        
        if(!empty($_GET['bridge_join_time']) && !empty($_GET['bridge_hangup_time'])){
            $bridge_join_time = strtotime($_GET['bridge_join_time']);
            $bridge_hangup_time = strtotime($_GET['bridge_hangup_time']);
            $duration = $bridge_hangup_time - $bridge_join_time;
            $bridging_duration = gmdate("H:i:s", $duration);
            
        }else{
            $bridging_duration = "";
        }
        if(!empty($_GET['caller_operator']))
            $caller_operator = $_GET['caller_operator'];
        else
            $caller_operator ="";
            
        if (is_numeric($bridged_number)) {
            $bridged_number = substr($bridged_number, -10);
        } else {
            $bridged_number = 'NA';
        }

        
        

        $virtual_number = substr($virtual_number, -12);
        $caller_number = substr($caller_number, -10);
        $call_connected_to = substr($call_connected_to, -10);

        $model_id = 0;

        $source_id = 0;
        $source_description = '';
        $basepath = base_path()."/common/tunes/";
        
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
        $model->save();

       
        //$svirtual_model = CloudVirtualNumberModel::find()->where(['virtual_number' => $virtual_number])->one();

        /*    if (!empty($extension)) {
          if ($call_status == 'NotConnected' && $ivr_type == 4 && $svirtual_model->missedcall_setting != 1) {

          $virtual_menu_model = CloudCallingMenuModel::find()->where(['cvn_id' => $svirtual_model->cvn_id])
          ->where(['extension_no' => $extension])->one();

          $model->client_id = $svirtual_model->client_id;

          $model->save(false);

          $mobile_number = $this->getMissedcall_agent($svirtual_model->missed_call_alert_user,$model->virtual_number,$ext=$extension);
          $agent = @explode(',',$mobile_number);
          $model->call_connected_to =$agent[0];//[0];// $obj_employee_missed->mobile_no;
          $model->save(false);
          $service_emp = EmployeeModel::find()->where(['username' => $model->call_connected_to,'client_id' => $svirtual_model->client_id])->one();
          if (!empty($caller_number)) {
          $service_cust_no = substr($caller_number, -10);
          $service_customer_model = ServiceCustomerModel::find()->where(['mobile_1' => $service_cust_no])->one();
          //$service_emp_no = substr($call_connected_to, -10);

          $service_client_id = $service_emp->client_id;
          $appointment_status = ServiceApptStatusModel::find()->where([ 'status' => 'Upcoming'])->one();

          $service_client = ClientsModel::find()->where(['id' => $service_client_id])->one();
          $i = 1;

          while ($i < 10) {
          $appointment_setting_model = ServiceAppointmentSettingModel::find()->where(['client_id' => $service_client_id])->one();
          date_default_timezone_set('Asia/Kolkata');

          $interval = $appointment_setting_model->interval; //in min
          $start_time = $appointment_setting_model->start_time;
          $start_time = date('H:i:s', strtotime($start_time));
          $end_time = $appointment_setting_model->end_time;
          $end_time = date('H:i:s', strtotime($end_time));
          $off_day = $appointment_setting_model->weekly_off_day;
          $next_date = date("Y-m-d", strtotime("+$i day"));

          $day = date("l", strtotime($next_date));

          if ($off_day == $day) {
          $i++;
          $next_date = date("Y-m-d", strtotime("+$i day"));
          }

          $booked_slot = "SELECT sa.appointment_time,count(sa.appointment_time) as appcount FROM service_appointment sa JOIN service_client_customer scc ON sa.service_customer_id = scc.service_customer_id where sa.appointment_date = '$next_date' AND scc.client_id ='$service_client_id' GROUP BY sa.appointment_time ORDER BY sa.appointment_time ASC";
          $booked_slot = ServiceAppointmentModel::getDb()->createCommand($booked_slot)->queryAll();

          $time_slot = array();

          while ($start_time <= $end_time) {

          $current_date = date('Y-m-d');
          $current_time = date('H:i');


          if ($appdate == $current_date) {
          $start_h = date('H:i', strtotime($start_time));
          if ($start_h >= $current_time) {
          $time_slot[] = $start_time;
          }
          $start_time = date("H:i:s", strtotime("+$interval minutes", strtotime($start_time)));
          } else {
          $time_slot[] = $start_time;
          $start_time = date("H:i:s", strtotime("+$interval minutes", strtotime($start_time)));
          }
          }
          $booked_time = array();
          foreach ($booked_slot as $booked) {
          if (($booked['appcount'] == $appointment_setting_model->vehicle_per_interval)) {
          $booked_time[] = $booked['appointment_time'];
          }
          }

          $final_time_slot_diff = array_diff($time_slot, $booked_time);
          $final_time_slot = array();

          foreach ($final_time_slot_diff as $final_time_slot_row) {
          $final_time_slot[] = date('h:i A', strtotime($final_time_slot_row));
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
          $service_customer_model = new ServiceCustomerModel;
          $service_customer_model->mobile_1 = $service_cust_no;
          $service_customer_model->title_id = 1;
          $service_customer_model->date_added = date('Y-m-d H:i:s');
          $service_customer_model->addedby_employee_id = $service_emp->id; //default employee
          $service_customer_model->save(false);

          //client's customer insertion
          $client_cus_model = new ServiceClientCustomerModel;
          $client_cus_model->client_id = $service_client_id;
          $client_cus_model->service_customer_id = $service_customer_model->id;
          $client_cus_model->save(false);

          $service_appointment_model = new ServiceAppointmentModel;
          $service_appointment_model->service_customer_id = $service_customer_model->id;
          $service_appointment_model->service_vehicles_id = 0;
          $service_appointment_model->appointment_date = $appointment_date;
          $service_appointment_model->appointment_time = $appointment_time;
          $service_appointment_model->appointment_through = "cloud _telephony";
          $service_appointment_model->pickup_drop_required = "no";

          $service_appointment_model->pickup_address_id = 0;

          $service_appointment_model->appointment_status = $appointment_status->id;

          $service_appointment_model->save(false);
          } else {

          $service_vehicle = \common\models\ServiceVehiclesModel::find()->where(['service_customer_id' => $service_customer_model->id])->all();
          //print_r($service_vehicle);
          $cnt = count($service_vehicle);
          //echo $service_vehicle[0]['id'];exit;
          if ($cnt == 1) {
          $vehicle_id = $service_vehicle[0]['id'];
          //echo $vehicle_id;exit;
          } else {
          $vehicle_id = 0;
          //echo $vehicle_id;exit;
          }
          $stoday = date('Y-m-d');
          $service_appointment_model = ServiceAppointmentModel::find()->where(['service_customer_id' => $service_customer_model])
          ->andWhere(['>=', 'appointment_date', $stoday])->one();

          if (empty($service_appointment_model)) {
          $sflag = 0;
          $service_appointment_model = new ServiceAppointmentModel;
          $service_appointment_model->service_customer_id = $service_customer_model->id;
          $service_appointment_model->service_vehicles_id = $vehicle_id;
          $service_appointment_model->appointment_date = $appointment_date;
          $service_appointment_model->appointment_time = $appointment_time;
          $service_appointment_model->appointment_through = "cloud _telephony";
          $service_appointment_model->pickup_drop_required = "no";

          $service_appointment_model->pickup_address_id = 0;

          $service_appointment_model->appointment_status = $appointment_status->id;

          $service_appointment_model->save(false);
          } else {
          $sflag = 1;
          }
          }

          $access_key = $service_client->access_key;
          //$email_id = "";
          $shorturl = $_SERVER['HTTP_HOST'] . '/office.php/site/updateappointment?mobile_no=' . $service_cust_no . '&email_id=' . $service_customer_model->email_1 . '&access_key=' . $access_key;

          $longUrl = $shorturl;
          $return_val = $this->shortenUrl($longUrl);
          $shorturl = $return_val['id'];
          date_default_timezone_set('Asia/Kolkata');
          $h = date('h');
          $a = date('A');
          if ($h >= 05 and $h < 12 and $a == 'AM')
          $greeting_msg = "Good Morning";
          else if (( $h == 12 || $h < 04 ) and $a == 'PM')
          $greeting_msg = "Good Afternoon";
          else if ($h >= 04 and $h < 10 and $a == 'PM')
          $greeting_msg = "Good Evening";
          else
          $greeting_msg = '';
          if ($sflag == 0) {
          $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $service_client_id,'event_id' => 27])->one();
          if($alert_settings_customer->alert_type == 0){
          $sms_template_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
          }else{
          $sms_template_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
          }

          $alert_settings_employee = \common\models\AlertsSettingsModel::find()->where(['client_id' => $service_client_id,'event_id' => 28])->one();
          if($alert_settings_employee->alert_type == 0){
          $sms_template_employee = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_employee->event_id])->one();
          };

          $template_emp = $sms_template_employee->sms_body;
          $arr_static_tags_search_emp = array(
          '[#greeting#]',
          '[#employeeName#]',
          '[#custName#]',
          '[#custMobile#]',
          '[#companyMktName#]',
          '[#appointmentDate#]',
          '[#appointmentTime#]',
          '[#custFormLink#]'
          );

          $arr_static_tags_replace_emp = array(
          $greeting_msg,
          $service_emp->fullname,
          $service_customer_model->first_name . ' ' . $service_customer_model->last_name,
          $service_customer_model->mobile_1,
          $service_client->marketing_name,
          date('Y-m-d', strtotime($service_appointment_model->appointment_date)),
          date('h:i A', strtotime($service_appointment_model->appointment_time)),
          $shorturl
          );
          $template_emp = str_replace($arr_static_tags_search_emp, $arr_static_tags_replace_emp, $template_emp);

          Yii::$app->LMS->sendSMST($smsbody = $template_emp, $mobile_no = $service_emp->username, $user_id = $service_emp->id, $customer = 'No', $customer_id = 0);

          $template_cust = $sms_template_customer->sms_body;
          $sms_template_cust = str_replace($arr_static_tags_search_emp, $arr_static_tags_replace_emp, $template_cust);
          Yii::$app->LMS->sendSMST($smsbody = $sms_template_cust, $mobile_no = $service_customer_model->mobile_1, $user_id = $service_emp->id, $customer = 'Yes', $customer_id = $service_customer_model->id);
          } elseif ($sflag == 1) {
          $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $service_client_id,'event_id' => 29])->one();
          if($alert_settings_customer->alert_type == 0){
          $sms_template_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
          }else{
          $sms_template_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
          }

          $arr_static_tags_search_emp = array(
          '[#greeting#]',
          '[#employeeName#]',
          '[#custName#]',
          '[#custMobile#]',
          '[#companyMktName#]',
          '[#appointmentDate#]',
          '[#appointmentTime#]',
          '[#custFormLink#]'
          );

          $arr_static_tags_replace_emp = array(
          $greeting_msg,
          $service_emp->fullname,
          $service_customer_model->first_name . ' ' . $service_customer_model->last_name,
          $service_customer_model->mobile_1,
          $service_client->marketing_name,
          date('Y-m-d', strtotime($service_appointment_model->appointment_date)),
          date('h:i A', strtotime($service_appointment_model->appointment_time)),
          $shorturl
          );
          $template_cust = $sms_template_customer->sms_body;
          $sms_template_cust = str_replace($arr_static_tags_search_emp, $arr_static_tags_replace_emp, $template_cust);
          Yii::$app->LMS->sendSMST($smsbody = $sms_template_cust, $mobile_no = $service_customer_model->mobile_1, $user_id = $service_emp->id, $customer = 'Yes', $customer_id = $service_customer_model->id);
          }
          header("Content-type: text/xml; charset=utf-8");
          echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
          exit;
          }
          }
          } */


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
               // $s3FolderName ='recorded_file';  
               // $name = S3::s3FileUpload($org_file_path, $live_file,$s3FolderName);
               
            } catch (Exception $e) {
                //  echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
        // end recording move code

        if ($model->virtual_number != '') {
            $obj_virtual_number = CtSetting::where("virtual_number", $model->virtual_number)->first();
            $source_id = $obj_virtual_number->source_id;
            $source_description = $obj_virtual_number->source_disc;
            $model->source_id = $source_id;
            $model->client_id = $obj_virtual_number->client_id;
            $client_id = $model->client_id;
            $model->save();

            if ($call_status == 'Missed' and $model->extension_number == 'None') {
                $mobile_number = $this->getMissedcall_agent($obj_virtual_number->msc_default_employee_id, $model->virtual_number, $ext = 0);
                $agent = @explode(',', $mobile_number);
                $model->employee_number = $agent[0]; //[0];// $obj_employee_missed->mobile_no;
                $model->save();
            } else if ($model->extension_number != 'None' && $ivr_type != 4) {
                $obj_extension = CtMenuSetting::find()->Where(array('ct_settings_id' => $obj_virtual_number->id, 'ext_number' => $model->extension_number))->first();
                if (($call_status == 'Missed' || $call_status == 'NotConnected') and $model->extension_number != 'None') {
                    $mobile_number = $this->getMissedcall_agent($obj_extension->employees, $model->virtual_number, $ext = $model->extension_number);
                    $agent = @explode(',', $mobile_number);
                    $model->employee_number = $agent[0]; //[0];// $obj_employee_missed->mobile_no;
                    $model->save();
                }
            } else if ($call_status == 'NotConnected' and $obj_virtual_number->msc_facility_status == 1) {
                $mobile_number = $this->getMissedcall_agent($obj_virtual_number->msc_default_employee_id, $model->virtual_number, $ext = 0);
                $agent = @explode(',', $mobile_number);
                $model->employee_number = $agent[0]; //[0];// $obj_employee_missed->mobile_no;
                $model->save();
            }
        }
        
        // start enquiry inserting code

        if ($call_status == 'Connected' || $call_status == 'Missed' || $call_status == 'NotConnected') {

            $obj_employee = Employee::where(array('username' => $model->bridge_employee_number, 'client_id' => $obj_virtual_number->client_id, 'employee_status' => 1))->first();
            
            if (empty($obj_employee)) {
                $obj_employee = Employee::where(array('username' => $model->employee_number, 'client_id' => $obj_virtual_number->client_id, 'employee_status' => 1))->first();
                
            } else if (empty($obj_employee)) {

                $mobile_number = $this->getMissedcall_agent($obj_virtual_number->msc_default_employee_id, $model->virtual_number, $ext = 0);
                $agent = @explode(',', $mobile_number);
                $model->employee_number = $agent[0]; //[0];// $obj_employee_missed->mobile_no;
                $model->save();

                $obj_employee = Employee::where(array('username' => $model->employee_number, 'client_id' => $obj_virtual_number->client_id, 'employee_status' => 1))->first();
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
                    $obj_enquiry = Enquiry::where('customer_id', $obj_customer->customer_id)->orderBy('id','SORT_DESC')->first();  //Open
                    if (!empty($obj_enquiry) and $obj_virtual_number->alert_to_enq_owner == 0 and $call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Invalid agent list') {
                        $obj_employee = Employee::where(array('username' => $model->employee_number, 'client_id' => $obj_virtual_number->client_id, 'employee_status' => 1))->first();
                        //print_r($obj_employee);exit;
                    } else if (!empty($obj_enquiry) and $obj_virtual_number->alert_to_enq_owner == 1 and $call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Invalid agent list') {
                        $obj_employee_temp = Employee::where(array('id' => $obj_enquiry->sales_employee_id, 'client_id' => $obj_virtual_number->client_id, 'employee_status' => 1))->first();
                        if (!empty($obj_employee_temp)) {
                            $obj_employee = Employee::where(array('id' => $obj_enquiry->sales_employee_id, 'client_id' => $obj_virtual_number->client_id, 'employee_status' => 1))->first();
                            $model->employee_number = $obj_employee->username; //[0];// $obj_employee_missed->mobile_no;
                            $model->save();
                        }
                    }
                    
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
                                //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                // start new Folloups

                                $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                            } else {
                                
                                $exist = 1;
                                //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                            }
                        } else {
                           
                            if ($obj_virtual_number->open_enquiry_other_emp_action == 1) {
                               
                                $obj_enquiry->sales_employee_id = $model->employee_id;
                                $obj_enquiry->save();
                                $exist = 1;
                                
                                //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
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
                                //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                // start new Folloups

                                $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                            } else {

                                $exist = 1;
                                //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                            }
                        }
                    } else if (!empty($obj_enquiry)) {
                        $exist = 1;
                        //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                    } else {
                        $obj_enquiry = Enquiry::where('customer_id', $obj_customer->customer_id)->orderBy('id','SORT_DESC')->first(); //Lost

                        if (!empty($obj_enquiry)) {

                            if ($obj_enquiry->sales_employee_id == $model->employee_id) {
                                if ($obj_virtual_number->lost_enquiry_owner_emp_action == 1) {
                                    // new enquiry	
                                    $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                                    $exist = 1;
                                    //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);


                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                } else {

                                    $exist = 1;
                                    //$obj_enquiry->enq_status = 'Open';
                                    //$obj_enquiry->save(false);
                                    //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                }
                            } else {
                                if ($obj_virtual_number->lost_enquiry_other_emp_action == 1) {

                                    //$obj_enquiry->enq_status = 'Open';
                                    //$obj_enquiry->save(false);
                                    $exist = 1;
                                    //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    // start new Folloups													   
                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                } else if ($obj_virtual_number->lost_enquiry_other_emp_action == 2) {
                                    $obj_enquiry->sales_employee_id = $model->employee_id;
                                    //$obj_enquiry->enq_status = 'Open';
                                    $obj_enquiry->save(false);
                                    $exist = 1;
                                    //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    // start new Folloups

                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                } else {

                                    // new enquiry	
                                    $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                                    $exist = 1;
                                    //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                                    // start new Folloups

                                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                                }
                            }
                        } else {
                            // start new enquiry
                            $obj_enquiry = $this->insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description, $obj_virtual_number);

                            $exist = 1;
                            //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);

                            // start new Folloups

                            $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                            // end new Folloups	
                        }
                    }
                } else if ($model->enquiry_flag == 1 and  $call_status == 'Connected') {
                    // start new customer
                        $obj_customer_info = new Customer();
                        $obj_customer_info->source_id = $source_id;
                        $obj_customer_info->subsource_id = $obj_virtual_number->sub_source_id;
                        $obj_customer_info->source_description = $obj_virtual_number->source_disc;
                        $obj_customer_info->client_id = $client_id;
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
                    //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                    // start new Folloups

                    $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                    // end new Folloups	
                } else if ($call_status == 'Missed' || $call_status == 'NotConnected' || $call_status == 'Connected' || $call_status == 'Invalid agent list') {
                    
                    //for ivr type 4
                    if ($call_status == 'NotConnected' and $ivr_type == 4) {
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
                            //$this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $model_id, $exist);
                            
                            // start new Folloups

                            $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                            // end new Folloups
                        } else {
                            $exist = 0;
                            $this->sendMissedSms($model, $obj_employee, $exist);
                        }
                        //end ivr 4
                    }
                    
                    if ($obj_virtual_number->missed_call_insert_enquiry == 1) {
                        // start new customer
                            $obj_customer_info = new Customer();
                            $obj_customer_info->source_id = $source_id;
                            $obj_customer_info->subsource_id = $obj_virtual_number->sub_source_id;
                            $obj_customer_info->source_description = $obj_virtual_number->source_disc;
                            $obj_customer_info->client_id = $client_id;
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
                        $this->sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer,$obj_customer_info, $model_id, $exist);
                        // start new Folloups

                        $this->insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $obj_virtual_number);
                        // end new Folloups
                    } else {
                        // don't insert enquiry
                        //$this->sendMissedSms($model, $obj_employee, 0);
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

    public function actionOutbound() {

        # mail('vivek@edynamics.co.in', 'Out bound call from '.$_SERVER[HTTP_HOST], 'testing Out bound call from '.$_SERVER[HTTP_HOST]);
        # $this->SMST('Out bound call from '.$_SERVER[HTTP_HOST],'78430999988',0,'NO','');
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
        $call_connected_to = substr($call_connected_to, -10);

        if (!empty($caller_id))
            $caller_id = substr($caller_id, -10);
        else
            $caller_id = '';

        $model = CloudCallingC2cLogsModel::find()->where(array('module_id' => $module_id, 'enquiry_id' => $enquiry_id))->orderBy(['id' => SORT_DESC])->limit(1)->offset(0)->one();


        if (empty($model)) {
            $model = new CloudCallingC2cLogsModel();
            $model->enquiry_id = $enquiry_id;
        }


        $model->call_date = $call_date;
        $model->call_time = $call_time;
        $model->caller_number = $caller_number;
        $model->caller_duration = $caller_duration;
        $model->call_connected_to = $call_connected_to;
        $model->call_status = $call_status;
        $model->caller_circle = $caller_circle;
        //$model->enquiry_id			= $enquiry_id;		
        $model->sip = 0;
        $model->caller_id = $caller_id;
        $model->ongoingcall_status = 1;
        $model->module_id = $module_id;

        $model->operator = $operator;
        $model->customer_call_duration = $customer_call_duration;
        $model->employee_call_duration = $agent_call_duration;
        $model->call_uuid = $call_uuid;
        $model->hangup_cause_leg_a = $hangup_cause_leg_a;
        $model->hangup_cause_leg_b = $hangup_cause_leg_b;


        // start recording move code		
        $file_path = $call_recording_url;
        $file_name = basename($file_path) . '.mp3';
        $folder = 'cloud_calling_logs';

        $model->call_recording_url = $file_name;

        $model->request_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


        $caller_id = '91' . $caller_id;

        $virtual_no_for_client_model = CloudVirtualNumberModel::find()->where(array('virtual_number' => $caller_id))->one();
        $client_id = $virtual_no_for_client_model->client_id;
        $obj_employee = EmployeeModel::find()->where(['client_id' => $client_id, 'username' => $call_connected_to])->one();
        $virtual_no_model = CloudVirtualNumberModel::find()->where(array('is_default' => 1, 'client_id' => $client_id))->one();
        $model->client_id = $client_id;
        $model->admin_user_id = $obj_employee->id;
        $model->save(false);
        $model = CloudCallingC2cLogsModel::find()->where(array('module_id' => $module_id, 'enquiry_id' => $enquiry_id))->orderBy(['id' => SORT_DESC])->limit(1)->offset(0)->one();

        $virtual_no = $virtual_no_model->virtual_number;
        if ($virtual_no == $caller_id) {


            $cloud_virtualno_model = $virtual_no_model;

            $virtual_number = substr($cloud_virtualno_model->virtual_number, -10);

            if ($module_id == '10') {// "10" For enquiry module
                #$enq_model=BuilderEnquiries::model()->findByPk($enquiry_id);
                $enq_model = EnquiryModel::find()->where(array('id' => $enquiry_id))->one();

                if ($model->call_status == 'Connected') {
                    $msg_body = 'Dear ' . $enq_model->customerDetail->fullname . ', ';
                    $msg_body .= 'Your conversation held with ' . $obj_employee->fullname . '(' . $virtual_number . ')';
                    $enquiry_remark = 'Outgoing call done through system remark is awaited by ' . $enq_model->employeeDetail->fullname;
                    //Yii::$app->LMS->sendSMST($smsbody = $msg_body, $mobile_no = $model->caller_number, $user_id = $model->admin_user_id, $customer = 'Yes', $customer_id = $enq_model->customerDetail->id);
                } elseif ($model->call_status == 'Missed') {
                    //$enquiry_remark = 'Out bound call made by '.$enq_model->admin_user_info->fullName.' but '.' customer not picking call OR out of coverage.';
                    $enquiry_remark = 'Outgoing call done through system by ' . $enq_model->employeeDetail->fullname . ' but customer not picked-up or not reachable. Next followup is scheduled after one hour.';
                } elseif ($model->call_status == 'None') {
                    $enquiry_remark = 'Out bound call made by ' . $enq_model->employeeDetail->fullname . ' but ' . ' employee disconnected or not picked the call.';
                    $enquiry_remark = 'Outgoing call done through system but ' . $enq_model->employeeDetail->fullname . ' is not picking up or not reachable. Next followup is scheduled after one hour.';
                }
                $this->insertFollowupsByOutbound($enq_model, $obj_employee, $model->id, $enquiry_remark);
            }
        }
        $this->moveOutboundMP3();
    }

    public function insertEnquiry($obj_customer, $obj_employee, $source_id, $source_description = '', $cloud_virtual_no_model) {
        
        $clientmodel = ClientInfo::where(['id' => $cloud_virtual_no_model->client_id])->first();
        
        $obj_enquiry = new Enquiry();
        $obj_enquiry->client_id =  $obj_employee->client_id;
        $obj_enquiry->created_at = date('Y-m-d H:i:s'); //enquiry created date(in_date in LMS, created)
        $obj_enquiry->created_date = date('Y-m-d');
        $obj_enquiry->updated_date = date("Y-m-d");
        $obj_enquiry->enquiry_date = date('Y-m-d');

        $obj_enquiry->source_id = $source_id;
        $obj_enquiry->subsource_id = $cloud_virtual_no_model->sub_source_id;
        $obj_enquiry->source_description = $source_description;
        // $obj_enquiry->customer_code 					= $obj_customer->customer_id;
        $obj_enquiry->customer_id = $obj_customer->customer_id;
        $obj_enquiry->sales_employee_id = $obj_employee->id;
        $obj_enquiry->enquiry_sales_status_id = 1;

        $obj_enquiry->finance_employee_id = 0;
        $obj_enquiry->exchange_employee_id = 0;
        $obj_enquiry->loan_required = 0;
        $obj_enquiry->source_of_loan = 0;
        $obj_enquiry->exchange_required = 0;
        $obj_enquiry->source_of_exchange = 0;
        $obj_enquiry->enquiry_finance_status_id = 0;
        $obj_enquiry->enquiry_exchange_status_id = 0;
        $obj_enquiry->save();
        
        return $obj_enquiry;
    }

    public function insertFollowups($obj_enquiry, $obj_employee, $obj_customer, $exist, $model, $cloud_virtual_no_model) {
        $customerinfo = Customer::where('id', $obj_customer->customer_id)->first();
        $obj_followups = new EnquiryFollowup();
        $obj_followups->followup_date_time = date("Y-m-d H:i:s");
        $obj_followups->ct_logs_inbounds_id = $model->id;
        $obj_followups->client_id = $obj_employee->client_id;
        $obj_followups->enquiry_id = $obj_enquiry->id;
        $previous_followups = EnquiryFollowup::where('enquiry_id' , $obj_enquiry->id)->orderBy('id', 'DESC')->first();
        if(!empty($previous_followups))
            $obj_followups->enquiry_category_id = $previous_followups->enquiry_category_id;
        else
            $obj_followups->enquiry_category_id = 1;
        
        $obj_followups->followup_by_employee_id = $obj_employee->id;	
        
        if ($model->customer_call_status == 'Missed' || $model->customer_call_status == 'NotConnected') {
            if ($exist == 1) {
                $obj_followups->remarks = 'You have missed a call from ' . ' ' . $customerinfo->first_name . ' ' . $customerinfo->last_name . ' ( ' . $obj_customer->mobile_number . ' ) Please call Back ASAP.';
            } else {
                $obj_followups->remarks = 'New enquiry recieved through missed call by ( ' . $model->customer_number . ' )' . 'Please call Back ASAP & enter remark.';
            }
        } else if ($model->customer_call_status == 'Connected') {
            if ($exist == 1) {
                $obj_followups->remarks = 'Incoming call received from ' . ' ' . $customerinfo->first_name . ' ' . $customerinfo->last_name . ' ( ' . $obj_customer->mobile_number . ' ) Attended By ' . $obj_employee->first_name;
            } else {
                $obj_followups->remarks = 'New enquiry recieved through incoming call by ( ' . $obj_customer->mobile_number . ' )  Attended By ' . $obj_employee->first_name;
            }
        }

        $h = date('h');
        $a = date('A');
        $time = '';
        $date = date('Y-m-d');
        if ($a == 'AM' and $h > 9 and $h < 12) {
            if ($h == 11)
                $time = '12 PM';
            else
                $time = ( $h + 1 ) . ' AM';
        } else if ($a == 'PM' and $h >= 1 and $h < 7) {
            $time = ( $h + 1 ) . ' PM';
        } else if ($a == 'PM' and $h == 12) {
            $time = '1 PM';
        } else if ($a == 'PM' and $h > 6) {
            $time = '10 AM';
            $date = date('Y-m-d', strtotime("+1 day"));
        } else {
            $time = '10 AM';
        }
        $obj_followups->next_followup_date = $date;
        $obj_followups->next_follwoup_time = $time;

        $obj_followups->save();

        header("Content-type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
        exit;
    }

    public function insertFollowupsByOutbound($obj_enquiry, $obj_employee, $cloud_calling_logs_id, $enquiry_remark) {

        //$this->SMST("Out bound call from $_SERVER[HTTP_HOST]",'9970844335',0,'NO','');


        $c2c_log_model = CloudCallingC2cLogsModel::find()->where(array('id' => $cloud_calling_logs_id))->one();

        $attributes['call_recording_url'] = $c2c_log_model->call_recording_url;
        $attributes['followup_date'] = date('Y-m-d H:i:s');
        $attributes['cloud_calling_logs_id'] = $cloud_calling_logs_id;
        $attributes['enquiry_id'] = $obj_enquiry->id;
        $count_followups = count($obj_enquiry->followups) - 1;
        $attributes['enquiry_type'] = $obj_enquiry->followups[$count_followups]->enquiry_type;
        $attributes['enquiry_status'] = $obj_enquiry->enq_status;
        $attributes['remarks'] = $enquiry_remark;

        if (!empty($obj_enquiry->id) && $obj_enquiry->id != 0) {

            $old_followup1 = EnquiryFollowupModel::find()->where(['enquiry_id' => $obj_enquiry->id])->orderBy(['id' => SORT_DESC])->one();
            if (!empty($old_followup1)) {
                //print_r($enquiry_id);exit;
                $old_followup1->actual_followup_date = date('Y-m-d H:i:s');

                $old_followup1->save(false);
            }
        }

        $obj_followups = new EnquiryFollowupModel();

        $h = date('h');
        $a = date('A');
        $time = '';
        $date = date('Y-m-d');
        if ($a == 'AM' and $h > 9 and $h < 12) {

            if ($h == 11)
                $time = '12 PM';
            else
                $time = ( $h + 1 ) . ' AM';
        }else if ($a == 'PM' and $h >= 1 and $h < 7) {

            $time = ( $h + 1 ) . ' PM';
        } else if ($a == 'PM' and $h == 12) {

            $time = '1 PM';
        } else if ($a == 'PM' and $h > 6) {

            $time = '10 AM';
            $date = date('Y-m-d', strtotime("+1 day"));
        } else {

            $time = '10 AM';
            //$date	= date('Y-m-d', strtotime("+1 day"));
        }

        $attributes['next_followup_date'] = $date;
        $attributes['next_follwoup_time'] = $time;
        $obj_followups->attributes = $attributes;
        $obj_followups->source_id = $obj_enquiry->source_id;
        // $obj_followups->followup_by = 7;//used in bms
        $obj_followups->followup_by = $obj_employee->id;
        $obj_followups->enquiry_type = 3;
        $obj_followups->cloud_calling_logs_id = $cloud_calling_logs_id;
        $obj_followups->save(false);

        $obj_enquiry->attributes = $attributes;
        $obj_enquiry->save(false);

        header("Content-type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
    }

    public function sendMissedSms($model, $obj_employee, $exist = 0, $nonworkinghours = 0) {
        /*
         * $exist=0   new 
         * $exist=1   exist customer
         * 
         */

        //send sms to customer
        if ($exist == 0) {

            if ($model->call_status == 'Connected') {
                //customer  
                $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 32])->one();
                if ($alert_settings_customer->alert_type == 0) {
                    $alert_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
                } else {
                    $alert_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
                }

                //employee  
                $alert_settings_employee = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 33])->one();
                $alert_employee = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_employee->event_id])->one();
            } else if ($model->call_status == 'NotConnected' && $nonworkinghours == 1) {
                //customer  
                $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 30])->one();
                if ($alert_settings_customer->alert_type == 0) {
                    $alert_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
                } else {
                    $alert_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
                }

                //employee  
                $alert_settings_employee = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 31])->one();
                $alert_employee = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_employee->event_id])->one();
            } else {
                //customer  
                $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 30])->one();
                if ($alert_settings_customer->alert_type == 0) {
                    $alert_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
                } else {
                    $alert_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
                }

                //employee  
                $alert_settings_employee = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 31])->one();
                $alert_employee = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_employee->event_id])->one();
            }
        }
        //customer
        date_default_timezone_set('Asia/Kolkata');
        $h = date('h');
        $a = date('A');
        if ($h >= 05 and $h < 12 and $a == 'AM')
            $greeting_msg = "Good Morning";
        else if (( $h == 12 || $h < 04 ) and $a == 'PM')
            $greeting_msg = "Good Afternoon";
        else if ($h >= 04 and $h < 10 and $a == 'PM')
            $greeting_msg = "Good Evening";
        else
            $greeting_msg = '';


        $alertdata['employee_id'] = $obj_employee->id;
        $alertdata['client_id'] = $obj_employee->client_id;
        $alertdata['email_body'] = $alert_customer->email_body;
        $alertdata['sms_body'] = $alert_customer->sms_body;

        $alertdata['arrExtra'][0] = array(
            '[#greeting#]',
        );
        $alertdata['arrExtra'][1] = array(
            $greeting_msg,
        );

        $alertsdata = Yii::$app->LMS->Template($alertdata);
        if ($alert_settings_customer->sms_status == 1) {
            Yii::$app->LMS->sendSMST($alertsdata[1], $model->caller_number, $alert_settings_customer, $obj_employee->id, $customer = 'Yes', 0);
        }

        //employee

        $alertdata_employee['employee_id'] = $obj_employee->id;
        $alertdata_employee['client_id'] = $obj_employee->client_id;
        $alertdata_employee['email_body'] = $alert_employee->email_body;
        $alertdata_employee['sms_body'] = $alert_employee->sms_body;
        $alertdata_employee['arrExtra'][0] = array(
            '[#custName#]',
            '[#custMobile#]',
            '[#greeting#]'
        );
        $alertdata_employee['arrExtra'][1] = array(
            "",
            $model->caller_number,
            $greeting_msg
        );
        $alertdata_employee = Yii::$app->LMS->Template($alertdata_employee);

        if ($alert_settings_employee->email_status == 1) {
            $data['from'] = $obj_employee->company_email;
            $data['to'] = $obj_employee->company_email;
            $data['subject'] = $alert_employee->email_subject;
            $data['body'] = $alertdata_employee[0];
            $result = Yii::$app->LMS->sendMail($data, $alert_settings_employee, $obj_employee->id, 0);
        }
        if ($alert_settings_employee->sms_status == 1) {
            Yii::$app->LMS->sendSMST($alertdata_employee[1], $obj_employee->username, $alert_settings_employee, $obj_employee->id, $customer = 'No', 0);
        }

        header("Content-type: text/xml; charset=utf-8");
        echo '<?xml version="1.0" encoding="utf-8"?><response><status>Data Updated Successfully</status></response>';
    }

    public function sendEmailAndSms($model, $obj_employee, $obj_enquiry, $obj_customer, $obj_customer_info, $model_id = 0, $exist = 0) {

        /*
         * $exist=0   new 
         * $exist=1   exist customer
         * 
         */

        /* ||---Customer--|| */

        if ($exist == 1) {
            if ($model->customer_call_status == 'Connected') {
                //existing customer connected
                //customer  
                $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 19])->one();
                if ($alert_settings_customer->alert_type == 0) {
                    $alert_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
                } else {
                    $alert_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
                }

                //employee  
                $alert_settings_employee = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 20])->one();
                $alert_employee = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_employee->event_id])->one();
            } else if ($model->customer_call_status == 'Missed' || $model->customer_call_status == 'NotConnected') {
                //existing customer missed call
                //customer  
                $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 21])->one();
                if ($alert_settings_customer->alert_type == 0) {
                    $alert_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
                } else {
                    $alert_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
                }

                //employee  
                $alert_settings_employee = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 22])->one();
                $alert_employee = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_employee->event_id])->one();
            }
        }
        if ($exist == 0) {
            if ($model->customer_call_status == 'Connected') {
                //new customer connected call
                //customer  
                $alert_settings_customer = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 17])->one();
                if ($alert_settings_customer->alert_type == 0) {
                    $alert_customer = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_customer->event_id])->one();
                } else {
                    $alert_customer = \common\models\AlertsCustomModel::find()->where(['client_id' => $alert_settings_customer->client_id, 'event_id' => $alert_settings_customer->event_id])->one();
                }

                //employee  
                $alert_settings_employee = \common\models\AlertsSettingsModel::find()->where(['client_id' => $obj_employee->client_id, 'event_id' => 18])->one();
                $alert_employee = \common\models\AlertsDefaultModel::find()->where(['event_id' => $alert_settings_employee->event_id])->one();
            } else if ($model->customer_call_status == 'Missed' || $model->customer_call_status == 'NotConnected') {

                $template_settings_customer = TemplatesSetting::where(['client_id' => $model->client_id, 'templates_event_id' => 15, 'template_for' => 1])->first();
                if ($template_settings_customer->template_type == 0) {
                    $template_customer = TemplatesDefault::where(['templates_event_id' => 15, 'template_for' => 1])->first();
                } else {
                    $template_customer = TemplatesCustom::where(['client_id' => $model->client_id, 15])->first();
                }

                //employee  
                $template_settings_employee = TemplatesSetting::where(['client_id' => $model->client_id, 'templates_event_id' => 16, 'template_for' => 0])->first();
                $template_employee = TemplatesDefault::where(['templates_event_id' => 16, 'template_for' => 0])->first();
            }
        }

        /* customer */

        date_default_timezone_set('Asia/Kolkata');
        $h = date('h');
        $a = date('A');
        if ($h >= 05 and $h < 12 and $a == 'AM')
            $greeting_msg = "Good Morning";
        else if (( $h == 12 || $h < 04 ) and $a == 'PM')
            $greeting_msg = "Good Afternoon";
        else if ($h >= 04 and $h < 10 and $a == 'PM')
            $greeting_msg = "Good Evening";
        else
            $greeting_msg = '';


        //$string = rand(1111111111, 9999999999);
       // $shortenquirytoken = new \common\models\ShortEnquiryTokenModel();
        //$shortenquirytoken->token = $string;
        //$shortenquirytoken->save(false);

        $server_url = 'http://businessapps.co.in';
        //$next_url = $server_url . "customer_info_form?t=" . urlencode($string) . "&d=" . urlencode(base64_encode($obj_customer->id)) . "&eq=" . urlencode(base64_encode($obj_enquiry->id));

        //$longUrl = $next_url;
        $return_val = $this->shortenUrl($server_url);
        $short_url_result = $return_val['id'];
        
        $customer_sms_body = $template_customer->sms_body;
        $customer_email_body = $template_customer->email_body;
        $employee_sms_body = $template_employee->sms_body;
        $employee_email_body = $template_employee->email_body;

        $arr_static_tags_search = array(
                    '[#greeting#],',
                    '[#custFormLink#]',
                    '[#employeeName#]',
                    '[#employeeMobile#]',
                    '[#companyMktName#]',
                    '[#custMobile#]',
                    '[#custName#]'
                );
               
                $arr_static_tags_replace = array(
                    $greeting_msg,
                    $short_url_result,
                    $obj_employee->first_name. ' '. $obj_employee->last_name,
                    $obj_employee->username,
                    "LMS Auto Test",
                    $obj_customer->mobile_number,
                    $obj_customer_info->first_name.' '.$obj_customer_info->last_name
                ); 
                
                $cust_template_email = str_replace($arr_static_tags_search, $arr_static_tags_replace, $customer_email_body);
                $cust_template_sms = str_replace($arr_static_tags_search, $arr_static_tags_replace, $customer_sms_body);
                $emp_template_email = str_replace($arr_static_tags_search, $arr_static_tags_replace, $employee_email_body);
                $emp_template_sms = str_replace($arr_static_tags_search, $arr_static_tags_replace, $employee_sms_body);
                
                $email_config = EmailConfiguration::where('client_id',1)->first();
                $userName = base64_decode($email_config->email);
                $password = base64_decode($email_config->password);
                $companyName = "LMS Auto Test";
                
                
                //$smsresult = Gupshup::sendSMS($smsbody, $mobile, $smstype);
                $loggedInUserId = 1;
                $isInternational = 0; //0 OR 1
                $sendingType = 1; //always 0 for T_SMS
                $smsType = "T_SMS";
                
                if($template_settings_customer->email_status == 1){
                        
                        $subject = $customer_email_body->email_subject;
                        $data = ['mailBody' => $cust_template_email, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => $obj_customer->email_id];
                        $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
                }
                if($template_settings_customer->sms_status == 1){
                    $mobile = $obj_customer->mobile_number;
                    $customer = "Yes";
                    $customerId = $obj_customer_info->id;
                    $result = Gupshup::sendSMS($cust_template_sms, $mobile, $loggedInUserId, $customer, $customerId, $isInternational,$sendingType, $smsType);
                    //print_r($result);exit;
                }
                
                if($template_settings_employee->email_status == 1){
                    $subject = $template_employee->email_subject;
                    $data = ['mailBody' => $emp_template_email, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => $obj_employee->email, "cc" => "saloni@nextedgegroup.co.in"];
                    $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
                }
                if($template_settings_employee->sms_status == 1){
                    $mobile = $obj_employee->username;
                    $customer = "No";
                    $customerId = 0;
                    $result = Gupshup::sendSMS($emp_template_sms, $mobile, $loggedInUserId, $customer, $customerId, $isInternational,$sendingType, $smsType);
                }
    /*    $alertdata['customer_id'] = $obj_customer->id;
        $alertdata['employee_id'] = $obj_employee->id;
        $alertdata['client_id'] = $obj_employee->client_id;
        $alertdata['email_body'] = $alert_customer->email_body;
        $alertdata['sms_body'] = $alert_customer->sms_body;
        $alertdata['arrExtra'][0] = array(
            '[#greeting#]',
            '[#custFormLink#]',
        );
        $alertdata['arrExtra'][1] = array(
            $greeting_msg,
            $short_url_result,
        );

        $alertsdata = Yii::$app->LMS->Template($alertdata);

        if ($alert_settings_customer->email_status == 1) {
            $data['from'] = $obj_employee->company_email;
            $data['to'] = $obj_customer->email_1;
            $data['subject'] = $alert_customer->email_subject;
            $data['body'] = $alertsdata[0];
            $result = Yii::$app->LMS->sendMail($data, $alert_settings_customer, $obj_employee->id, $obj_customer->id);
        }
        if ($alert_settings_customer->sms_status == 1) {
            Yii::$app->LMS->sendSMST($alertsdata[1], $obj_customer->mobile_1, $alert_settings_customer, $obj_employee->id, $customer = 'Yes', $obj_customer->id);
        }


        //employee

        $alertdata_employee['customer_id'] = $obj_customer->id;
        $alertdata_employee['employee_id'] = $obj_employee->id;
        $alertdata_employee['client_id'] = $obj_employee->client_id;
        $alertdata_employee['email_body'] = $alert_employee->email_body;
        $alertdata_employee['sms_body'] = $alert_employee->sms_body;
        $alertdata_employee = Yii::$app->LMS->Template($alertdata_employee);

        if ($alert_settings_employee->email_status == 1) {
            $data['from'] = $obj_employee->company_email;
            $data['to'] = $obj_employee->company_email;
            $data['subject'] = $alert_employee->email_subject;
            $data['body'] = $alertdata_employee[0];
            $result = Yii::$app->LMS->sendMail($data, $alert_settings_employee, $obj_employee->id, $obj_customer->id);
        }
        if ($alert_settings_employee->sms_status == 1) {
            Yii::$app->LMS->sendSMST($alertdata_employee[1], $obj_employee->username, $alert_settings_employee, $obj_employee->id, $customer = 'No', 0);
        }*/
    }

    /**
     * Manages all models.
     */

    /**
     * Performs the AJAX validation.
     * @param Cloudcallinglogs $model the model to be validated
     */
    public function moveOutboundMP3() {
        $recoreds = CloudCallingC2cLogsModel::find()->where(['mp3_status' => 0, 'call_status' => 'Connected'])->orderBy(['id' => SORT_DESC])->limit(500)->offset(0)->all();

        if (!empty($recoreds)) {
            $i = 1;
            //  echo '<br>Outbound recording moving to AWS S3 started...<br>';
            foreach ($recoreds as $recored) {
                if ($recored->request_url != '') {
                    $url = '';
                    $arrs = explode('&', $recored->request_url);
                    foreach ($arrs as $arr => $value) {
                        $dada = explode('=', $value);
                        if ($dada[0] == 'recording_url' && $dada[1] != '') {
                            $url = $dada[1];
                        }
                    }
                    // echo $recored->id;
                    // echo $url;exit;
                    if ($url != '' && strpos($url, "http") !== false) {
                        try {
                            $org_file_path = urldecode($url);
                            $live_file = basename($org_file_path) . '.mp3';
                            //echo $this->image_path.'cloud_calling/call_logs/'.$live_file;						
                            $temp_file = $this->temp_path . $live_file;
                            // echo 'here';exit;
                            // echo $temp_file;
                            // echo $org_file_path;exit;
                            @file_put_contents($temp_file, fopen($org_file_path, 'r'));
                            // $folder ='cloud_calling/call_logs/outbound';
                            // Yii::$app->s3->awsupload( $temp_file, $folder, $live_file );
                            // $awsModel = new Aws();
                            // $awsPath = 'cloud_calling/call_logs/outbound/';
                            // $isUploadedPhoto = $awsModel->uploadFile($awsPath, $temp_file);

                            $recored->call_recording_url = $live_file;
                            $recored->mp3_status = 1;
                            $recored->save(false);
                            //@unlink($temp_file);
                            $i++;
                            //    echo '<br>recording id =>'.$recored->id.' transferred.<br>';
                        } catch (Exception $e) {
                            // echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }
                    } else {
                        // echo '<br>recording id =>'.$recored->id.' failed to transfer.<br>';
                    }
                }
            }
            //   echo "Total $i recordings moved successfully.";                                
            //   echo '<br>Outbound recording moving Ended...<br>';
        } else {
            // echo '<br>No Outbound recordings found<br>';
        }
    }

    public function moveMP3() {

        $recoreds = CloudCallingLogsModel::find()->where(['mp3_status' => 0, 'call_status' => 'Connected'])->orderBy(['id' => SORT_DESC])->limit(500)->offset(0)->all();

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

}
