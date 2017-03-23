<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 24 Feb 2017 15:00:41 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstDepartment
 * 
 * @property int $id
 * @property int $client_id
 * @property string $department_name
 *
 * @package App\Models
 */
class MlstDepartment extends Eloquent
{
	public $timestamps = false;

        protected $connection = 'masterdb';

	protected $casts = [
		'client_id' => 'int'
	];

	protected $fillable = [
		'client_id',
		'department_name'
	];
}
