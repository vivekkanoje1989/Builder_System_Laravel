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
class BloodGroup extends Eloquent
{
	protected $primaryKey = 'blood_group_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'blood_group_id' => 'int'
	];

	protected $fillable = [
		'blood_group'
	];
}
