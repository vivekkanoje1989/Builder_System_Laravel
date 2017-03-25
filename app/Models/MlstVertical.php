<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Mar 2017 12:50:56 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstVertical
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class MlstVertical extends Eloquent
{
	public $timestamps = false;
        protected $connection = 'masterdb';
	protected $fillable = [
		'name'
	];
}
