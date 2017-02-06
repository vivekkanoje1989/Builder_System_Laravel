<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeSalaryDetail
 * 
 * @property int $id
 * @property int $client_id
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
 * @property \Carbon\Carbon $updated_date
 * @property \Carbon\Carbon $updated_time
 * @property int $updated_by
 * @property string $updated_IP
 * @property string $updated_browser
 * @property string $updated_mac_id
 *
 * @package App\Models
 */
class EmployeeSalaryDetail extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'amount' => 'int',
		'type_of_payment' => 'bool',
		'status' => 'int',
		'employee_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'created_time',
		'updated_date',
		'updated_time'
	];

	protected $fillable = [
		'client_id',
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
		'updated_date',
		'updated_time',
		'updated_by',
		'updated_IP',
		'updated_browser',
		'updated_mac_id'
	];
}
