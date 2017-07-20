<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Feb 2017 12:04:16 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class VehicleBrand
 * 
 * @property int $id
 * @property string $brand_name
 *
 * @package App\Models
 */
class VehicleBrand extends Eloquent
{
	public $timestamps = false;

	protected $fillable = [
		'brand_name'
	];
}
