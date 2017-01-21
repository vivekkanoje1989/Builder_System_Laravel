<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class City
 * 
 * @property int $city_id
 * @property int $state_id
 * @property string $city_name
 *
 * @package App\Models
 */
class City extends Eloquent
{
	protected $primaryKey = 'city_id';
	public $timestamps = false;

	protected $casts = [
		'state_id' => 'int'
	];

	protected $fillable = [
		'state_id',
		'city_name'
	];
}
