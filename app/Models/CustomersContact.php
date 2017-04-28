<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 10 Mar 2017 12:29:34 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CustomersContact
 * 
 * @property int $id
 * @property int $client_id
 * @property int $customer_id
 * @property int $mobile_number_lable
 * @property string $mobile_calling_code
 * @property string $mobile_number
 * @property int $mobile_optin_status
 * @property int $mobile_optin_media_id
 * @property string $mobile_optin_info
 * @property int $mobile_verification_status
 * @property int $mobile_verification_via
 * @property string $mobile_verification_details
 * @property \Carbon\Carbon $mobile_verification_timestamp
 * @property int $mobile_alerts_status
 * @property string $mobile_alerts_inactivation_details
 * @property \Carbon\Carbon $mobile_alerts_inactivation_timestamp
 * @property int $landline_lable
 * @property int $landline_calling_code
 * @property string $landline_number
 * @property int $landline_optin_status
 * @property int $landline_optin_media_id
 * @property string $landline_optin_info
 * @property int $landline_verification_status
 * @property int $landline_verification_via
 * @property string $landline_verification_details
 * @property \Carbon\Carbon $landline_verification_timestamp
 * @property int $landline_alerts_status
 * @property string $landline_alerts_inactivation_details
 * @property \Carbon\Carbon $landline_alerts_inactivation_timestamp
 * @property int $email_id_lable
 * @property string $email_id
 * @property int $email_optin_status
 * @property int $email_optin_media_id
 * @property string $email_optin_info
 * @property int $email_verification_status
 * @property int $email_verification_via
 * @property string $email_verification_details
 * @property \Carbon\Carbon $email_verification_timestamp
 * @property int $email_alerts_status
 * @property string $email_alerts_inactivation_details
 * @property \Carbon\Carbon $email_alerts_inactivation_timestamp
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
class CustomersContact extends Eloquent
{
	protected $casts = [
		'client_id' => 'int',
		'customer_id' => 'int',
		'mobile_number_lable' => 'int',
		'mobile_optin_status' => 'int',
		'mobile_optin_media_id' => 'int',
		'mobile_verification_status' => 'int',
		'mobile_verification_via' => 'int',
		'mobile_alerts_status' => 'int',
		'landline_lable' => 'int',
		'landline_calling_code' => 'int',
		'landline_optin_status' => 'int',
		'landline_optin_media_id' => 'int',
		'landline_verification_status' => 'int',
		'landline_verification_via' => 'int',
		'landline_alerts_status' => 'int',
		'email_id_lable' => 'int',
		'email_optin_status' => 'int',
		'email_optin_media_id' => 'int',
		'email_verification_status' => 'int',
		'email_verification_via' => 'int',
		'email_alerts_status' => 'int',
		'address_type' => 'int',
		'country_id' => 'int',
		'state_id' => 'int',
		'city_id' => 'int',
		'pin' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'mobile_verification_timestamp',
		'mobile_alerts_inactivation_timestamp',
		'landline_verification_timestamp',
		'landline_alerts_inactivation_timestamp',
		'email_verification_timestamp',
		'email_alerts_inactivation_timestamp',
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
		'customer_id',
		'mobile_number_lable',
		'mobile_calling_code',
		'mobile_number',
		'mobile_optin_status',
		'mobile_optin_media_id',
		'mobile_optin_info',
		'mobile_verification_status',
		'mobile_verification_via',
		'mobile_verification_details',
		'mobile_verification_timestamp',
		'mobile_alerts_status',
		'mobile_alerts_inactivation_details',
		'mobile_alerts_inactivation_timestamp',
		'landline_lable',
		'landline_calling_code',
		'landline_number',
		'landline_optin_status',
		'landline_optin_media_id',
		'landline_optin_info',
		'landline_verification_status',
		'landline_verification_via',
		'landline_verification_details',
		'landline_verification_timestamp',
		'landline_alerts_status',
		'landline_alerts_inactivation_details',
		'landline_alerts_inactivation_timestamp',
		'email_id_lable',
		'email_id',
		'email_optin_status',
		'email_optin_media_id',
		'email_optin_info',
		'email_verification_status',
		'email_verification_via',
		'email_verification_details',
		'email_verification_timestamp',
		'email_alerts_status',
		'email_alerts_inactivation_details',
		'email_alerts_inactivation_timestamp',
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
