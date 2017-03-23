<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 24 Feb 2017 15:00:41 +0530.
 */

namespace App\Modules\ManageDepartment\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstDepartment
 * 
 * @property int $id
 * @property int $client_id
 * @property string $department_name
 *
 * @package App\Models
 */
class MlstDepartments extends Eloquent
{
	public $timestamps = false;

	 protected $connection = 'masterdb';

	protected $casts = [
		'client_id' => 'int'
	];

	protected $fillable = [
		'client_id',
		'department_name',
                'created_date',
                'created_at',
                'created_by',
                'created_IP',
                'created_browser',
                'created_mac_id',
                'updated_date',
                'updated_at',
                'updated_by',
                'updated_IP',
                'updated_browser',
                'updated_mac_id',
	];
}
