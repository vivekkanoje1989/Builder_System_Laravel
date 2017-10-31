<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 17 Jul 2017 12:58:42 +0530.
 */

namespace App\Modules\Api\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PushApiSettingsLog
 * 
 * @property int $id
 * @property int $main_record_id
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
 * @property int $record_type
 * @property string $column_names
 * @property int $record_restore_status
 *
 * @package App\Models
 */
class PushApiSettingsLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'main_record_id' => 'int',
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
		'record_type' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		//'created_date'
	];

	protected $fillable = [
		'main_record_id',
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
		'pdf_name',
		'status',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'record_type',
		'column_names',
		'record_restore_status'
	];
}
