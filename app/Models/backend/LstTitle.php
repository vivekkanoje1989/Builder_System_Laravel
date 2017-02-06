<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models\backend;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstTitle
 * 
 * @property string $value
 * @property string $title
 *
 * @package App\Models
 */
class LstTitle extends Eloquent
{
	protected $primaryKey = 'value';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'title'
	];
}
