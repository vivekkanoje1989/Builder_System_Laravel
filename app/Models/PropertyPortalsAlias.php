<?php
/* created By- Uma Shinde
 * Date- 14/3/2017
 * updated by-
 */
/**
 * Created by Reliese Model.
 * Date: Sat, 11 Mar 2017 16:56:45 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PropertyPortalsAlias
 * 
 * @property int $id
 * @property int $property_portal_id
 * @property int $project_id
 * @property string $project_alias_name
 * @property int $project_employee_id
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
class PropertyPortalsAlias extends Eloquent
{
	protected $table = 'property_portals_alias';

	protected $casts = [
		'property_portal_id' => 'int',
		'project_id' => 'int',
		'project_employee_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $fillable = [
                'property_portal_type_id',
		'property_portal_id',
		'project_id',
		'project_alias_name',
		'project_employee_id',
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
