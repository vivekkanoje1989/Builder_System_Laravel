<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 31 Mar 2017 16:22:36 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Project
 * 
 * @property int $id
 * @property int $project_name
 * @property string $project_punch_line
 * @property int $project_type_id
 * @property int $project_status
 * @property string $pre_sales_employees
 * @property string $post_sales_employees
 * @property string $authorities_employees
 * @property int $project_head_employee
 * @property string $accountant_employees
 * @property string $receipt_html_code
 * @property int $receipt_tax_heading_status
 * @property string $booking_html_code
 * @property string $demand_letter_html_code
 * @property int $demand_letter_tax_heading_status
 * @property string $welcome_file
 * @property int $sms_sender_id
 * @property int $email_sending_id
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
class Project extends Eloquent
{
	protected $casts = [
		'project_type_id' => 'int',
		'project_status' => 'int',
		'project_head_employee' => 'int',
		'receipt_tax_heading_status' => 'int',
		'demand_letter_tax_heading_status' => 'int',
		'sms_sender_id' => 'int',
		'email_sending_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int',
		'deleted_IP' => 'int',
		'deleted_browser' => 'int',
		'deleted_mac_id' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date',
		'deleted_date'
	];

	protected $fillable = [
		'project_name',
		'project_punch_line',
		'project_type_id',
		'project_status',
		'pre_sales_employees',
		'post_sales_employees',
		'authorities_employees',
		'project_head_employee',
		'accountant_employees',
		'receipt_html_code',
		'receipt_tax_heading_status',
		'booking_html_code',
		'demand_letter_html_code',
		'demand_letter_tax_heading_status',
		'welcome_file',
		'sms_sender_id',
		'email_sending_id',
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
}
