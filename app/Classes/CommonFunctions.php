<?php

namespace App\Classes;

use DB;
use Auth;
use Mail;
use App\Mail\MailConfig;
use App\Models\MlstBmsbTemplatesDefaults;
use App\Models\TemplatesSetting;
use App\Models\TemplatesCustom;
use App\Modules\EmailConfig\Models\EmailConfiguration;
use App\Models\ClientInfo;
use App\Modules\Projects\Models\Project;
use App\Modules\MasterSales\Models\Customer;
use App\Models\backend\Employee;
use App\Modules\MyStorage\Models\MyStorage;
use App\Modules\MyStorage\Models\StorageFiles;

class CommonFunctions {

    public static function getMacAddress() {
        exec('netstat -ie', $result);
        if (is_array($result)) {
            $iface = array();
            foreach ($result as $key => $line) {
                if ($key > 0) {
                    $tmp = str_replace(" ", "", substr($line, 0, 10));
                    if ($tmp <> "") {
                        $macpos = strpos($line, "HWaddr");
                        if ($macpos !== false) {
                            $iface[] = array('iface' => $tmp, 'mac' => strtolower(substr($line, $macpos + 7, 17)));
                        }
                    }
                }
            }
            return $iface[0]['mac'];
        } else {
            // Turn on output buffering  
            ob_start();
            //Get the ipconfig details using system commond  
            system('ipconfig /all');
            // Capture the output into a variable  
            $mycomsys = ob_get_contents();
            // Clean (erase) the output buffer  
            ob_clean();
            $find_mac = "Physical"; //find the "Physical" & Find the position of Physical text  
            $pmac = strpos($mycomsys, $find_mac);
            // Get Physical Address  
            $macaddress = substr($mycomsys, ($pmac + 36), 17);
            //Display Mac Address  
            return $macaddress;
        }
    }

