<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CtLogsOutbound
 * 
 * @property int $id
 * @property int $client_id
 * @property int $caller_id
 * @property int $enquiry_id
 * @property int $employee_id
 * @property int $employee_number
 * @property string $employee_circule
 * @property string $employee_operator
 * @property \Carbon\Carbon $call_date
 * @property \Carbon\Carbon $call_time
 * @property string $employee_call_status
 * @property int $employee_hangup_cause
 * @property \Carbon\Carbon $employee_call_duration
 * @property float $employee_call_rate
 * @property float $employee_call_bill
 * @property int $call_requesting_media
 * @property int $customer_id
 * @property int $customer_number
 * @property string $customer_circule
 * @property string $customer_operator
 * @property string $customer_call_status
 * @property int $customer_hangup_cause
 * @property \Carbon\Carbon $customer_call_duration
 * @property float $customer_call_rate
 * @property float $customer_call_bill
 * @property \Carbon\Carbon $total_call_duration
 * @property float $total_call_bill
 * @property int $sip_status
 * @property string $call_uuid
 * @property string $call_request_url
 * @property string $call_log_push_url
 * @property \Carbon\Carbon $call_push_url_date_time
 * @property string $call_recording_url
 *
 * @package App\Models
 */
class CtLogsOutbound extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'caller_id' => 'int',
		'enquiry_id' => 'int',
		'employee_id' => 'int',
		'employee_number' => 'int',
		'employee_hangup_cause' => 'int',
		'employee_call_rate' => 'float',
		'employee_call_bill' => 'float',
		'call_requesting_media' => 'int',
		'customer_id' => 'int',
		'customer_number' => 'int',
		'customer_hangup_cause' => 'int',
		'customer_call_rate' => 'float',
		'customer_call_bill' => 'float',
		'total_call_bill' => 'float',
		'sip_status' => 'int'
	];

	protected $dates = [
		'call_date',
		'call_time',
		'employee_call_duration',
		'customer_call_duration',
		'total_call_duration',
		'call_push_url_date_time'
	];

	protected $fillable = [
		'client_id',
		'caller_id',
		'enquiry_id',
		'employee_id',
		'employee_number',
		'employee_circule',
		'employee_operator',
		'call_date',
		'call_time',
		'employee_call_status',
		'employee_hangup_cause',
		'employee_call_duration',
		'employee_call_rate',
		'employee_call_bill',
		'call_requesting_media',
		'customer_id',
		'customer_number',
		'customer_circule',
		'customer_operator',
		'customer_call_status',
		'customer_hangup_cause',
		'customer_call_duration',
		'customer_call_rate',
		'customer_call_bill',
		'total_call_duration',
		'total_call_bill',
		'sip_status',
		'call_uuid',
		'call_request_url',
		'call_log_push_url',
		'call_push_url_date_time',
		'call_recording_url'
	];
}
