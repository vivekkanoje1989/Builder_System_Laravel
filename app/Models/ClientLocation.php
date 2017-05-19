<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ClientLocation
 * 
 * @property int $id
 * @property int $client_id
 * @property int $location_type
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property int $area
 * @property int $address
 * @property int $pin
 * @property int $google_map
 * @property int $working_hours_start
 * @property int $working_hours_end
 * @property int $weekly_off_day_id
 *
 * @package App\Models
 */
class ClientLocation extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'location_type' => 'int',
		'country_id' => 'int',
		'state_id' => 'int',
		'city_id' => 'int',
		'area' => 'int',
		'address' => 'int',
		'pin' => 'int',
		'google_map' => 'int',
		'working_hours_start' => 'int',
		'working_hours_end' => 'int',
		'weekly_off_day_id' => 'int'
	];

	protected $fillable = [
		'client_id',
		'location_type',
		'country_id',
		'state_id',
		'city_id',
		'area',
		'address',
		'pin',
		'google_map',
		'working_hours_start',
		'working_hours_end',
		'weekly_off_day_id'
	];
}
