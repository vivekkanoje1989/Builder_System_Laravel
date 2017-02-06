<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeAttendence
 * 
 * @property int $id
 * @property int $client_id
 * @property int $employee_id
 * @property \Carbon\Carbon $attendence_date
 * @property \Carbon\Carbon $attendence_time
 * @property int $office_location_id
 * @property int $employee_code
 * @property int $record_status
 *
 * @package App\Models
 */
class EmployeeAttendence extends Eloquent
{
	protected $table = 'employee_attendence';
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'employee_id' => 'int',
		'office_location_id' => 'int',
		'employee_code' => 'int',
		'record_status' => 'int'
	];

	protected $dates = [
		'attendence_date',
		'attendence_time'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'attendence_date',
		'attendence_time',
		'office_location_id',
		'employee_code',
		'record_status'
	];
}
