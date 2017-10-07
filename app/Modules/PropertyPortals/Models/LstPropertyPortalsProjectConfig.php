<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 01 Apr 2017 15:24:35 +0530.
 */

namespace App\Modules\PropertyPortals\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstPropertyPortalsProjectConfig
 * 
 * @property int $id
 * @property int $property_portal_id
 * @property int $project_id
 * @property string $project_alias
 * @property string $employee_ids
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
class LstPropertyPortalsProjectConfig extends Eloquent
{
	protected $casts = [
		'property_portal_id' => 'int',
		'project_id' => 'int',
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
		'property_portal_id',
                'property_portal_config_id',
		'project_id',
		'project_alias',
		'employee_ids',
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
