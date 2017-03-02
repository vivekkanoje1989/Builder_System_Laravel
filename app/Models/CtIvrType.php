<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CtIvrType
 * 
 * @property int $id
 * @property string $ivr_for
 * @property int $ivr_type
 *
 * @package App\Models
 */
class CtIvrType extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'ivr_type' => 'int'
	];

	protected $fillable = [
		'id',
		'ivr_for',
		'ivr_type'
	];
}
