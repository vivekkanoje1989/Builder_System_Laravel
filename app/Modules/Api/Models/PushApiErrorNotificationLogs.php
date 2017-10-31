<?php

namespace App\Modules\Api\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class PushApiErrorNotificationLogs extends Eloquent
{
	protected $casts = [
		'bms_push_api_settings_id' => 'int',
	];

	protected $fillable = [
		'bms_push_api_settings_id',
		'requested_data',
		'imported_in_live_database',
		'error_code',
		'error_message',
		'imported_by',
		'imported_date',
		'requested_url_date',
	];
}
