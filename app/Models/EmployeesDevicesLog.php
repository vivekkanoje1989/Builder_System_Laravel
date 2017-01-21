<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeesDevicesLog
 * 
 * @property int $id
 * @property int $employee_id
 * @property string $device_name
 * @property string $device_mac
 * @property int $device_type
 * @property string $device_description
 * @property string $remarks
 * @property int $device_status
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_time
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property \Carbon\Carbon $updated_date
 * @property \Carbon\Carbon $updated_time
 * @property int $updated_by
 * @property string $updated_IP
 * @property string $updated_browser
 * @property string $updated_mac_id
 * @property int $record_type
 * @property int $column_names
 * @property int $record_restore_status
 *
 * @package App\Models
 */
class EmployeesDevicesLog extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'employee_id' => 'int',
		'device_type' => 'int',
		'device_status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'record_type' => 'int',
		'column_names' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		'created_date',
		'created_time',
		'updated_date',
		'updated_time'
	];

	protected $fillable = [
		'employee_id',
		'device_name',
		'device_mac',
		'device_type',
		'device_description',
		'remarks',
		'device_status',
		'created_date',
		'created_time',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'updated_date',
		'updated_time',
		'updated_by',
		'updated_IP',
		'updated_browser',
		'updated_mac_id',
		'record_type',
		'column_names',
		'record_restore_status'
	];
}
