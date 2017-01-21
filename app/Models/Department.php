<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BloodGroup
 * 
 * @property int $blood_group_id
 * @property string $blood_group
 *
 * @package App\Models
 */
class Department extends Eloquent
{
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = [
		'department_name'
	];
}
