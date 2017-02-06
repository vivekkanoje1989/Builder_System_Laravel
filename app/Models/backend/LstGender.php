<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models\backend;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstGender
 * 
 * @property int $gender_id
 * @property string $gender_title
 *
 * @package App\Models
 */
class LstGender extends Eloquent
{
	protected $primaryKey = 'gender_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'gender_id' => 'int'
	];

	protected $fillable = [
		'gender_title'
	];
}
