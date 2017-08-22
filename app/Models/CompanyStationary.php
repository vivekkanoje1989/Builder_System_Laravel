<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 14 Apr 2017 11:18:09 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CompanyStationary
 * 
 * @property int $id
 * @property int $company_id
 * @property string $stationary_set_name
 * @property string $estimate_letterhead_file
 * @property string $estimate_logo_file
 * @property string $demandletter_letterhead_file
 * @property string $demandletter_logo_file
 * @property string $receipt_letterhead_file
 * @property string $receipt_logo_file
 * @property string $rubber_stamp_file
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
 * @property int $deleted_status
 * @property \Carbon\Carbon $deleted_date
 * @property int $deleted_by
 * @property int $deleted_IP
 * @property int $deleted_browser
 * @property int $deleted_mac_id
 *
 * @package App\Models
 */
class CompanyStationary extends Eloquent
{
	protected $casts = [
		'company_id' => 'int',
		'status' => 'int',
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
		'company_id',
		'stationary_set_name',
		'estimate_letterhead_file',
		'estimate_logo_file',
		'demandletter_letterhead_file',
		'demandletter_logo_file',
		'receipt_letterhead_file',
		'receipt_logo_file',
		'rubber_stamp_file',
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
		'updated_mac_id',
		'deleted_status',
		'deleted_date',
		'deleted_by',
		'deleted_IP',
		'deleted_browser',
		'deleted_mac_id'
	];
}
