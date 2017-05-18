<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CtEmployeesExtension
 * 
 * @property int $id
 * @property int $client_id
 * @property int $employee_id
 * @property int $extension_no
 *
 * @package App\Models
 */
class CtEmployeesExtension extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'employee_id' => 'int',
		'extension_no' => 'int'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'extension_no'
	];
}
