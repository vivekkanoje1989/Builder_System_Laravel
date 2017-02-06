<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeesLoginLog
 * 
 * @property int $id
 * @property int $client_id
 * @property int $employee_id
 * @property string $username_entered
 * @property string $password_entered
 * @property \Carbon\Carbon $login_date_time
 * @property int $login_status
 * @property int $login_failure_reason
 * @property int $bms_app_type
 * @property string $login_IP
 * @property string $login_browser
 * @property string $login_mac_id
 * @property string $other_info
 *
 * @package App\Models
 */
class EmployeesLoginLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'employee_id' => 'int',
		'login_status' => 'int',
		'login_failure_reason' => 'int',
		'bms_app_type' => 'int'
	];

	protected $dates = [
		'login_date_time'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'username_entered',
		'password_entered',
		'login_date_time',
		'login_status',
		'login_failure_reason',
		'bms_app_type',
		'login_IP',
		'login_browser',
		'login_mac_id',
		'other_info'
	];
}
