<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 13 Mar 2017 14:32:19 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SmsLog
 * 
 * @property int $id
 * @property int $employee_id
 * @property string $client_id
 * @property string $client_type
 * @property string $externalId1
 * @property string $externalId2
 * @property string $deliveredTS
 * @property \Carbon\Carbon $sent_date_time
 * @property string $mobile_number
 * @property string $sms_body
 * @property string $customer_sms
 * @property int $customer_id
 * @property string $bulk_sms
 * @property string $bulk_file_id
 * @property string $sms_type
 * @property int $sms_sending_type
 * @property string $status
 * @property string $delivered_status
 * @property string $cause
 * @property string $request_url
 * @property int $log_status
 * @property string $transaction1
 * @property string $transaction2
 * @property int $credits_deducted
 * @property string $api_username
 * @property \Carbon\Carbon $updated_datetime
 * @property int $is_international
 *
 * @package App\Models
 */
class SmsLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'employee_id' => 'int',
		'customer_id' => 'int',
		'sms_sending_type' => 'int',
		'log_status' => 'int',
		'credits_deducted' => 'int',
		'is_international' => 'int'
	];

	protected $dates = [
		'sent_date_time',
		'updated_datetime'
	];

	protected $fillable = [
		'employee_id',
		'client_id',
		'client_type',
		'externalId1',
		'externalId2',
		'deliveredTS',
		'sent_date_time',
		'mobile_number',
		'sms_body',
		'customer_sms',
		'customer_id',
		'bulk_sms',
		'bulk_file_id',
		'sms_type',
		'sms_sending_type',
		'status',
		'delivered_status',
		'cause',
		'request_url',
		'log_status',
		'transaction1',
		'transaction2',
		'credits_deducted',
		'api_username',
		'updated_datetime',
		'is_international'
	];
}
