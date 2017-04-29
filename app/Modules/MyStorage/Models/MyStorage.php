<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 28 Apr 2017 11:45:22 +0530.
 */

namespace App\Modules\MyStorage\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MyStorage
 * 
 * @property int $id
 * @property string $folder
 * @property string $share_with
 * @property string $sub_folder
 * @property int $sub_folder_status
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
 * @property string $deleted_IP
 * @property string $deleted_browser
 * @property string $deleted_mac_id
 *
 * @package App\Models
 */
class MyStorage extends Eloquent
{
	protected $casts = [
		'sub_folder_status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date',
		'deleted_date'
	];

	protected $fillable = [
		'folder',
		'share_with',
		'sub_folder',
		'sub_folder_status',
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
