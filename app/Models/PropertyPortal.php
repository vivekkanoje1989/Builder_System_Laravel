<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 10 Mar 2017 11:05:22 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PropertyPortal
 * 
 * @property int $id
 * @property int $property_portal_type_id
 * @property string $username
 * @property string $password
 * @property string $api_key
 * @property string $portal_name
 * @property int $assign_employee
 * @property string $employee_id
 * @property int $project_id
 * @property int $status
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
 *
 * @package App\Models
 */
class PropertyPortal extends Eloquent
{
	protected $casts = [
		'property_portal_type_id' => 'int',
		'assign_employee' => 'int',
		'project_id' => 'int',
		'status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'property_portal_type_id',
		'username',
		'password',
		'api_key',
		'portal_name',
		'assign_employee',
		'employee_id',
		'project_id',
		'status',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'updated_date',
		'updated_by',
		'updated_IP',
		'updated_browser',
		'updated_mac_id'
	];
}
