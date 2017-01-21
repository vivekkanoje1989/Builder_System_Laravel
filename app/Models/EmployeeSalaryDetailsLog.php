<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeSalaryDetailsLog
 * 
 * @property int $id
 * @property string $heading_name
 * @property int $amount
 * @property bool $type_of_payment
 * @property string $remarks
 * @property int $status
 * @property int $employee_id
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_time
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property int $record_type
 * @property int $column_names
 * @property int $record_restore_status
 *
 * @package App\Models
 */
class EmployeeSalaryDetailsLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'amount' => 'int',
		'type_of_payment' => 'bool',
		'status' => 'int',
		'employee_id' => 'int',
		'created_by' => 'int',
		'record_type' => 'int',
		'column_names' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		'created_date',
		'created_time'
	];

	protected $fillable = [
		'heading_name',
		'amount',
		'type_of_payment',
		'remarks',
		'status',
		'employee_id',
		'created_date',
		'created_time',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'record_type',
		'column_names',
		'record_restore_status'
	];
}
