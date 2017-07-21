<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CtLogsInbound
 * 
 * @property int $id
 * @property int $client_id
 * @property int $virtual_number
 * @property int $source_id
 * @property int $sub_source_id
 * @property string $source_disc
 * @property \Carbon\Carbon $call_date
 * @property \Carbon\Carbon $call_time
 * @property int $customer_number
 * @property string $customer_circle
 * @property string $customer_operator
 * @property string $customer_call_status
 * @property int $customer_hangup_cause
 * @property \Carbon\Carbon $customer_call_duration
 * @property float $customer_call_rate
 * @property float $customer_call_bill
 * @property int $extension_number
 * @property string $employee_list
 * @property int $employee_id
 * @property int $employee_number
 * @property string $employee_circle
 * @property string $employee_operator
 * @property \Carbon\Carbon $employee_call_duration
 * @property float $employee_call_rate
 * @property float $employee_call_bill
 * @property string $employee_call_status
 * @property int $employee_hangup_cause
 * @property int $enquiry_flag
 * @property int $bridge_employee_id
 * @property int $bridge_employee_number
 * @property \Carbon\Carbon $bridge_call_duration
 * @property float $bridge_call_rate
 * @property float $bridge_call_bill
 * @property string $call_log_push_url
 * @property \Carbon\Carbon $call_push_url_date_time
 * @property int $call_recording_url_status
 * @property string $call_recording_url
 * @property \Carbon\Carbon $total_call_duration
 * @property float $total_call_bill
 *
 * @package App\Models
 */
class CtLogsInbound extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'virtual_number' => 'int',
		'source_id' => 'int',
		'sub_source_id' => 'int',
		'customer_number' => 'int',
		'customer_hangup_cause' => 'int',
		'customer_call_rate' => 'float',
		'customer_call_bill' => 'float',
		'extension_number' => 'int',
		'employee_id' => 'int',
		'employee_number' => 'int',
		'employee_call_rate' => 'float',
		'employee_call_bill' => 'float',
		'employee_hangup_cause' => 'int',
		'enquiry_flag' => 'int',
		'bridge_employee_id' => 'int',
		'bridge_call_rate' => 'float',
		'bridge_call_bill' => 'float',
		'call_recording_url_status' => 'int',
		'total_call_bill' => 'float'
	];

	protected $dates = [
		//'call_date',
		//'call_time',
		//'customer_call_duration',
		//'employee_call_duration',
		//'bridge_call_duration',
		//'call_push_url_date_time',
		//'total_call_duration'
	];

	protected $fillable = [
		'client_id',
		'virtual_number',
		'source_id',
		'sub_source_id',
		'source_disc',
		'call_date',
		'call_time',
		'customer_number',
		'customer_circle',
		'customer_operator',
		'customer_call_status',
		'customer_hangup_cause',
		'customer_call_duration',
		'customer_call_rate',
		'customer_call_bill',
		'extension_number',
		'employee_list',
		'employee_id',
		'employee_number',
		'employee_circle',
		'employee_operator',
		'employee_call_duration',
		'employee_call_rate',
		'employee_call_bill',
		'employee_call_status',
		'employee_hangup_cause',
		'enquiry_flag',
		'bridge_employee_id',
		'bridge_employee_number',
		'bridge_call_duration',
		'bridge_call_rate',
		'bridge_call_bill',
		'call_log_push_url',
		'call_push_url_date_time',
		'call_recording_url_status',
		'call_recording_url',
		'total_call_duration',
		'total_call_bill'
	];
}
