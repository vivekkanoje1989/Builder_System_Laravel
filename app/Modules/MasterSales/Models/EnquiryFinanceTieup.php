<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 19 Apr 2017 18:12:36 +0530.
 */

namespace App\Modules\MasterSales\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EnquiryFinanceTieup
 * 
 * @property int $id
 * @property int $title_id
 * @property string $first_name
 * @property string $last_name
 * @property int $mobile1
 * @property int $mobile2
 * @property string $email1
 * @property string $email2
 * @property string $designation
 * @property string $bank_name
 * @property string $bank_branch
 * @property string $bank_address
 * @property string $bank_email
 * @property string $bank_ifsc
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
class EnquiryFinanceTieup extends Eloquent
{
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'title_id' => 'int',
		'mobile1' => 'int',
		'mobile2' => 'int',
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
		'id',
		'title_id',
		'first_name',
		'last_name',
		'mobile1',
		'mobile2',
		'email1',
		'email2',
		'designation',
		'bank_name',
		'bank_branch',
		'bank_address',
		'bank_email',
		'bank_ifsc',
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
