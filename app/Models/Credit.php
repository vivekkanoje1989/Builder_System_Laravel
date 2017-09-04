<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 13 Mar 2017 12:50:28 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Credit
 * 
 * @property int $id
 * @property int $sms_credits
 * @property int $email_credits
 * @property int $sms_consumption
 * @property float $cost_per_sms
 * @property int $sms_credit_limit
 * @property int $sms_status
 * @property int $email_consumption
 * @property float $cost_per_email
 * @property int $email_credit_limit
 * @property int $email_status
 *
 * @package App\Models
 */
class Credit extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'sms_credits' => 'int',
		'email_credits' => 'int',
		'sms_consumption' => 'int',
		'cost_per_sms' => 'float',
		'sms_credit_limit' => 'int',
		'sms_status' => 'int',
		'email_consumption' => 'int',
		'cost_per_email' => 'float',
		'email_credit_limit' => 'int',
		'email_status' => 'int'
	];

	protected $fillable = [
		'sms_credits',
		'email_credits',
		'sms_consumption',
		'cost_per_sms',
		'sms_credit_limit',
		'sms_status',
		'email_consumption',
		'cost_per_email',
		'email_credit_limit',
		'email_status'
	];
}
