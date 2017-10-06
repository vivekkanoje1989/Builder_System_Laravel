<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 15 Mar 2017 16:21:40 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmailLog
 * 
 * @property int $id
 * @property int $am_uid
 * @property string $client_id
 * @property string $client_type
 * @property string $externalId1
 * @property \Carbon\Carbon $sent_date_time
 * @property string $mail_id
 * @property string $mail_body
 * @property string $customer_mail
 * @property int $customer_id
 * @property int $bulk_mail
 * @property string $bulk_file_id
 * @property string $mail_type
 * @property string $status
 * @property int $credits_deducted
 * @property string $api_username
 * @property string $request_url
 * @property int $log_status
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 *
 * @package App\Models
 */
class EmailLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'am_uid' => 'int',
		'customer_id' => 'int',
		'bulk_mail' => 'int',
		'credits_deducted' => 'int',
		'log_status' => 'int',
		'created_by' => 'int'
	];

	protected $dates = [
		'sent_date_time',
		'created_date'
	];

	protected $fillable = [
		'am_uid',
		'client_id',
		'client_type',
		'externalId1',
		'sent_date_time',
		'mail_id',
		'mail_body',
		'customer_mail',
		'customer_id',
		'bulk_mail',
		'bulk_file_id',
		'mail_type',
		'status',
		'credits_deducted',
		'api_username',
		'request_url',
		'log_status',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id'
	];
}
