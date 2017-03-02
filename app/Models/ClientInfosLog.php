<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ClientInfosLog
 * 
 * @property int $id
 * @property int $main_record_id
 * @property int $client_id
 * @property bool $right_click
 * @property string $client_code
 * @property int $group_id
 * @property string $marketing_name
 * @property string $legal_name
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property string $office_addres
 * @property int $pin_code
 * @property string $company_logo
 * @property int $brand_id
 * @property string $website
 * @property int $website_with
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property int $record_type
 * @property string $column_names
 * @property int $record_restore_status
 *
 * @package App\Models
 */
class ClientInfosLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'main_record_id' => 'int',
		'client_id' => 'int',
		'right_click' => 'bool',
		'group_id' => 'int',
		'country_id' => 'int',
		'state_id' => 'int',
		'city_id' => 'int',
		'pin_code' => 'int',
		'brand_id' => 'int',
		'website_with' => 'int',
		'created_by' => 'int',
		'record_type' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		'created_date'
	];

	protected $fillable = [
		'main_record_id',
		'client_id',
		'right_click',
		'client_code',
		'group_id',
		'marketing_name',
		'legal_name',
		'country_id',
		'state_id',
		'city_id',
		'office_addres',
		'pin_code',
		'company_logo',
		'brand_id',
		'website',
		'website_with',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'record_type',
		'column_names',
		'record_restore_status'
	];
}
