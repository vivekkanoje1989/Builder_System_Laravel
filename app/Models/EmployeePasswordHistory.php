<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeePasswordHistory
 * 
 * @property int $id
 * @property int $client_id
 * @property int $employee_id
 * @property int $username
 * @property string $password
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_time
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_mac_id
 * @property int $status
 *
 * @package App\Models
 */
class EmployeePasswordHistory extends Eloquent
{
	protected $table = 'employee_password_history';
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'employee_id' => 'int',
		'username' => 'int',
		'created_by' => 'int',
		'status' => 'int'
	];

	protected $dates = [
		'created_date',
		'created_time'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'username',
		'password',
		'created_date',
		'created_time',
		'created_by',
		'created_IP',
		'created_mac_id',
		'status'
	];
}
