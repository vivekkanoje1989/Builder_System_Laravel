<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
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
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'client_id' => 'int',
		'employee_id' => 'int',
		'extension_no' => 'int'
	];

	protected $fillable = [
		'id',
		'client_id',
		'employee_id',
		'extension_no'
	];
}
