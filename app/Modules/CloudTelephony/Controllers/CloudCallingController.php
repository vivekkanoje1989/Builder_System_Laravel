<?php

namespace App\Modules\CloudTelephony\Controllers;

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
class CloudCallingController extends Controller {

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

    public function agentnumbers() {

        if (empty($_GET['virtual_number']))
            $this->_sendResponse(500, 'Error: Parameter <b>virtual_number</b> is missing');

        if (empty($_GET['client_id']))
            $this->_sendResponse(500, 'Error: Parameter <b>client_id</b> is missing');

        if (empty($_GET['client_access_key']))
            $this->_sendResponse(500, 'Error: Parameter <b>client_access_key</b> is missing');

        if (empty($_GET['caller_number']))
            $this->_sendResponse(500, 'Error: Parameter <b>caller_number</b> is missing');

        $arg_virtual_number = trim($_GET['virtual_number']);
        $arg_client_code = trim($_GET['client_id']);
        $arg_app_access_key = trim($_GET['client_access_key']);
        $arg_caller_number = trim($_GET['caller_number']);
        $arg_caller_number = substr($arg_caller_number, -10); //ltrim($arg_caller_number,'91');
        #echo $_GET['caller_number'].'<br>';
        #echo $arg_caller_number;

        $action = "agentnumbers"; //exit;
//            switch ($action) {
//                // Find respective model
//                case 'agentnumbers': // {{{
//                    $model = Systemconfig::find()->Where(array('client_code' => $arg_client_code, 'app_access_key' => $arg_app_access_key))->one();
//                    break; // }}}
//                default: // {{{
//                    $this->_sendResponse(501, sprintf('Mode <b>agentnumbers</b> is not implemented for action <b>%s</b>', $action));
//                    exit; // }}}
//            }
//
//            if (empty($model)) {
//                $this->_sendResponse(404, 'No Client found with attributes ' . $arg_client_code . ' and ' . $arg_app_access_key);
//            } 

        $virtual_number_row = CtSetting::where("virtual_number", $arg_virtual_number)->first();

        if (empty($virtual_number_row))
            $this->_sendResponse(404, 'No such virtual number found.');

        $extensions = CtEmployeesExtension::where(['client_id' => $virtual_number_row->client_id])->get();

        if (!empty($extensions)) {
            foreach ($extensions as $ext) {
                $extensionemp = Employee::where(['id' => $ext->employee_id])->first();
                $extension_no[] = $ext->extension_no . '=+91' . $extensionemp->username;
            }

            $bridge_list = array(@implode(',', $extension_no));
        }


        $customer_info = CustomersContact::where(array('mobile_number' => $arg_caller_number, 'client_id' => $virtual_number_row->client_id))->first();

        if (empty($customer_info))
            $customer_info = CustomersContact::where(array('landline_number' => $arg_caller_number, 'client_id' => $virtual_number_row->client_id))->first();



        if (!empty($customer_info)) {

            $customer_details = Customer::where("id", $customer_info->customer_id)->first();
            $customer_titles = LstTitle::where("id", $customer_details->title_id)->first();

            $customer_title = $customer_titles->title;

            $customer_fname = $customer_details->first_name;

            $attributes = array('customer_id' => $customer_details->id, 'enquiry_sales_status_id' => 1);
            //$admin_name_row = EnquiryModel::find()->Where($attributes)->with('employeeDetail')->orderBy(['id' => SORT_DESC])->one();

            $enquiry_emp_row = Enquiry::where($attributes)->first();
            $admin_name_row = Employee::where("id", $enquiry_emp_row->sales_employee_id)->first();

            $admin_fname = $admin_name_row->first_name;
            $admin_mobile = $admin_name_row->username;
            $latest_enq_status = $enquiry_emp_row->enquiry_sales_status_id;
        }

        $msg_key = 'msg';
        $msg_val = '';
        $msg_hold_key = 'hold_msg';
        $msg_hold_val = '';
        

        $current_time = date('h A');
        if (!empty($virtual_number_row->nwh_start_time))
            $non_working_start_time = date('h A', strtotime($virtual_number_row->nwh_start_time));
        if (!empty($virtual_number_row->nwh_end_time))
            $non_working_end_time = date('h A', strtotime($virtual_number_row->nwh_end_time));

        /*if (!empty($virtual_number_row->nwh_start_time) && !empty($virtual_number_row->nwh_end_time) && $current_time > $non_working_start_time && $current_time > $non_working_end_time) {
            //echo "here1";exit;
            if (!empty($virtual_number_row->nwh_welcome_tune_type_id)) {
                $set_auto_answering_mode_on = 1;

                if ($set_auto_answering_mode_on == 1) {
                    $calling_type_for_non_working_hour = $virtual_number_row->nwh_welcome_tune_type_id;

                    if ($calling_type_for_non_working_hour == 2) {
                        if (!empty($customer_fname))
                            $msg_val .= 'Dear ' . ucwords($customer_title) . ' ' . ucwords($customer_fname) . ' ';
                        $msg_val .= $virtual_number_row->ec_welcome_tune;
                    }else if ($calling_type_for_non_working_hour == 3) {
                        $msg_key = 'msg';
                        $msg_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->ec_welcome_tune;
                    }
                    $agent_numbers = '';
                }
            } else if ($set_auto_answering_mode_on == 0) {
                if (!empty($virtual_number_row->assign_non_working_time_call_to)) {
                    $menu_admin_arr = array();
                    $menu_all_mobile = array();
                    $menu_admin_arr = @explode(',', $virtual_number_row->assign_non_working_time_call_to);
                    foreach ($menu_admin_arr as $admin_id) {
                        $admin_mobile_model = EmployeeModel::find()->where(['id' => $admin_id])->one();
                        // if(!empty($admin_mobile_model->mobile))
                        // $menu_all_mobile[]=$admin_mobile_model->mobile;
                        // else 
                        if (!empty($admin_mobile_model->username))
                            $menu_all_mobile[] = $admin_mobile_model->username;
                    }
                    $agent_numbers = @implode(',', $menu_all_mobile);
                    $msg_val .= 'Kindly wait we are transferring your call';
                }
            }
            if (!empty($customer_fname))
                $insert_enquiry_for_NWH = 0;
            else
                $insert_enquiry_for_NWH = 1;

            if (!empty($virtual_number_row->calling_type_for_non_working_hour)) {
                $value = array('status' => 'success', 'ivr_type' => '4', 'ivr_data' => array($msg_key => $msg_val, $msg_hold_key => $msg_hold_val, 'agent_numbers' => $agent_numbers, 'insert_enquiry' => $insert_enquiry_for_NWH));
            } else {
                $value = array('status' => 'success', 'ivr_type' => '1', 'ivr_data' => array($msg_key => $msg_val, $msg_hold_key => $msg_hold_val, 'agent_numbers' => $agent_numbers, 'insert_enquiry' => $insert_enquiry_for_NWH));
            }

            $this->_sendResponse(200, $this->_getObjectEncoded($action, $value));

            #End Check if cuurent time is non working#
        } else*/
        if (!empty($virtual_number_row->ec_call_status) && $virtual_number_row->ec_call_status == 1) {
             
            if ($virtual_number_row->ec_welcome_tune_type_id != 3) {
                if (!empty($virtual_number_row->read_cust_name) && $virtual_number_row->read_cust_name == 1) {
                    if (!empty($customer_fname))
                        $msg_val .= 'Dear ' . ucwords($customer_title) . ' ' . ucwords($customer_fname) . ' ';
                }
            } else {
                $msg_key = 'msg';
                $msg_hold_key = 'hold_msg';
            }

            if (!empty($virtual_number_row->ec_welcome_tune_type_id) && $virtual_number_row->ec_welcome_tune_type_id == 1) {
                $msg_val .= 'Kindly wait transferring your call';
            } else if (!empty($virtual_number_row->ec_welcome_tune_type_id) && $virtual_number_row->ec_welcome_tune_type_id == 2) {
                if (!empty($virtual_number_row->ec_welcome_tune) && $virtual_number_row->ec_welcome_tune) {
                    $msg_val .= $virtual_number_row->ec_welcome_tune . ' we are transferring your call';
                }
            } else if (!empty($virtual_number_row->ec_welcome_tune_type_id) && $virtual_number_row->ec_welcome_tune_type_id == 3) {
                if (!empty($virtual_number_row->ec_welcome_tune) && $virtual_number_row->ec_welcome_tune) {
                    $msg_val .= "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->ec_welcome_tune;
                }
            } else {
                $msg_val .= 'Kindly wait we are transferring your call';
            }


            if ($virtual_number_row->ec_welcome_tune_type_id != 3) {
                if (!empty($virtual_number_row->read_emp_name) && $virtual_number_row->read_emp_name == 1) {

                    if (!empty($admin_fname))
                        $msg_val .= ' to ' . ucwords($admin_fname);
                }
            }else {
                $msg_key = 'msg'; //'url';
                $msg_hold_key = 'hold_msg'; //'hold_url';
            }

            if (empty($customer_info)) {
                $msg_val = '';
                $insert_enquiry_direct = $virtual_number_row->insert_enquiry;
            } else {

                if ($latest_enq_status != 2)
                    $insert_enquiry_direct = 0;
                else
                    $insert_enquiry_direct = 1;
            }


            if ($virtual_number_row->ec_hold_tune_type_id == 2) {
                $msg_hold_val = $virtual_number_row->ec_hold_tune;
                $msg_hold_key = 'hold_msg';
            } else if ($virtual_number_row->ec_hold_tune_type_id == 3) {
                $msg_hold_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->ec_hold_tune;
                $msg_hold_key = 'hold_msg';
            } else
                $msg_hold_val = '';


            if (!empty($admin_mobile))
                $agent_numbers = $admin_mobile;
            else if (!empty($admin_landline_no))
                $agent_numbers = $admin_landline_no;
            else {
                
                if (!empty($virtual_number_row->employees)) {
                    
                    $menu_admin_arr = array();
                    $menu_all_mobile = array();
                    $menu_admin_arr = @explode(',', $virtual_number_row->employees);
                    
                    foreach ($menu_admin_arr as $admin_id) {
                        $admin_mobile_model = Employee::where("id",$admin_id)->first();
                        if (!empty($admin_mobile_model->username))
                            $menu_all_mobile[] = $admin_mobile_model->username;
                    }
                    
                    if ($virtual_number_row->forwarding_type_id == 1) {
                        $agent_numbers = @implode('|', $menu_all_mobile);
                    } else if ($virtual_number_row->forwarding_type_id == 2) {
                        $agent_numbers = @implode(',', $menu_all_mobile);
                    } else if ($virtual_number_row->forwarding_type_id == 3) {//Start Rouond-robin 
                       
                        
                        $last_connected_row = CtLogsInbound::where(array("virtual_number" => $arg_virtual_number,"enquiry_flag" => "1","employee_call_status" => "Connected"))->orderBy('id', 'DESC')->first();
                        
                        $last_connected_no = $last_connected_row->employee_number;
                        
                        if (!empty($menu_all_mobile) && !empty($last_connected_no))
                            $agent_numbers = $this->roundrobin($menu_all_mobile, $last_connected_no);
                        
                        
                        if (!empty($agent_numbers))
                            $agent_numbers = @implode(',', $agent_numbers);
                        else
                            $agent_numbers = @implode(',', $menu_all_mobile);
                        
                    }//End Rouond-robin 
                    
                    
                    if ($virtual_number_row->welcome_tune_type_id == 1) {
                        //$msg='';									
                        $msg_key = 'msg';
                        $msg_val = '';
                        //$msg_hold_key = 'hold_msg';
                        //$msg_hold_val = '';
                        if ($virtual_number_row->hold_tune_type_id == 2) {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = $virtual_number_row->hold_tune;
                        } else if ($virtual_number_row->hold_tune_type_id == 3) {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->hold_tune;
                        } else {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = '';
                        }
                    } else if ($virtual_number_row->welcome_tune_type_id == 2) {
                        //$msg=$virtual_number_row->caller_tone;
                        $msg_key = 'msg';
                        if (empty($customer_info))
                            $msg_val = $virtual_number_row->welcome_tune;

                        if ($virtual_number_row->hold_tune_type_id == 2) {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = $virtual_number_row->hold_tune;
                        } else if ($virtual_number_row->hold_tune_type_id == 3) {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->hold_tune;
                        } else {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = '';
                        }
                    } else if ($virtual_number_row->welcome_tune_type_id == 3) {

                        //$msg=$virtual_number_row->caller_tone;
                        $msg_key = 'msg';
                        if (empty($customer_info))
                            $msg_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->welcome_tune;

                        if ($virtual_number_row->hold_tune_type_id == 2) {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = $virtual_number_row->hold_tune;
                        } else if ($virtual_number_row->hold_tune_type_id == 3) {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->hold_tune;
                        } else {
                            $msg_hold_key = 'hold_msg';
                            $msg_hold_val = '';
                        }
                    }
                    
                }
            }
            
            //bridge_list
            
            if (!empty($agent_numbers)) {
                $value = array('status' => 'success', 'ivr_type' => '1', 'ivr_data' => array($msg_key => $msg_val, $msg_hold_key => $msg_hold_val, 'agent_numbers' => $agent_numbers, 'insert_enquiry' => $insert_enquiry_direct, 'bridge_list' => $bridge_list));
            } else {
                
                if ($virtual_number_row->welcome_tune_type_id == 1) {
                    goto calling_type_2_3;
                } else if ($virtual_number_row->welcome_tune_type_id == 2) {
                    goto calling_type_2_3;
                } else if ($virtual_number_row->welcome_tune_type_id == 3) {
                    goto calling_type_2_3;
                }
            }

            //print_r($agent_numbers);exit;
        } else {
            
            if (!empty($virtual_number_row->employees)) {
               
                $menu_admin_arr = array();
                $menu_all_mobile = array();
                $menu_admin_arr = @explode(',', $virtual_number_row->employees);
                
                foreach ($menu_admin_arr as $admin_id) {
                    $admin_mobile_model = Employee::where("id",$admin_id)->first();
                    
                    if (!empty($admin_mobile_model->username))
                        
                        if ($virtual_number_row->forwarding_type_id != 1) { // changed
                            $menu_all_mobile[] = $admin_mobile_model->username . "#" . $virtual_number_row->forwarding_time;
                        } else {
                            $menu_all_mobile[] = $admin_mobile_model->username;
                        }
                }
                
                if ($virtual_number_row->forwarding_type_id == 1) {
                    $agent_numbers = @implode('|', $menu_all_mobile);
                } else if ($virtual_number_row->forwarding_type_id == 2) {
                    $agent_numbers = @implode(',', $menu_all_mobile);
                } else if ($virtual_number_row->forwarding_type_id == 3) {//Start Rouond-robin 
                    //AND extension=1 AND sub_extension=1
                   
                    $last_connected_row = CtLogsInbound::where(array("virtual_number" => $arg_virtual_number,"enquiry_flag" => "1","employee_call_status" => "Connected"))->orderBy('id', 'DESC')->first();
                    
                    $last_connected_no = $last_connected_row->employee_number;

                    if (!empty($menu_all_mobile) && !empty($last_connected_no))
                        $agent_numbers = $this->roundrobin($menu_all_mobile, $last_connected_no);

                    // $agent_numbers = @implode(',',$agent_numbers);

                    if (!empty($agent_numbers))
                        $agent_numbers = @implode(',', $agent_numbers);
                    else
                        $agent_numbers = @implode(',', $menu_all_mobile);
                }//End Rouond-robin 

                
                if ($virtual_number_row->welcome_tune_type_id == 1) {
                    //$msg='';
                    $msg_key = 'msg';
                    $msg_val = '';
                    $msg_hold_key = 'hold_msg';
                    $msg_hold_val = '';
                } else if ($virtual_number_row->welcome_tune_type_id == 2) {
                    //$msg=$virtual_number_row->caller_tone;
                    $msg_key = 'msg';
                    $msg_val = $virtual_number_row->welcome_tune;

                    if ($virtual_number_row->hold_tune_type_id == 2) {
                        $msg_hold_key = 'hold_msg';
                        $msg_hold_val = $virtual_number_row->hold_tune;
                    } else if ($virtual_number_row->hold_tune_type_id == 3) {
                        $msg_hold_key = 'hold_msg';
                        $msg_hold_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->hold_tune;
                    }
                } else if ($virtual_number_row->welcome_tune_type_id == 3) {
                    //$msg=$virtual_number_row->caller_tone;
                    $msg_key = 'msg';
                    $msg_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->welcome_tune;
                    if ($virtual_number_row->hold_tune_type_id == 2) {
                        $msg_hold_key = 'hold_msg';
                        $msg_hold_val = $virtual_number_row->hold_tune;
                    } else if ($virtual_number_row->hold_tune_type_id == 3) {
                        $msg_hold_key = 'hold_msg';
                        $msg_hold_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->hold_tune;
                    }
                }
               
               
                //bridge list                        
                if (!empty($agent_numbers)) {
                    $value = array('status' => 'success', 'ivr_type' => '1', 'ivr_data' => array($msg_key => $msg_val, $msg_hold_key => $msg_hold_val, 'agent_numbers' => $agent_numbers, 'insert_enquiry' => $virtual_number_row->insert_enquiry, 'bridge_list' => $bridge_list));
                } else {
                    if ($virtual_number_row->calling_type == 2) {
                        goto calling_type_2_3;
                    } else if ($virtual_number_row->calling_type == 3) {
                        goto calling_type_2_3;
                    }
                }
                
            } else {
                 
                /*                 * End Direct Calling Type* */
                

                /*                 * Start MP3/TTS Calling Type* */
                
                calling_type_2_3:
                
                $calling_type_flag = 0;
                $calling_type_has_submenu_flag = 0;
                if ($virtual_number_row->welcome_tune_type_id == 1 || $virtual_number_row->welcome_tune_type_id == 2 || $virtual_number_row->welcome_tune_type_id == 3) {

                    $ivr_type_menu = 0;
                    if ($virtual_number_row->welcome_tune_type_id == 1) {
                        $welcome_msg_key = 'welcome_msg';
                        $welcome_msg_val = 'Kindly wait, we are transferring your call.';
                        $calling_type_flag = 2; //for ivr_type flag
                    } else if ($virtual_number_row->welcome_tune_type_id == 2) {
                        $welcome_msg_key = 'welcome_msg';
                        $welcome_msg_val = $virtual_number_row->welcome_tune;
                        $calling_type_flag = 2; //for ivr_type flag
                    } else if ($virtual_number_row->welcome_tune_type_id == 3) {
                        $welcome_msg_key = 'welcome_msg';
                        $welcome_msg_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->welcome_tune;
                        $calling_type_flag = 3; //for ivr_type flag
                    }

                    if ($virtual_number_row->hold_tune_type_id == 0) {
                        $menu_hold_msg_key = 'hold_msg';
                        $menu_hold_msg_val = 'Kindly wait, we are transferring your call.';
                    } else if ($virtual_number_row->hold_tune_type_id == 2) {
                        $menu_hold_msg_key = 'hold_msg';
                        $menu_hold_msg_val = $virtual_number_row->hold_tune;
                    } else if ($virtual_number_row->hold_tune_type_id == 3) {
                        $menu_hold_msg_key = 'hold_msg';
                        $menu_hold_msg_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->hold_tune;
                    }
                    //start -for missed call setting                   
                    if ($virtual_number_row->msc_facility_status == 1) {
                        if ($virtual_number_row->msc_welcome_tune_type_id == 1) {
                            $welcome_msg_key = 'msg';
                            $welcome_msg_val = '';
                        } else if ($virtual_number_row->msc_welcome_tune_type_id == 2) {
                            $welcome_msg_key = 'msg';
                            $welcome_msg_val = $virtual_number_row->msc_welcome_tune;
                        } else if ($virtual_number_row->msc_welcome_tune_type_id == 3) {
                            $welcome_msg_key = 'msg';
                            $welcome_msg_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $virtual_number_row->msc_welcome_tune;
                        }
                    }
                   
                    if ($virtual_number_row->msc_facility_status == 0) {
                        $menu_results = \App\Models\CtMenuSetting::leftjoin('ct_settings as cvn', 'ct_menu_settings.ct_settings_id', '=', 'cvn.id')
                        ->select('cvn.welcome_tune_type_id as cvn_calling_type', 'ct_menu_settings.ext_number as ccm_extension_no','ct_menu_settings.ext_name as ccm_ext_name', 'ct_menu_settings.insert_enquiry as ccm_insert_enquiry', 'ct_menu_settings.forwarding_type_id as ccm_forwarding_type', 'ct_menu_settings.employees as ccm_agent_numbers','ct_menu_settings.welcome_tune_type_id as ccm_ext_calling_type' , 'ct_menu_settings.hold_tune_type_id as ccm_ext_calling_type_waiting' , 'ct_menu_settings.welcome_tune as ccm_ext_caller_tone', 'ct_menu_settings.hold_tune as ccm_ext_waiting_tune', 'ct_menu_settings.id as ccm_menu_id', 'ct_menu_settings.forwarding_time as ccm_forwarding_type_timelimit','ct_menu_settings.msc_facility_status as ccm_missedcall_setting','ct_menu_settings.menu_status as ccm_status','ct_menu_settings.msc_welcome_tune_type_id as ccm_msc_welcome_tune_type_id','ct_menu_settings.msc_welcome_tune as ccm_msc_welcome_tune','ct_menu_settings.msc_call_insert_enquiry as ccm_msc_call_insert_enquiry','ct_menu_settings.msc_default_employee_id as ccm_msc_default_employee_id')
                        ->get();
                        
                        $regex = array();
                        $extension_numbers = array();
                        $agent_numbers = array();
                        $insert_enquiry = array();
                        $has_submenu = array();
                        $ext_welcome_msg_key = array();
                        $ext_welcome_msg_val = array();
                        $ext_hold_msg_key = array();
                        $ext_hold_msg_val = array();
                        $extension_welcome_data = array();
                       
                        foreach ($menu_results as $menu_result) {
                            //$count_menu_row++;
                            
                             
                            if ($menu_result['ccm_status'] == 1) {
                                //$count_menu_row++;
                                $regex[] = $menu_result['ccm_extension_no'];
                                $extension_numbers[] = $menu_result['ccm_extension_no'];
                                
                            
                                $thank_you_msg = array();
                                $agent_numbers = array();

                                if ($menu_result['ccm_missedcall_setting'] == 0) {
                                    
                                    if ($menu_result['ccm_status'] == 1) {
                                        $menu_admin_arr = array();
                                        $menu_all_mobile = array();
                                        
                                        if ($menu_result['ccm_ext_calling_type'] == 2) {
                                            $ext_welcome_msg_key = 'ext_welcome_msg';
                                            $ext_welcome_msg_val = $menu_result['ccm_ext_caller_tone'];
                                        } else if ($menu_result['ccm_ext_calling_type'] == 3) {
                                            $ext_welcome_msg_key = 'ext_welcome_msg';
                                            $ext_welcome_msg_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $menu_result['ccm_ext_caller_tone'];
                                        } else {
                                            $ext_welcome_msg_key = 'ext_welcome_msg';
                                            $ext_welcome_msg_val = '';
                                        }

                                        if ($menu_result['ccm_ext_calling_type'] == 2) {
                                            $ext_welcome_msg_key1[] = 'ext_welcome_msg';
                                            $ext_welcome_msg_val1[] = $menu_result['ccm_ext_caller_tone'];
                                        } else if ($menu_result['ccm_ext_calling_type'] == 3) {
                                            $ext_welcome_msg_key1[] = 'ext_welcome_msg';
                                            $ext_welcome_msg_val1[] = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $menu_result['ccm_ext_caller_tone'];
                                        } else {
                                            $ext_welcome_msg_key1[] = 'ext_welcome_msg';
                                            $ext_welcome_msg_val1[] = '';
                                        }

                                        // print_r($ext_welcome_msg_key);print_r($ext_welcome_msg_val);exit;   
                                        if ($menu_result['ccm_ext_calling_type_waiting'] == 2) {
                                            $ext_hold_msg_key = 'ext_hold';
                                            $ext_hold_msg_val = $menu_result['ccm_ext_waiting_tune'];
                                        } else if ($menu_result['ccm_ext_calling_type_waiting'] == 3) {
                                            $ext_hold_msg_key = 'ext_hold';
                                            $ext_hold_msg_val = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $menu_result['ccm_ext_waiting_tune'];
                                        } else {
                                            $ext_hold_msg_key = 'ext_hold';
                                            $ext_hold_msg_val = '';
                                        }

                                        if ($menu_result['ccm_ext_calling_type_waiting'] == 2) {
                                            $ext_hold_msg_key1[] = 'ext_hold';
                                            $ext_hold_msg_val1[] = $menu_result['ccm_ext_waiting_tune'];
                                        } else if ($menu_result['ccm_ext_calling_type_waiting'] == 3) {
                                            $ext_hold_msg_key1[] = 'ext_hold';
                                            $ext_hold_msg_val1[] = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $menu_result['ccm_ext_waiting_tune'];
                                        } else {
                                            $ext_hold_msg_key1[] = 'ext_hold';
                                            $ext_hold_msg_val1[] = '';
                                        }

                                        //changes done
                                        //end extentin

                                        $menu_admin_arr = @explode(',', $menu_result['ccm_agent_numbers']);
                                        
                                        foreach ($menu_admin_arr as $admin_id) {
                                            //$admin_mobile_model = EmployeeModel::find()->where(['id' => $admin_id])->one();
                                            $admin_mobile_model = Employee::where("id",$admin_id)->first();
                                            if (!empty($admin_mobile_model->username)) {
                                                if ($menu_result['ccm_forwarding_type'] != 1) {// changed
                                                    $menu_all_mobile[] = $admin_mobile_model->username . "#" . $menu_result['ccm_forwarding_type_timelimit'];
                                                } else {
                                                    $menu_all_mobile[] = $admin_mobile_model->username;
                                                }
                                            }
                                        }
                                        


                                        if (!empty($menu_result['ccm_forwarding_type']) && $menu_result['ccm_forwarding_type'] == 1) {
                                            $agent_numbers[] = @implode('|', $menu_all_mobile);
                                        } else if (!empty($menu_result['ccm_forwarding_type']) && $menu_result['ccm_forwarding_type'] == 2) {
                                            $agent_numbers[] = @implode(',', $menu_all_mobile);
                                        }
                                        
                                        //Start Rouond-robin 
                                        else if (!empty($menu_result['ccm_forwarding_type']) && $menu_result['ccm_forwarding_type'] == 3) {

                                            //AND extension=1 AND sub_extension=1
//                                            $last_connected_menu_sql = "SELECT * 
//									FROM cloud_calling_logs 
//									WHERE virtual_number=" . $arg_virtual_number . "
//									AND enquiry_flag=1
//									AND extension=" . $menu_result['ccm_extension_no'] . "
//									AND call_status='Connected'
//									ORDER By id DESC
//									LIMIT 0,1";
//
//                                            $last_connected_menu_row = \common\models\CloudCallingLogsModel::getDb()->createCommand($last_connected_menu_sql)->queryAll();
//
//                                            $last_connected_menu_no = $last_connected_menu_row[0]['call_connected_to'];
//                                            if (!empty($menu_all_mobile) && !empty($last_connected_menu_no))
//                                                $menu_all_mobile = $this->roundrobin($menu_all_mobile, $last_connected_menu_no);
//
//                                            $agent_numbers[] = @implode(',', $menu_all_mobile);
                                            
                                            $last_connected_menu_row = CtLogsInbound::where(array("virtual_number" => $arg_virtual_number,"enquiry_flag" => "1","extension_number" =>$menu_result['ccm_extension_no'] ,"employee_call_status" => "Connected"))->orderBy('id', 'DESC')->first();
                                            if(!empty($last_connected_menu_row))
                                                $last_connected_menu_no = $last_connected_menu_row->employee_number;
                                            else
                                                $last_connected_menu_no = '';
                                                    
                                            if (!empty($menu_all_mobile) && !empty($last_connected_menu_no))
                                                $agent_numbers = $this->roundrobin($menu_all_mobile, $last_connected_menu_no);


                                            if (!empty($agent_numbers))
                                                $agent_numbers = @implode(',', $agent_numbers);
                                            else
                                                $agent_numbers = @implode(',', $menu_all_mobile);
                                        }
                                        
                                        //End Rouond-robin 
                                        $insert_enquiry = $menu_result['ccm_insert_enquiry'];
                                        
                                        $regex1 = @implode('', $regex);
                                        
                                        $subivrdata[] = array('ivr_type' => '1', $ext_welcome_msg_key => $ext_welcome_msg_val, $ext_hold_msg_key => $ext_hold_msg_val, 'menu_noinput' => 'url', 'menu_nomatch' => 'url', 'agent_numbers' => $agent_numbers, 'insert_enquiry' => $insert_enquiry);
                                    }
                                }
                                else if ($menu_result['ccm_missedcall_setting'] == 1) {

                                    if ($menu_result['ccm_status'] == 0) {
                                        $subivrdata[] = array();
                                    } else if ($menu_result['ccm_status'] == 1) {
                                        //for ivr 4 
                                       
                                        if ($menu_result['ccm_msc_welcome_tune_type_id'] == 2) {

                                            $thank_you_msg = $menu_result['ccm_msc_welcome_tune'];
                                        } else if ($menu_result['ccm_msc_welcome_tune_type_id'] == 3) {
                                            $thank_you_msg = "https://s3-ap-south-1.amazonaws.com/lms-auto/" . $virtual_number_row->client_id . '/cloud_calling/caller_tune/' . $menu_result['ccm_msc_welcome_tune'];
                                        } else {

                                            $thank_you_msg = '';
                                        }


                                        $insert_enquiry = $menu_result['ccm_msc_call_insert_enquiry'];
                                        $subivrdata[] = array('ivr_type' => '4', 'msg' => $thank_you_msg, 'insert_enquiry' => $insert_enquiry);
                                        
                                    }
                                }//end ivr 4
                            } else {

                                $agent_numbers = array();
                                $insert_enquiry = array();
                            }


                           /* if ($menu_result['ccm_submenu'] == 1) {
                                if ($menu_result['ccm_status'] == 0) {
                                    $subivrdata[] = array();
                                } else if ($menu_result['ccm_status'] == 1) {

                                    // $ext_welcome_msg_key1 =array();
                                    // $ext_welcome_msg_val1 =array();
                                    if ($menu_result['ccm_calling_type'] == 2) {
                                        $ext_welcome_msg_key1[] = 'ext_welcome_msg';
                                        $ext_welcome_msg_val1[] = $menu_result['ccm_submenu_caller_tone'];
                                    } else if ($menu_result['ccm_calling_type'] == 3) {
                                        $ext_welcome_msg_key1[] = 'ext_welcome_msg';
                                        $ext_welcome_msg_val1[] = $this->S3PATH . $virtual_number_row->client_id . 'cloud_calling/caller_tune/' . $menu_result['ccm_submenu_caller_tone'];
                                    } else {
                                        $ext_welcome_msg_key1[] = 'ext_welcome_msg';
                                        $ext_welcome_msg_val1[] = '';
                                    }

                                    // $ext_hold_msg_key1 = array();
                                    //  $ext_hold_msg_val1 = array();
                                    if ($menu_result['ccm_calling_type_waiting'] == 2) {
                                        $ext_hold_msg_key1[] = 'ext_hold';
                                        $ext_hold_msg_val1[] = $menu_result['ccm_submenu_waiting_tune'];
                                    } else if ($menu_result['ccm_calling_type_waiting'] == 3) {
                                        $ext_hold_msg_key1[] = 'ext_hold';
                                        $ext_hold_msg_val1[] = $this->S3PATH . $virtual_number_row->client_id . 'cloud_calling/caller_tune/' . $menu_result['ccm_submenu_waiting_tune'];
                                    } else {
                                        $ext_hold_msg_key1[] = 'ext_hold';
                                        $ext_hold_msg_val1[] = '';
                                    }
                                    //end changes
                                    $ivr_type_submenu = 2;

//                                if ($menu_result['ccm_calling_type_waiting'] == 2) {
//                                    $submenu_hold_msg_key = 'submenu_hold_msg';
//                                    $submenu_hold_msg_val = $menu_result['ccm_submenu_waiting_tune'];
//                                } else if ($menu_result['ccm_calling_type_waiting'] == 3) {
//                                    $submenu_hold_msg_key = 'submenu_hold_url';
//                                    $submenu_hold_msg_val = $this->S3PATH . '/cloud_calling/caller_tune/' . $menu_result['ccm_submenu_waiting_tune'];
//                                }

                                    $extension_number = $menu_result['ccm_extension_no'];

                                    $submenu_list = CloudCallingSubmenuModel::find()->where(['menu_id' => $menu_result['ccm_menu_id'], 'status' => 1])->orderBy('sub_extension_no')->all();

                                    if ($menu_result['ccm_calling_type'] == 2)
                                        $submenu_calling_type = 'TTS';
                                    else if ($menu_result['ccm_calling_type'] == 3)
                                        $submenu_calling_type = 'MP3';


                                    $regex_submenu = array();
                                    $subextension_number = array();
                                    $agent_numbers_submenu = array();
                                    $submenu_insert_submenu = array();
                                    //$submenu_msg_val = '';
                                    $inactive_flag = 0;
                                    $ext_welcome_msg_key = array();
                                    $ext_welcome_msg_val = array();
                                    $ext_hold_msg_key = array();
                                    $ext_hold_msg_val = array();

                                    foreach ($submenu_list as $submenu_row) {
                                        $calling_type_has_submenu_flag = 1; //for ivr_type flag
                                        $inactive_flag = $submenu_row->status; //flag status of active(1)/inactive(0)

                                        $subextension_number[] = $submenu_row->sub_extension_no;
                                        $regex_submenu[] = $submenu_row->sub_extension_no;
                                        $submenu_insert_submenu[] = $submenu_row->insert_enquiry;

                                        $admin_arr = array();
                                        $all_mobile = array();

                                        // start extenstion 

                                        if (!empty($submenu_row->bridge_agent)) {

                                            $bridge_agent_list_subval[] = $submenu_row->bridge_agent;
                                        }
                                        // $ext_welcome_msg_key = array();
                                        // $ext_welcome_msg_val =array();

                                        if ($submenu_row['ext_calling_type'] == 2) {
                                            $ext_welcome_msg_key[] = 'subext_welcome_msg';
                                            $ext_welcome_msg_val[] = $submenu_row['ext_caller_tone'];
                                        } else if ($submenu_row['ext_calling_type'] == 3) {
                                            $ext_welcome_msg_key[] = 'subext_welcome_msg';
                                            $ext_welcome_msg_val[] = $this->S3PATH . $virtual_number_row->client_id . 'cloud_calling/caller_tune/' . $submenu_row['ext_caller_tone'];
                                        } else {
                                            $ext_welcome_msg_key[] = '';
                                            $ext_welcome_msg_val[] = '';
                                        }

                                        //  $ext_hold_msg_key = array();
                                        //  $ext_hold_msg_val = array();
                                        if ($submenu_row['ext_calling_type_waiting'] == 2) {
                                            $ext_hold_msg_key[] = 'subext_hold';
                                            $ext_hold_msg_val[] = $submenu_row['ext_waiting_tune'];
                                        } else if ($submenu_row['ext_calling_type_waiting'] == 3) {
                                            $ext_hold_msg_key[] = 'subext_hold';
                                            $ext_hold_msg_val[] = $this->S3PATH . $virtual_number_row->client_id . 'cloud_calling/caller_tune/' . $submenu_row['ext_waiting_tune'];
                                        } else {
                                            $ext_hold_msg_key[] = '';
                                            $ext_hold_msg_val[] = '';
                                        }


                                        //end extenstion

                                        $admin_arr = @explode(',', $submenu_row->agent_numbers);
                                        foreach ($admin_arr as $admin_id) {
                                            $admin_mobile_model = EmployeeModel::find()->where(['id' => $admin_id])->one();
                                            // if(!empty($admin_mobile_model->mobile))
                                            // $all_mobile[]=$admin_mobile_model->mobile;
                                            // else 
                                            if (!empty($admin_mobile_model->username))
                                                if ($submenu_row->forwarding_type != 1) {// changed
                                                    $all_mobile[] = $admin_mobile_model->username . "#" . $submenu_row->forwarding_type_timelimit;
                                                } else {
                                                    $all_mobile[] = $admin_mobile_model->username;
                                                }
                                        }

                                        if ($submenu_row->forwarding_type == 1) {
                                            $agent_numbers_submenu[] = @implode('|', $all_mobile);
                                        } else if ($submenu_row->forwarding_type == 2) {
                                            $agent_numbers_submenu[] = @implode(',', $all_mobile);
                                        } else if ($submenu_row->forwarding_type == 3) {//Start Rouond-robin 
                                            //AND extension=1 AND sub_extension=1
                                            $last_connected_submenu_sql = "SELECT * 
										FROM cloud_calling_logs 
										WHERE virtual_number=" . $arg_virtual_number . "
										AND enquiry_flag=1
										AND extension=" . $menu_result['ccm_extension_no'] . "
										AND sub_extension=" . $submenu_row->sub_extension_no . "
										AND call_status='Connected'
										ORDER By id DESC
										LIMIT 0,1";

                                            $last_connected_submenu_row = \common\models\CloudCallingLogsModel::getDb()->createCommand($last_connected_submenu_sql)->queryAll();

                                            $last_connected_submenu_no = $last_connected_submenu_row[0]['call_connected_to'];

                                            if (!empty($all_mobile) && !empty($last_connected_submenu_no))
                                                $all_mobile = $this->roundrobin($all_mobile, $last_connected_submenu_no);

                                            $agent_numbers_submenu[] = @implode(',', $all_mobile);
                                        }//End Rouond-robin 
                                        //$submenu_msg_val.='Press ' . $submenu_row->sub_extension_no . ' for ' . $submenu_row->sub_ext_name . '. ';
                                        //$count_submenu_row++;
                                    }

                                    if ($inactive_flag == 1) {
                                        $extension_welcome_data = array();
                                        for ($i = 0; $i < count($ext_welcome_msg_key); $i++) {
                                            $key = $ext_welcome_msg_key[$i];
                                            $extension_welcome_data[$i][$key] = $ext_welcome_msg_val[$i];
                                        }
                                        $extension_hold_data = array();
                                        for ($i = 0; $i < count($ext_hold_msg_key); $i++) {
                                            $key = $ext_hold_msg_key[$i];
                                            $extension_hold_data[$i][$key] = $ext_hold_msg_val[$i];
                                        }


                                        $regex_submenu1 = @implode('', $regex_submenu);
                                        $submenu_list_val[] = array('ivr_type' => '2', 'extension_number' => $extension_number, 'submenu_noinput' => 'url', 'submenu_nomatch' => 'url', 'regex' => $regex_submenu1, 'subextension_number' => $subextension_number, 'agent_numbers' => $agent_numbers_submenu, 'submenu_insert' => $submenu_insert_submenu, 'subext_welcome_tune' => $extension_welcome_data, 'subext_hold_tune' => $extension_hold_data); //,'bridge_subagent_list'=>$bridge_agent_list_subval
                                        $subivrdata[] = array();
                                    }
                                    //$submenu_list_val[] = array('ivr_type' => '2', 'extension_number' => $extension_number, 'submenu_msg' => $submenu_msg_val, $submenu_hold_msg_key => $submenu_hold_msg_val, 'submenu_noinput' => 'Kindly provide an inpuct_menu_settings.', 'submenu_nomatch' => 'Ohh, Something went wrong. Please enter valid inpuct_menu_settings.', 'regex' => $regex_submenu, 'subextension_number' => $subextension_number, 'agent_numbers' => $agent_numbers_submenu, 'submenu_insert' => $submenu_insert_submenu);
                                }
                            }*/
                        }
                    }
                    if ($virtual_number_row->msc_facility_status == 0 || empty($virtual_number_row->msc_facility_status)) {
                        
                        //$marketing_name_model = ClientsModel::find()->where(['id' => clientid])->one();
                        $marketing_name_model = ClientInfo::where("id",1)->first();
                        $welcome_msg = 'Welcome to ' . $marketing_name_model->marketing_name;


                        $regex1 = @implode('', $regex);
                        if ($calling_type_flag == 2 && $calling_type_has_submenu_flag == 0) {
                            $ivr_data_menu = array($welcome_msg_key => $welcome_msg_val, $menu_hold_msg_key => $menu_hold_msg_val, 'regex' => $regex1, 'extension_numbers' => $extension_numbers, 'has_submenu' => 0, 'sub_ivr_type' => $subivrdata);
                        } else if ($calling_type_flag == 3 && $calling_type_has_submenu_flag == 0) {
                            $ivr_data_menu = array($welcome_msg_key => $welcome_msg_val, $menu_hold_msg_key => $menu_hold_msg_val, 'regex' => $regex1, 'extension_numbers' => $extension_numbers, 'has_submenu' => 0, 'sub_ivr_type' => $subivrdata);
//                        } else if ($calling_type_flag == 2 && $calling_type_has_submenu_flag == 1) {
//                            $ivr_data_menu = array($welcome_msg_key => $welcome_msg_val, $menu_hold_msg_key => $menu_hold_msg_val, 'menu_noinput' => 'url', 'menu_nomatch' => 'url', 'regex' => $regex1, 'extension_numbers' => $extension_numbers, 'has_submenu' => $has_submenu, 'agent_numbers' => $agent_numbers, 'insert_enquiry' => $insert_enquiry);
//                        } else if ($calling_type_flag == 3 && $calling_type_has_submenu_flag == 1) {
//                            $ivr_data_menu = array($welcome_msg_key => $welcome_msg_val, $menu_hold_msg_key => $menu_hold_msg_val, 'menu_noinput' => 'url', 'menu_nomatch' => 'url', 'regex' => $regex1, 'extension_numbers' => $extension_numbers, 'has_submenu' => $has_submenu, 'agent_numbers' => $agent_numbers, 'insert_enquiry' => $insert_enquiry);
                        }
                        
                        $extension_welcome_data = array();
                        if(!empty($ext_welcome_msg_val)){
                        for ($i = 0; $i < count($ext_welcome_msg_key); $i++) {
                            $key = $ext_welcome_msg_key[$i];
                            $extension_welcome_data[$i][$key] = $ext_welcome_msg_val[$i];
                        }
                        }else{
                            $key = $ext_welcome_msg_key[0];
                            $extension_welcome_data[0][$key] = '';
                        }
                        $extension_hold_data = array();
                        if(!empty($ext_hold_msg_val)){
                        for ($i = 0; $i < count($ext_hold_msg_key); $i++) {
                            $key = $ext_hold_msg_key[$i];
                            $extension_hold_data[$i][$key] = $ext_hold_msg_val[$i];
                        }
                        }else{
                            $key = $ext_hold_msg_key[0];
                            $extension_hold_data[0][$key] = '';
                        }

                        $extension_welcome_data1 = array();
                        if(!empty($ext_welcome_msg_val1)){
                        for ($i = 0; $i < count($ext_welcome_msg_key1); $i++) {
                            $key = $ext_welcome_msg_key1[$i];
                            $extension_welcome_data1[$i][$key] = $ext_welcome_msg_val1[$i];
                        }
                        }else{
                            $key = $ext_welcome_msg_key1[0];
                            $extension_welcome_data1[0][$key] = '';
                        }
                        
                        $extension_hold_data1 = array();
                        if(!empty($ext_hold_msg_val1)){
                        for ($i = 0; $i < count($ext_hold_msg_key1); $i++) {
                            $key = $ext_hold_msg_key1[$i];
                            $extension_hold_data1[$i][$key] = $ext_hold_msg_val1[$i];
                        }
                        }else{
                            $key = $ext_hold_msg_key1[0];
                            $extension_hold_data1[0][$key] = '';
                        }


                        
                        if (empty($ivr_type_menu) || $ivr_type_menu == 0) {
                            if ($calling_type_flag == 2 && $calling_type_has_submenu_flag == 0)
                                $ivr_type_menu = 2; //TTS has menu
                            else if ($calling_type_flag == 3 && $calling_type_has_submenu_flag == 0)
                                $ivr_type_menu = 2; //MP3 has menu
//                            else if ($calling_type_flag == 2 && $calling_type_has_submenu_flag == 1)
//                                $ivr_type_menu = 3; //TTS has sub-menu
//                            else if ($calling_type_flag == 3 && $calling_type_has_submenu_flag == 1)
//                                $ivr_type_menu = 3; //MP3 has sub-menu
                        }

                        
                        if ($ivr_type_menu == 2) {
                            $value = array('status' => 'success', 'ivr_type' => $ivr_type_menu, 'ivr_data' => $ivr_data_menu, 'bridge_list' => $bridge_list);
                        } else {
                            $value = array('status' => 'success', 'ivr_type' => $ivr_type_menu, 'ivr_data' => $ivr_data_menu, 'ext_welcome_tune' => $extension_welcome_data1, 'ext_hold_tune' => $extension_hold_data1, 'submenu' => $submenu_list_val, 'sub_ivr_type' => $subivrdata, 'bridge_list' => $bridge_list);
                        }
                    } else if ($virtual_number_row->msc_facility_status == 1) {
                        $insert_enquiry = $virtual_number_row->missed_call_insert_enquiry;
                        if($insert_enquiry == true){
                            $insert_enquiry= 1;
                        }else{
                            $insert_enquiry= 0;
                        }
                        $ivr_data_menu = array($welcome_msg_key => $welcome_msg_val, 'insert_enquiry' => $insert_enquiry);
                        $value = array('status' => 'success', 'ivr_type' => '4', 'ivr_data' => $ivr_data_menu);
                    }
                }

                /*                 * End MP3/TTS Calling Type* */
            }
        }
        
        
        $this->_sendResponse(200, $this->_getObjectEncoded($action, $value));
    }

    function _getObjectEncoded($model, $array) {
        
        return json_encode($array);
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

}
