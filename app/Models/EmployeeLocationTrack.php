<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeLocationTrack
 * 
 * @property int $id
 * @property int $client_id
 * @property int $employee_id
 * @property string $latitude
 * @property string $longitude
 * @property string $full_address
 * @property \Carbon\Carbon $track_date_time
 *
 * @package App\Models
 */
class EmployeeLocationTrack extends Eloquent
{
	protected $table = 'employee_location_track';
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'employee_id' => 'int'
	];

	protected $dates = [
		'track_date_time'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'latitude',
		'longitude',
		'full_address',
		'track_date_time'
	];
}
