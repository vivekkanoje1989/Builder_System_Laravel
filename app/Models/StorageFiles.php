<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 28 Apr 2017 11:46:10 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class StorageFile
 * 
 * @property int $id
 * @property int $storage_id
 * @property string $share_with
 * @property string $file_name
 * @property string $file_url
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 *
 * @package App\Models
 */
class StorageFiles extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'storage_id' => 'int',
		'created_by' => 'int'
	];

	protected $dates = [
		'created_date'
	];

	protected $fillable = [
		'storage_id',
		'share_with',
		'file_name',
		'file_url',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id'
	];
}
