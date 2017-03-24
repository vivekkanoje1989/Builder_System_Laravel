<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 24 Mar 2017 17:11:43 +0530.
 */

namespace App\Modules\MasterHr\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeRole
 * 
 * @property int $id
 * @property string $role_name
 * @property string $employee_submenus
 *
 * @package App\Models
 */
class EmployeeRole extends Eloquent
{
	public $timestamps = false;

	protected $fillable = [
		'role_name',
		'employee_submenus'
	];
}
