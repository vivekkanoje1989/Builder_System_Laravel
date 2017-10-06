<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 11 Apr 2017 17:32:42 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProjectWing
 * 
 * @property int $id
 * @property int $project_id
 * @property int $firm_partner_id
 * @property int $stationary_id
 * @property string $wing_name
 * @property int $number_of_floors
 * @property int $number_of_floors_below_ground
 * @property int $wing_status
 * @property int $wing_status_for_enquiries
 * @property int $wing_status_for_bookings
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property \Carbon\Carbon $updated_date
 * @property \Carbon\Carbon $updated_at
 * @property int $updated_by
 * @property string $updated_IP
 * @property string $updated_browser
 * @property string $updated_mac_id
 * @property int $deleted_status
 * @property \Carbon\Carbon $deleted_date
 * @property int $deleted_by
 * @property int $deleted_IP
 * @property int $deleted_browser
 * @property int $deleted_mac_id
 *
 * @package App\Models
 */
class ProjectWing extends Eloquent
{
	protected $casts = [
		'project_id' => 'int',
		'firm_partner_id' => 'int',
		'stationary_id' => 'int',
		'number_of_floors' => 'int',
		'number_of_floors_below_ground' => 'int',
		'wing_status' => 'int',
		'wing_status_for_enquiries' => 'int',
		'wing_status_for_bookings' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int',
		'deleted_IP' => 'int',
		'deleted_browser' => 'int',
		'deleted_mac_id' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date',
		'deleted_date'
	];

	protected $fillable = [
		'project_id',
		'firm_partner_id',
		'stationary_id',
		'wing_name',
		'number_of_floors',
		'number_of_floors_below_ground',
		'wing_status',
		'wing_status_for_enquiries',
		'wing_status_for_bookings',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'updated_date',
		'updated_by',
		'updated_IP',
		'updated_browser',
		'updated_mac_id',
		'deleted_status',
		'deleted_date',
		'deleted_by',
		'deleted_IP',
		'deleted_browser',
		'deleted_mac_id'
	];
}
