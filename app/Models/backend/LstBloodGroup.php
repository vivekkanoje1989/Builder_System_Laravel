<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 05:28:47 +0000.
 */

namespace App\Models\backend;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstBloodGroup
 * 
 * @property int $blood_group_id
 * @property string $blood_group
 *
 * @package App\Models
 */
class LstBloodGroup extends Eloquent
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
