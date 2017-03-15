<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 17 Feb 2017 11:41:52 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EnquirySubSource
 * 
 * @property int $id
 * @property int $client_id
 * @property int $source_id
 * @property string $sub_source
 * @property int $sub_source_status
 * @property int $vertical_id
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
class EnquirySubSource extends Eloquent
{
	protected $casts = [
		'client_id' => 'int',
		'source_id' => 'int',
		'sub_source_status' => 'int',
		'vertical_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
		'source_id',
		'sub_source',
		'sub_source_status',
		'vertical_id',
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
