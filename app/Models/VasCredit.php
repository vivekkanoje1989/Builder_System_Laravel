<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 27 Mar 2017 11:05:20 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class VasCredit
 * 
 * @property int $id
 * @property int $sms_credit_limit
 * @property float $cost_per_sms
 * @property int $sms_status
 * @property int $email_credit_limit
 * @property float $cost_per_email
 * @property int $email_status
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
class VasCredit extends Eloquent
{
	protected $casts = [
		'sms_credit_limit' => 'int',
		'cost_per_sms' => 'float',
		'sms_status' => 'int',
		'email_credit_limit' => 'int',
		'cost_per_email' => 'float',
		'email_status' => 'int',
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
		'sms_credit_limit',
		'cost_per_sms',
		'sms_status',
		'email_credit_limit',
		'cost_per_email',
		'email_status',
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