    public static function insertLoginLog($mobile, $password, $empId, $loginStatus, $loginFailureReason, $platformType) {
        $getMacAddress = CommonFunctions::getMacAddress();
        $loginDateTime = date('Y-m-d h:i:s');
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginMacId = empty($getMacAddress) ? "" : $getMacAddress;
        $ip = $_SERVER['REMOTE_ADDR'];
        $data = \Location::get("175.100.138.136");
        $otherInfoArray = "Country:$data->countryName,State:$data->regionName,City:$data->cityName,Latitude:$data->latitude,Logitude:$data->longitude";
        $otherInfo = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $otherInfoArray);
        DB::select('CALL employees_login_logs(' . $empId . ',"' . $mobile . '","' . $password . '","' . $loginDateTime . '",' . $loginStatus . ',' . $loginFailureReason . ',' . $platformType . ',"' . $loginIP . '","' . $loginBrowser . '","' . $loginMacId . '","' . $otherInfo . '")');
    }

    public static function insertMainTableRecords($loggedInUserId) {
        $getMacAddress = CommonFunctions::getMacAddress();
        $create = ['created_date' => date('Y-m-d'), 'created_by' => $loggedInUserId, 'created_IP' => $_SERVER['REMOTE_ADDR'], 'created_browser' => $_SERVER['HTTP_USER_AGENT'], 'created_mac_id' => $getMacAddress];
        return $create;
    }

    public static function updateMainTableRecords($loggedInUserId) {
        $getMacAddress = CommonFunctions::getMacAddress();
        $create = ['updated_date' => date('Y-m-d'), 'updated_by' => $loggedInUserId, 'updated_IP' => $_SERVER['REMOTE_ADDR'], 'updated_browser' => $_SERVER['HTTP_USER_AGENT'], 'updated_mac_id' => $getMacAddress];
        return $create;
    }

    public static function deleteMainTableRecords($loggedInUserId) {
        $getMacAddress = CommonFunctions::getMacAddress();
        $create = ['deleted_status' => '1', 'deleted_date' => date('Y-m-d'), 'deleted_by' => $loggedInUserId, 'deleted_IP' => $_SERVER['REMOTE_ADDR'], 'deleted_browser' => $_SERVER['HTTP_USER_AGENT'], 'deleted_mac_id' => $getMacAddress];
        return $create;
    }

    public static function checkPlatform() {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (!preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            return true;
        } else
            return false;
    }

    public static function sendMail($userName, $password, $data) {
        try {
            config(['mail.username' => $userName, 'mail.password' => $password]);
            $to = explode(",", $data['to']);
            if (isset($data['cc'])) {
                $data['cc'] = explode(",", $data['cc']);
            }
            if (!empty($data['attachment'])) {
                if (!empty($data['cc']) && !empty($data['bcc'])) {
                    $isSent = Mail::send('layouts.backend.email_template', $data, function ($message) use ($data, $to) {
                                $message->from($data['fromEmail'], $data['fromName']);
                                $message->subject($data['subject']);
                                $message->to($to)->cc($data['cc'])->bcc($data['bcc'])->attach($data['attachment']);
                            });
                } elseif (!empty($data['bcc'])) {
                    $isSent = Mail::send('layouts.backend.email_template', $data, function ($message) use ($data, $to) {
                                $message->from($data['fromEmail'], $data['fromName']);
                                $message->subject($data['subject']);
                                $message->to($to)->bcc($data['bcc'])->attach($data['attachment']);
                            });
                } elseif (!empty($data['cc'])) {
                    $isSent = Mail::send('layouts.backend.email_template', $data, function ($message) use ($data, $to) {
                                $message->from($data['fromEmail'], $data['fromName']);
                                $message->subject($data['subject']);
                                $message->to($to)->cc($data['cc'])->attach($data['attachment']);
                            });
                } else {
                    $isSent = Mail::send('layouts.backend.email_template', $data, function ($message) use ($data, $to) {
                                $message->from($data['fromEmail'], $data['fromName']);
                                $message->subject($data['subject'])->attach($data['attachment']);
                                $message->to($to);
                            });
                }
            } else {
                if (!empty($data['cc']) && !empty($data['bcc'])) {
                    $isSent = Mail::send('layouts.backend.email_template', $data, function ($message) use ($data, $to) {
                                $message->from($data['fromEmail'], $data['fromName']);
                                $message->subject($data['subject']);
                                $message->to($to)->cc($data['cc'])->bcc($data['bcc']);
                            });
                } elseif (!empty($data['bcc'])) {
                    $isSent = Mail::send('layouts.backend.email_template', $data, function ($message) use ($data, $to) {
                                $message->from($data['fromEmail'], $data['fromName']);
                                $message->subject($data['subject']);
                                $message->to($to)->bcc($data['bcc']);
                            });
                } elseif (!empty($data['cc'])) {
                    $isSent = Mail::send('layouts.backend.email_template', $data, function ($message) use ($data, $to) {
                                $message->from($data['fromEmail'], $data['fromName']);
                                $message->subject($data['subject']);
                                $message->to($to)->cc($data['cc']);
                            });
                } else {
                    $isSent = Mail::send('layouts.backend.email_template', $data, function ($message) use ($data, $to) {
                                $message->from($data['fromEmail'], $data['fromName']);
                                $message->subject($data['subject']);
                                $message->to($to);
                            });
                }
            }
            if (count(Mail::failures()) <= 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

    public static function templateData($alertdata) {
        $customer_id = $alertdata['customer_id'];
        $employee_id = $alertdata['employee_id'];
        $client_id = $alertdata['client_id'];
        if (!empty($alertdata['project_id']) && $alertdata['project_id'] != 0) {
            $project_id = $alertdata['project_id'];
        } else {
            $project_id = 0;
        }
        if (!empty($alertdata['frontuserEmailId']) && $alertdata['frontuserEmailId'] !== 0) {
            $frontuserEmail = $alertdata['frontuserEmailId'];
        } else {
            $frontuserEmail = 0;
        }
        if (!empty($alertdata['frontuserMobile']) && $alertdata['frontuserMobile'] !== 0) {
            $frontuserMobile = $alertdata['frontuserMobile'];
        } else {
            $frontuserMobile = 0;
        }
        if (!empty($alertdata['obj_inbound'])) {
            $obj_inbound = $alertdata['obj_inbound'];
        } else {
            $obj_inbound = "";
        }
        $arrExtra = $alertdata['arrExtra'];
        $template_setting_customer = $alertdata['template_setting_customer'];
        $template_setting_employee = $alertdata['template_setting_employee'];

        if (!empty($alertdata['cust_attached_file']))
            $cust_attachedfile = $alertdata['cust_attached_file'];
        else
            $cust_attachedfile = "";

        if (!empty($alertdata['emp_attached_file']))
            $emp_attachedfile = $alertdata['emp_attached_file'];
        else
            $emp_attachedfile = "";
        // $model_id = $alertdata['project_id'];
        $car_image = "https://s3-ap-south-1.amazonaws.com/lms-auto-common/images/car.png";
        $loc_image = "https://s3-ap-south-1.amazonaws.com/lms-auto-common/images/loc2.png";

        if (!empty($customer_id > 0) || !empty($alertdata['frontuserEmailId'])) {
            //$template_settings_customer = TemplatesSetting::where(['client_id' => $client_id, 'templates_event_id' => $eventid_customer, 'template_for' => 1])->first();
            $template_settings_customer = TemplatesSetting::where(['id' => $template_setting_customer])->first();
            if (!empty($template_settings_customer)) {
                if ($template_settings_customer->template_type == 0) {                    // check defualt template = 0 or custom template =1
                    $template_customer = MlstBmsbTemplatesDefaults::where(['id' => $template_settings_customer->default_template_id])->first();
                } else {
                    $template_customer = TemplatesCustom::where(['id' => $template_settings_customer->custom_template_id])->first();
                }
            }
        }

        if (!empty($template_customer)) {
            $cust_email_subject = $template_customer->email_subject;
            $cust_emailTemplate = $template_customer->email_body;
            $cust_smsTemplate = $template_customer->sms_body;
            $email_from_id = $template_settings_customer->from_mail_id;
        } else {
            $cust_emailTemplate = "";
            $cust_smsTemplate = "";
            $email_from_id = "";
        }
        //---- employee  Template ----//
        if (!empty($employee_id > 0)) {
            $template_settings_employee = TemplatesSetting::where(['id' => $template_setting_employee])->first();

            if (!empty($template_settings_employee)) {
                if ($template_settings_employee->template_type == 0) {
                    $template_employee = MlstBmsbTemplatesDefaults::where(['id' => $template_settings_employee->default_template_id])->first();
                } else {
                    $template_employee = TemplatesCustom::where(['id' => $template_settings_employee->custom_template_id])->first();
                }
            }
        }

        if (!empty($template_employee)) {
            $emp_email_subject = $template_employee->email_subject;
            $emp_emailTemplate = $template_employee->email_body;
            $emp_smsTemplate = $template_employee->sms_body;
            $email_from_id = $template_settings_employee->from_mail_id;
        } else {
            $emp_emailTemplate = "";
            $emp_smsTemplate = "";
        }
        // geeting in mail and sms body
        date_default_timezone_set('Asia/Kolkata');
        $h = date('h');
        $a = date('A');

        $greeting_msg = "";
        if ($h >= 05 and $h < 12 and $a == 'AM')
            $greeting_msg = "Good Morning";
        else if (( $h == 12 || $h < 04 ) and $a == 'PM')
            $greeting_msg = "Good Afternoon";
        else if ($h >= 04 and $h < 12 and $a == 'PM')
            $greeting_msg = "Good Evening";

        // ----------- Replace Company and brand tags --------------//
        $client = \App\Models\ClientInfo::where('id', $client_id)->first();

        $companyMarketingName = $companyGoogleMap = $companyAddress = $companyLogo = $brandColor = $brandName = $brandlogo = $displayImage = $employeeName = $employeeMobile = $employeeEmail = $mobile_number = $customerEmail = $customerName = " ";

        if (!empty($project_id) && $project_id <> 0) {
            $project_data = \App\Modules\Projects\Models\Project::where('id', $project_id)->first();
            $project_details = \App\Modules\Projects\Models\ProjectWebPage::where('project_id', $project_id)->first();
        } else {
            //$model_data = \App\Models\MlstLmsaModel::where('brand_id', $client->brand_id)->orderBy('id', 'DESC')->first();            
        }
        if (empty($project_data)) {
            $projectName = "";
            $projectLogo = "";
            $displayImage = "";
        } else {
            $projectName = $project_data->project_name;
            $displayImage = config('global.s3Path') . '/project_images/' . $project_details->project_logo;
            $projectLogo = $project_details->project_logo;
        }
        if (!empty($client->company_logo))
            $companyLogo = config('global.s3Path') . '/client/' . $client_id . '/' . $client->company_logo;
        if (!empty($client->marketing_name))
            $companyMarketingName = ucwords($client->marketing_name);
        $companyGoogleMap = '';
        if (!empty($client->office_addres))
            $companyAddress = $client->office_addres;

        if (!empty($client->pin_code))
            $companyAddress .= $client->pin_code;
        $brandColor = '#054449';

        $search = array('[#companyMarketingName#]', '[#companyGoogleMap#]', '[#companyAddress#]', '[#companyLogo#]', '[#displayImage#]', '[#brandColor#]', '[#projectLogo#]', '[#projectName#]', '[#greeting#]', '[#locimg#]', '[#vehicleimg#]', '[#lmsAuto#]');
        $replace = array($companyMarketingName, '', $companyAddress, $companyLogo, $displayImage, $brandColor, $projectLogo, $projectName, $greeting_msg, $loc_image, $car_image, 'BMS Builder');
        if (!empty($template_employee)) {
            $emp_email_subject = str_replace($search, $replace, $emp_email_subject);
            $emp_emailTemplate = str_replace($search, $replace, $emp_emailTemplate);
            $emp_smsTemplate = str_replace($search, $replace, $emp_smsTemplate);
        }
        if (!empty($template_customer)) {
            $cust_email_subject = str_replace($search, $replace, $cust_email_subject);
            $cust_emailTemplate = str_replace($search, $replace, $cust_emailTemplate);
            $cust_smsTemplate = str_replace($search, $replace, $cust_smsTemplate);
        }
        $sourceName = "";
        $subsourceName = "";
        $sourceDesc = "";
        //start for source and subsource
        if (!empty($obj_inbound)) {
            if (empty($obj_inbound->source_id))
                $sourceName = '';
            else
                $sourceName = $obj_inbound->sourceName->sales_source_name;

            if (empty($obj_inbound->sub_source_id))
                $subsourceName = '';
            else
                $subsourceName = $obj_inbound->subsourceName->enquiry_subsource;

            if (empty($obj_inbound->source_disc))
                $sourceDesc = '';
            else
                $sourceDesc = $obj_inbound->source_disc;
        }


        $search = array('[#enuiqrySource#]', '[#enuiqrySubSource#]', '[#enuiqrySourceDescription#]', '[#nextfollowupDate#]', '[#nextfollowupTime#]');
        $replace = array($sourceName, $subsourceName, $sourceDesc, '', '');

        //end for source and subsource
        if (!empty($template_employee)) {
            $emp_email_subject = str_replace($search, $replace, $emp_email_subject);
            $emp_emailTemplate = str_replace($search, $replace, $emp_emailTemplate);
            $emp_smsTemplate = str_replace($search, $replace, $emp_smsTemplate);
        }
        if (!empty($template_customer)) {
            $cust_email_subject = str_replace($search, $replace, $cust_email_subject);
            $cust_emailTemplate = str_replace($search, $replace, $cust_emailTemplate);
            $cust_smsTemplate = str_replace($search, $replace, $cust_smsTemplate);
        }
        if ($employee_id > 0) {
            // ----------- Replace employee tags --------------//

            $employee = \App\Models\backend\Employee::where('id', $employee_id)->first();

            if (!empty($employee->office_mobile_no)) {
                $employeeMobile = $employee->office_mobile_no;
            } else if (!empty($employee->personal_mobile1)) {
                $employeeMobile = $employee->personal_mobile1;
            }

            if (!empty($employee->first_name))
                $employeeName = ucwords($employee->first_name . ' ' . $employee->last_name);

            $emp_email = '';
            if (!empty($employee->office_email_id) && $employee->office_email_id != 'null') {
                $emp_email = $employee->office_email_id;
            } else if (!empty($employee->personal_email1)) {
                $emp_email = $employee->personal_email1;
            }

            $search = array('[#employeeName#]', '[#employeeMobile#]', '[#employeeEmail#]');
            $replace = array($employeeName, $employeeMobile, $emp_email);
            if (!empty($template_employee)) {
                $emp_email_subject = str_replace($search, $replace, $emp_email_subject);
                $emp_emailTemplate = str_replace($search, $replace, $emp_emailTemplate); //email
                $emp_smsTemplate = str_replace($search, $replace, $emp_smsTemplate); //sms
            }
            if (!empty($template_customer)) {
                $cust_email_subject = str_replace($search, $replace, $cust_email_subject);
                $cust_emailTemplate = str_replace($search, $replace, $cust_emailTemplate); //email
                $cust_smsTemplate = str_replace($search, $replace, $cust_smsTemplate); //sms
            }
        }

        if ($customer_id > 0) {

            $customer_contact = \App\Models\CustomersContact::where('customer_id', $customer_id)->first();

            $customer_data = \App\Modules\Customers\Models\Customers::where('id', $customer_id)->first();
            
            $search = array('[#customerName#]', '[#customerMobile#]', '[#customerEmail#]');

            if (!empty($customer_data->first_name)) {
                $customerName = ucwords($customer_data->first_name . ' ' . $customer_data->last_name);
            } else {
                $customerName = 'Customer';
            }

            if (!empty($customer_contact)) {
                if (!empty($customer_contact->mobile_number)) {
                    $customer_mobile_number = $customer_contact->mobile_number;
                    $customer_mobile_to = $customer_contact->mobile_number;
                }
                if (!empty($alertdata['customer_number'])) {
                    $customer_mobile_to = @implode(',', $alertdata['customer_number']);
                }

                if (!empty($customer_contact->email_id)) {
                    $customerEmail = $customer_contact->email_id;
                    $customer_email_to = $customer_contact->email_id;
                }
                if (!empty($alertdata['customer_email'])) {
                    $customer_email_to = @implode(',', $alertdata['customer_email']);
                }
            }

            if (empty($customer_mobile_number))
                $customer_mobile_number = '';

            if (empty($customerName))
                $customerName = '';

            $replace = array($customerName, $customer_mobile_number);
            if (!empty($template_employee)) {
                $emp_email_subject = str_replace($search, $replace, $emp_email_subject);
                $emp_emailTemplate = str_replace($search, $replace, $emp_emailTemplate);
                $emp_smsTemplate = str_replace($search, $replace, $emp_smsTemplate);
            }
            if (!empty($template_customer)) {
                $cust_email_subject = str_replace($search, $replace, $cust_email_subject);
                $cust_emailTemplate = str_replace($search, $replace, $cust_emailTemplate);
                $cust_smsTemplate = str_replace($search, $replace, $cust_smsTemplate);
            }
        }
        if (!empty($arrExtra[0])) {
            $search = $arrExtra[0];
            $replace = $arrExtra[1];
            if (!empty($template_employee)) {
                $emp_email_subject = str_replace($search, $replace, $emp_email_subject);
                $emp_emailTemplate = str_replace($search, $replace, $emp_emailTemplate); //email
                $emp_smsTemplate = str_replace($search, $replace, $emp_smsTemplate); //sms
            }
            if (!empty($template_customer)) {
                $cust_email_subject = str_replace($search, $replace, $cust_email_subject);
                $cust_emailTemplate = str_replace($search, $replace, $cust_emailTemplate); //email
                $cust_smsTemplate = str_replace($search, $replace, $cust_smsTemplate); //sms
            }
        }

        $emailConfig = EmailConfiguration::where('id', $email_from_id)->first();
        $isInternational = 0; //0 OR 1
        $sendingType = 1; //always 0 for T_SMS
        $smsType = "T_SMS";
        if (!empty($emailConfig->email)) {
            $userName = $emailConfig->email; //$emailConfig->email;
            $password = $emailConfig->password;  //$emailConfig->password;
        } else {
            $userName = '';
            $password = '';
        }
        if (!empty($client->marketing_name)) {
            $companyName = $client->marketing_name;
        } else {
            $companyName = '';
        }
        if (!empty($customer_id > 0)) {
            if (!empty($template_settings_customer)) {
                if ($template_settings_customer->email_status == 1 && !empty($customer_email_to) && $customer_data->email_privacy_status == 1) {
                    $subject = $cust_email_subject;
                    if (!empty($subject)) {
                        $data = ['mailBody' => $cust_emailTemplate, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => $customer_email_to, "cc" => $template_customer->email_cc_ids, "attachment" => $cust_attachedfile];
                        // print_r(array('mailBody' => $cust_emailTemplate, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => $customer_email_to, "cc" => $template_customer->email_cc_ids, "attachment" => $cust_attachedfile));exit;
                        $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
                    }
                }
                if ($template_settings_customer->sms_status == 1 && !empty($customer_mobile_to) && !empty($cust_smsTemplate) && $customer_data->sms_privacy_status == 1 ) {
                    $mobile = $customer_mobile_number;
                    $customer = "Yes";
                    $customerId = $customer_contact->customer_id;
                    // $result = Gupshup::sendSMS($cust_smsTemplate, $customer_mobile_to, $employee_id, $customer, $customerId, $isInternational, $sendingType, $smsType);
                    $result = Gupshup::sendSMS($cust_smsTemplate, $customer_mobile_to, $employee_id, $customer, $customerId, $isInternational, $sendingType, $smsType);
                }
            }
        } else {
            if ($frontuserEmail !== 0) {
                $subject = $cust_email_subject;
                $data = ['mailBody' => $cust_emailTemplate, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => $frontuserEmail, "cc" => $template_customer->email_cc_ids, "attachment" => $cust_attachedfile];
                $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
            }
            if ($frontuserMobile !== 0) {
                $customer = "Yes";
                $mobile = $frontuserMobile;
                $customerId = 0;
                $result = Gupshup::sendSMS($cust_smsTemplate, $frontuserMobile, $employee_id, $customer, $customerId, $isInternational, $sendingType, $smsType);
            }
        }
        if (!empty($employee_id > 0)) {            
            if (!empty($alertdata['emp_cc']) && !empty($template_employee->email_cc_ids)) {
                $template_employee->email_cc_ids = $template_employee->email_cc_ids . ',' . $alertdata['emp_cc'];
            } elseif (empty($template_employee->email_cc_ids) && !empty($alertdata['emp_cc'])) {                
                $template_employee->email_cc_ids = $alertdata['emp_cc'];                
            }
            
            if (!empty($template_settings_employee)) {
                if ($template_settings_employee->email_status == 1 || !empty($alertdata['email_status'])) {
                    $subject = $emp_email_subject;
                    $data = ['mailBody' => $emp_emailTemplate, "fromEmail" => $userName, "fromName" => $companyName, "subject" => $subject, "to" => $emp_email, "cc" => $template_employee->email_cc_ids, "attachment" => $emp_attachedfile];
                    $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
                }
                if ($template_settings_employee->sms_status == 1 || !empty($alertdata['sms_status'])) {
                    if (!empty($alertdata['emp_sms_cc'])) {
                        $mobile = $employeeMobile . ',' . $alertdata['emp_sms_cc'];
                    } else {
                        $mobile = $employeeMobile;
                    }
                    $customer = "No";
                    $customerId = 0;
                    $result = Gupshup::sendSMS($emp_smsTemplate, $mobile, $employee_id, $customer, $customerId, $isInternational, $sendingType, $smsType);
                }
            }
            
        }
        return true;
    }

    public static function texttemplateData($alertdata, $obj_api, $request) {
        $emailConfig = EmailConfiguration::where('id', 1)->first();
        $isInternational = 0;
        $sendingType = 1;
        $smsType = "T_SMS";
        $client_id = $alertdata['client_id'];
        $client = \App\Models\ClientInfo::where('id', $client_id)->first();
        if (!empty($client->project_id)) {
            $project = Project::where('id', $client->project_id)->first();
        }
        $companyMarketingName = $companyGoogleMap = $companyAddress = $companyLogo = $brandColor = $displayImage = $employeeName = $employeeMobile = $employeeEmail = $mobile_number = $customerEmail = $customerName = " ";

        if (!empty($client->company_logo))
            $companyLogo = config('global.s3Path') . '/client/' . $client_id . '/' . $client->company_logo;

        if (!empty($client->marketing_name))
            $companyMarketingName = ucwords($client->marketing_name);

        $companyGoogleMap = '';
        if (!empty($client->office_addres))
            $companyAddress = $client->office_addres;

        if (!empty($client->pin_code))
            $companyAddress .= $client->pin_code;

        if (!empty($client->website)) {
            $website = $client->website;
        } else {
            $website = '';
        }

        array_push($alertdata['arrExtra']['1'], $companyLogo);
        array_push($alertdata['arrExtra']['1'], $companyMarketingName);
        array_push($alertdata['arrExtra']['1'], $companyAddress);
        array_push($alertdata['arrExtra']['1'], $website);

        if ($alertdata['customer_status'] == '1' && $obj_api['send_email_customer'] == 1) {

            $cust_emailTemplate = $obj_api['customer_email_template'];

            $search = $alertdata['arrExtra']['0'];
            $replace = $alertdata['arrExtra']['1'];

            $cust_emailTemplate = str_replace($search, $replace, $cust_emailTemplate);
            if (!empty($emailConfig->email)) {
                $userName = $emailConfig->email; //$emailConfig->email;
                $password = $emailConfig->password;  //$emailConfig->password;
            } else {
                $userName = '';
                $password = '';
            }
            $data = ['mailBody' => $cust_emailTemplate, "fromEmail" => $userName, "fromName" => "", "subject" => $obj_api->customer_email_subject_line, "to" => str_replace(' ', '', $request['email_id']), 'cc' => str_replace(' ', '', $obj_api['customer_email_cc']), 'bcc' => str_replace(' ', '', $obj_api['customer_email_bcc'])];
            $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
        }
        if ($alertdata['employee_status'] == '1' && $obj_api['send_sms_employee'] == 1) {
            $empl_emailTemplate = $obj_api['employee_email_template'];
            $search = $alertdata['arrExtra']['0'];
            $replace = $alertdata['arrExtra']['1'];
            $empl_emailTemplate = str_replace($search, $replace, $empl_emailTemplate);
            if (!empty($emailConfig->email)) {
                $userName = $emailConfig->email; // $emailConfig->email;
                $password = $emailConfig->password;  // $emailConfig->password;
            } else {
                $userName = '';
                $password = '';
            }

            $data = ['mailBody' => $empl_emailTemplate, "fromEmail" => $userName, "fromName" => "", "subject" => $obj_api->employee_email_subject_line, "to" => str_replace(' ', '', $alertdata['employee_email']), 'cc' => str_replace(' ', '', $obj_api['employee_email_cc']), 'bcc' => str_replace(' ', '', $obj_api['employee_email_bcc'])];
            $sentSuccessfully = CommonFunctions::sendMail($userName, $password, $data);
        }
        if ($alertdata['customer_status'] == 1 && $obj_api['send_sms_customer'] == 1) {
            $search = $alertdata['arrExtra']['0'];
            $replace = $alertdata['arrExtra']['1'];
            $customer_smsTemplate = str_replace($search, $replace, $obj_api['customer_sms_template']);
            $customerId = 0;
            if (!empty($obj_api['customer_sms_cc_numbers'])) {
                $customer_mobno = $request['mobile_no'] . "," . $obj_api['customer_sms_cc_numbers'];
            } else {
                $customer_mobno = $request['mobile_no'];
            }
            $result = Gupshup::sendSMS($customer_smsTemplate, $customer_mobno, $alertdata['employee_id'], $request, $customerId, $isInternational, $sendingType, $smsType);
        }
        if ($alertdata['employee_status'] == 1 && $obj_api['send_sms_employee'] == 1) {
            if (!empty($obj_api['employee_sms_cc_numbers'])) {
                $employee_mobno = $alertdata['employee_mobno'] . "," . $obj_api['employee_sms_cc_numbers'];
            } else {
                $employee_mobno = $alertdata['employee_mobno'];
            }
            $employee_smsTemplate = str_replace($search, $replace, $obj_api['employee_sms_template']);
            $customerId = 0;
            $result = Gupshup::sendSMS($employee_smsTemplate, $employee_mobno, $alertdata['employee_id'], $request, $customerId, $isInternational, $sendingType, $smsType);
        }
    }

    public static function saveImages($folderName, $imageName) {
        $loggedInUserId = Auth::guard('admin')->user()->id;
        $folderAvail = MyStorage::where('folder', '=', $folderName)->select('id')->first();
        if (empty($folderAvail)) {
            $folderPost = ['folder' => $folderName];
            $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
            $input['folderData'] = array_merge($folderPost, $create);
            MyStorage::create($input['folderData']);
            $folderAvail = MyStorage::latest('id')->first();
        }
        $post = ['storage_id' => $folderAvail->id, 'file_name' => $imageName, 'file_url' => $folderName . "/" . $imageName];
        $create = CommonFunctions::insertMainTableRecords($loggedInUserId);
        $input['imageData'] = array_merge($post, $create);
        $create = StorageFiles::create($input['imageData']);
        return $create;
    }

}
