<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstTitle
 * 
 * @property string $value
 * @property string $title
 *
 * @package App\Models
 */
class MlstTitle extends Eloquent
{
	protected $primaryKey = 'value';
	 protected $connection = 'masterdb';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'title'
	];
}
