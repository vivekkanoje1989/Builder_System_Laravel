<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TemplatesSetting
 * 
 * @property int $id
 * @property int $client_id
 * @property int $sr_no
 * @property int $template_type
 * @property int $template_category
 * @property int $default_template_id
 * @property int $custom_template_id
 * @property int $from_mail_id
 * @property int $sms_cc_employees
 * @property string $sms_cc_numbers
 * @property int $email_cc_employees
 * @property string $email_cc_ids
 * @property int $email_bcc_employees
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
 * @property \Carbon\Carbon $updated_date
 * @property \Carbon\Carbon $updated_at
 * @property int $updated_by
 * @property string $updated_IP
 * @property string $updated_browser
 * @property string $updated_mac_id
 *
 * @package App\Models
 */
class TemplatesSetting extends Eloquent
{
	protected $casts = [
		'client_id' => 'int',
		'sr_no' => 'int',
		'template_type' => 'int',
		'template_category' => 'int',
		'default_template_id' => 'int',
		'custom_template_id' => 'int',
		'from_mail_id' => 'int',
		'sms_cc_employees' => 'int',
		'email_cc_employees' => 'int',
		'email_bcc_employees' => 'int',
		'sms_status' => 'int',
		'email_status' => 'int',
		'status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
		'sr_no',
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
		'updated_date',
		'updated_by',
		'updated_IP',
		'updated_browser',
		'updated_mac_id'
	];
}
