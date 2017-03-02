<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Feb 2017 12:04:35 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class VehicleModel
 * 
 * @property int $id
 * @property int $brand_id
 * @property string $model_name
 *
 * @package App\Models
 */
class VehicleModel extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'brand_id' => 'int'
	];

	protected $fillable = [
		'brand_id',
		'model_name'
	];
}
