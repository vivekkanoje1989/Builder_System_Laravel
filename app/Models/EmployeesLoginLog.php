<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeesLoginLog
 * 
 * @property int $id
 * @property int $employee_id
 * @property \Carbon\Carbon $login_date_time
 * @property int $login_status
 * @property int $login_failure_reason
 * @property string $login_IP
 * @property string $login_browser
 * @property string $login_mac_id
 *
 * @package App\Models
 */
class EmployeesLoginLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'employee_id' => 'int',
		'login_status' => 'int',
		'login_failure_reason' => 'int'
	];

	protected $dates = [
		'login_date_time'
	];

	protected $fillable = [
		'employee_id',
		'login_date_time',
		'login_status',
		'login_failure_reason',
		'login_IP',
		'login_browser',
		'login_mac_id'
	];
}
