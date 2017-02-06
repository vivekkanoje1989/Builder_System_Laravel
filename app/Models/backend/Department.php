<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 05:28:47 +0000.
 */

namespace App\Models\backend;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Department
 * 
 * @property int $id
 * @property int $client_id
 * @property string $department_name
 *
 * @package App\Models
 */
class Department extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int'
	];

	protected $fillable = [
		'client_id',
		'department_name'
	];
}
