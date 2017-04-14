<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 14 Apr 2017 11:32:07 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Company
 * 
 * @property int $id
 * @property string $punch_line
 * @property string $receipt_number_alias
 * @property string $legal_name
 * @property string $firm_logo
 * @property string $pan_number
 * @property string $service_tax_number
 * @property string $vat_number
 * @property string $gst_number
 * @property string $office_address
 * @property int $cloud_telephoney_client
 * @property string $domain_name
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
class Company extends Eloquent
{
	protected $casts = [
		'cloud_telephoney_client' => 'int',
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
		'punch_line',
		'receipt_number_alias',
		'legal_name',
		'firm_logo',
		'pan_number',
		'service_tax_number',
		'vat_number',
		'gst_number',
		'office_address',
		'cloud_telephoney_client',
		'domain_name',
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
