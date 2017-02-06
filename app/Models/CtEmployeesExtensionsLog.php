<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CtEmployeesExtensionsLog
 * 
 * @property int $id
 * @property int $client_id
 * @property int $main_record_id
 * @property int $employee_id
 * @property int $extension_no
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property int $record_type
 * @property string $column_names
 * @property int $record_restore_status
 *
 * @package App\Models
 */
class CtEmployeesExtensionsLog extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'client_id' => 'int',
		'main_record_id' => 'int',
		'employee_id' => 'int',
		'extension_no' => 'int',
		'created_by' => 'int',
		'record_type' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		'created_date'
	];

	protected $fillable = [
		'id',
		'client_id',
		'main_record_id',
		'employee_id',
		'extension_no',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'record_type',
		'column_names',
		'record_restore_status'
	];
}
