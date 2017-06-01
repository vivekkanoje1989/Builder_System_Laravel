<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 08 Mar 2017 18:22:07 +0530.
 */

namespace App\Modules\MasterSales\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CustomersLog
 * 
 * @property int $id
 * @property int $main_record_id
 * @property int $client_id
 * @property int $title_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property int $gender_id
 * @property int $profession_id
 * @property int $monthly_income
 * @property string $pan_number
 * @property int $aadhar_number
 * @property string $image_file
 * @property \Carbon\Carbon $birth_date
 * @property \Carbon\Carbon $marrage_date
 * @property int $source_id
 * @property int $subsource_id
 * @property string $source_description
 * @property int $sms_privacy_status
 * @property int $email_privacy_status
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
class CustomersLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'main_record_id' => 'int',
		'client_id' => 'int',
		'title_id' => 'int',
		'gender_id' => 'int',
		'profession_id' => 'int',
		'monthly_income' => 'int',
		'aadhar_number' => 'int',
		'source_id' => 'int',
		'subsource_id' => 'int',
		'sms_privacy_status' => 'int',
		'email_privacy_status' => 'int',
		'created_by' => 'int',
		'record_type' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		'birth_date',
		'marrage_date',
		'created_date'
	];

	protected $fillable = [
		'main_record_id',
		'client_id',
		'title_id',
		'first_name',
		'middle_name',
		'last_name',
		'gender_id',
		'profession_id',
		'monthly_income',
		'pan_number',
		'aadhar_number',
		'image_file',
		'birth_date',
		'marrage_date',
		'source_id',
		'subsource_id',
		'source_description',
		'sms_privacy_status',
		'email_privacy_status',
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
