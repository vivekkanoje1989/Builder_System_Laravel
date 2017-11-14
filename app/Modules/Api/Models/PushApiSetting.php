<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Jul 2017 12:56:36 +0530.
 */

namespace App\Modules\Api\Models;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PushApiSetting
 * 
 * @property int $id
 * @property string $api_name
 * @property string $key
 * @property string $employee_id
 * @property string $error_notification_email
 * @property int $first_name_mandatory
 * @property int $last_name_mandatory
 * @property int $mobile_number_mandatory
 * @property int $email_id_mandatory
 * @property int $existing_open_customer_action
 * @property int $existing_lost_customer_action
 * @property int $set_enquiry_categeory
 * @property int $send_sms_customer
 * @property int $send_email_customer
 * @property int $send_sms_employee
 * @property int $send_email_employee
 * @property int $dial_outbound_call
 * @property int $mobile_verification
 * @property int $email_verification
 * @property string $customer_sms_template
 * @property string $customer_sms_cc_numbers
 * @property string $employee_sms_template
 * @property string $employee_sms_cc_numbers
 * @property string $customer_email_template
 * @property string $customer_email_subject_line
 * @property string $customer_email_cc
 * @property string $customer_email_bcc
 * @property int $from_email_id
 * @property string $employee_email_template
 * @property string $employee_email_subject_line
 * @property string $employee_email_cc
 * @property string $employee_email_bcc
 * @property string $pdf_name
 * @property int $status
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property \Carbon\Carbon $updated_date
 * @property \Carbon\Carbon $updated_at
 * @property int $updated_by
 * @property string $updated_IP
 * @property string $updated_browser
 * @property string $updated_mac_id
 * @property int $deleted_status
 * @property \Carbon\Carbon $deleted_date
 * @property int $deleted_by
 * @property int $deleted_IP
 * @property int $deleted_browser
 * @property int $deleted_mac_id
 *
 * @package App\Models
 */
class PushApiSetting extends Eloquent {

    protected $casts = [
        'first_name_mandatory' => 'int',
        'last_name_mandatory' => 'int',
        'mobile_number_mandatory' => 'int',
        'email_id_mandatory' => 'int',
        'existing_open_customer_action' => 'int',
        'existing_lost_customer_action' => 'int',
        'set_enquiry_categeory' => 'int',
        'send_sms_customer' => 'int',
        'send_email_customer' => 'int',
        'send_sms_employee' => 'int',
        'send_email_employee' => 'int',
        'dial_outbound_call' => 'int',
        'mobile_verification' => 'int',
        'email_verification' => 'int',
        'from_email_id' => 'int',
        'status' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_status' => 'int',
        'deleted_by' => 'int',
        'deleted_IP' => 'int',
        'deleted_browser' => 'int',
        'deleted_mac_id' => 'int'
    ];
    protected $dates = [
            //'created_date',
            //'updated_date',
            //'deleted_date'
    ];
    protected $fillable = [
        'api_name',
        'key',
        'employee_id',
        'error_notification_email',
        'first_name_mandatory',
        'last_name_mandatory',
        'mobile_number_mandatory',
        'email_id_mandatory',
        'existing_open_customer_action',
        'existing_lost_customer_action',
        'set_enquiry_categeory',
        'send_sms_customer',
        'send_email_customer',
        'send_sms_employee',
        'send_email_employee',
        'dial_outbound_call',
        'mobile_verification',
        'email_verification',
        'customer_sms_template',
        'customer_sms_cc_numbers',
        'employee_sms_template',
        'employee_sms_cc_numbers',
        'customer_email_template',
        'customer_email_subject_line',
        'customer_email_cc',
        'customer_email_bcc',
        'from_email_id',
        'employee_email_template',
        'employee_email_subject_line',
        'employee_email_cc',
        'employee_email_bcc',
        'set_enquiry_status',
        'pdf_name',
        'status',
        'created_date',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_by',
        'updated_IP',
        'updated_browser',
        'updated_mac_id',
        'deleted_status',
        'deleted_date',
        'deleted_by',
        'deleted_IP',
        'deleted_browser',
        'deleted_mac_id'
    ];

    public static function doAction($obj_customer, $obj_employee, $source_id, $source_desc, $sub_source, $obj_api, $remark, $status = 0) {
        $input['enquiryData']['sales_enquiry_date'] = date('Y-m-d');
        $input['enquiryData']['updated_date'] = date("Y-m-d h:i:s");
        $input['enquiryData']['client_id'] = 1;
        $input['enquiryData']['sales_source_id'] = $source_id;
        $input['enquiryData']['customer_id'] = $obj_customer->id;
        $input['enquiryData']['sales_employee_id'] = $obj_employee['id'];
        $input['enquiryData']['sales_source_description'] = $source_desc;
        $input['enquiryData']['sales_subsource_id'] = $sub_source;
        $input['enquiryData']['sales_status_id'] = 1;
        $input['followupData']['followup_date_time'] = date("Y-m-d h:i:s");
        $input['followupData']['created_date'] = date("Y-m-d");
        $input['followupData']['followup_by_employee_id'] = $obj_employee->employee_id;
        $input['followupData']['next_followup_date'] = date('Y-m-d');
        $input['followupData']['next_followup_time'] = date("h:i:s");
        $input['followupData']['actual_followup_date_time'] = date("Y-m-d h:i:s");
        $input['followupData']['followup_entered_through'] = '4';
        if ($status == 0) {
            $followups_remark = 'Enquiry Added Through ';
        } else {
            $followups_remark = 'Followup Updated Through';
        }
        if (!empty($remark)) {
            $input['followupData']['remarks'] = $followups_remark . $obj_api->api_name . ' API. Customer message:- ' . $remark;
        }else{
            $input['followupData']['remarks'] = $followups_remark . $obj_api->api_name . ' API';
        }

        return $input;
    }
}
