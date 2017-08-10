<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 09 Aug 2017 18:43:52 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Booking
 * 
 * @property int $id
 * @property int $enquiry_id
 * @property int $project_id
 * @property \Carbon\Carbon $booking_date
 * @property string $project_name
 * @property int $block_id
 * @property string $block_name
 * @property int $sub_block_id
 * @property string $sub_block_name
 * @property int $area_in_sqft
 * @property string $registration_number
 * @property int $sales_person_id
 * @property int $total_recievable_amount
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
class Booking extends Eloquent
{
	protected $casts = [
		'enquiry_id' => 'int',
		'project_id' => 'int',
		'block_id' => 'int',
		'sub_block_id' => 'int',
		'area_in_sqft' => 'int',
		'sales_person_id' => 'int',
		'total_recievable_amount' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int',
		'deleted_IP' => 'int',
		'deleted_browser' => 'int',
		'deleted_mac_id' => 'int'
	];

	protected $dates = [
		'booking_date',
		'created_date',
		'updated_date',
		'deleted_date'
	];

	protected $fillable = [
		'enquiry_id',
		'project_id',
		'booking_date',
		'project_name',
		'block_id',
		'block_name',
		'sub_block_id',
		'sub_block_name',
		'area_in_sqft',
		'registration_number',
		'sales_person_id',
		'total_recievable_amount',
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
