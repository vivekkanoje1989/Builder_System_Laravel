<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstGender
 * 
 * @property int $gender_id
 * @property string $gender_title
 *
 * @package App\Models
 */
class MlstGender extends Eloquent
{
	protected $primaryKey = 'id';
	protected $connection = 'masterdb';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'gender'
	];
}
