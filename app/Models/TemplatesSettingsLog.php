<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 10 Apr 2017 12:26:31 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TemplatesSettingsLog
 * 
 * @property int $id
 * @property int $client_id
 * @property int $template_settings_id
 * @property int $templates_event_id
 * @property int $sr_no
 * @property int $template_for
 * @property int $template_type
 * @property int $template_category
 * @property int $default_template_id
 * @property int $custom_template_id
 * @property int $from_mail_id
 * @property string $sms_cc_employees
 * @property string $sms_cc_numbers
 * @property string $email_cc_employees
 * @property string $email_cc_ids
 * @property string $email_bcc_employees
 * @property string $email_bcc_ids
 * @property int $sms_status
 * @property int $email_status
 * @property string $submenu_ids
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
class TemplatesSettingsLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'template_settings_id' => 'int',
		'templates_event_id' => 'int',
		'sr_no' => 'int',
		'template_for' => 'int',
		'template_type' => 'int',
		'template_category' => 'int',
		'default_template_id' => 'int',
		'custom_template_id' => 'int',
		'from_mail_id' => 'int',
		'sms_status' => 'int',
		'email_status' => 'int',
		'status' => 'int',
		'created_by' => 'int',
		'record_type' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		'created_date'
	];

	protected $fillable = [
		'client_id',
		'template_settings_id',
		'templates_event_id',
		'sr_no',
		'template_for',
		'template_type',
		'template_category',
		'default_template_id',
		'custom_template_id',
		'from_mail_id',
		'sms_cc_employees',
		'sms_cc_numbers',
		'email_cc_employees',
		'email_cc_ids',
		'email_bcc_employees',
		'email_bcc_ids',
		'sms_status',
		'email_status',
		'submenu_ids',
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
