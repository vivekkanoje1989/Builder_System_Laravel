<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 23 Feb 2017 18:14:08 +0530.
 */

namespace App\Modules\MasterSales\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomersContact
 * 
 * @property int $id
 * @property int $client_id
 * @property int $customer_id
 * @property int $mobile_number_lable
 * @property int $mobile_calling_code
 * @property int $mobile_number
 * @property int $landline_lable
 * @property int $landline_calling_code
 * @property int $landline_number
 * @property int $email_id_lable
 * @property string $email_id
 * @property int $address_type
 * @property string $house_number
 * @property string $building_house_name
 * @property string $wing_name
 * @property string $area_name
 * @property string $lane_name
 * @property string $landmark
 * @property int $country_id
 * @property int $state_id
 * @property int $city_id
 * @property int $pin
 * @property string $google_map_link
 * @property string $other_remarks
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
class CustomersContact extends Model
{
	protected $casts = [
		'client_id' => 'int',
		'customer_id' => 'int',
		'mobile_number_lable' => 'int',
		'mobile_calling_code' => 'int',
		'mobile_number' => 'int',
		'landline_lable' => 'int',
		'landline_calling_code' => 'int',
		'landline_number' => 'int',
		'email_id_lable' => 'int',
		'address_type' => 'int',
		'country_id' => 'int',
		'state_id' => 'int',
		'city_id' => 'int',
		'pin' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
		'customer_id',
		'mobile_number_lable',
		'mobile_calling_code',
		'mobile_number',
		'landline_lable',
		'landline_calling_code',
		'landline_number',
		'email_id_lable',
		'email_id',
		'address_type',
		'house_number',
		'building_house_name',
		'wing_name',
		'area_name',
		'lane_name',
		'landmark',
		'country_id',
		'state_id',
		'city_id',
		'pin',
		'google_map_link',
		'other_remarks',
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
