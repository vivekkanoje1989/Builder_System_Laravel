<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 13 Mar 2017 12:46:07 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SystemConfig
 * 
 * @property int $id
 * @property int $client_id
 * @property string $client_code
 * @property string $app_access_key
 * @property string $aws_bucket_id
 * @property string $aws_db_bucket_id
 * @property string $aws_access_key
 * @property string $aws_secret_key
 * @property string $allow_mobile_call_recording_incoming
 * @property string $allow_mobile_call_recording_outgoing
 * @property int $allow_automatic_record_call
 * @property string $google_analytics_code
 * @property string $remarketing_script
 *
 * @package App\Models
 */
class SystemConfig extends Eloquent
{
	protected $table = 'system_configs';
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'allow_automatic_record_call' => 'int'
	];

	protected $hidden = [
		'aws_secret_key'
	];

	protected $fillable = [
		'client_id',
		'client_code',
		'app_access_key',
		'aws_bucket_id',
		'aws_db_bucket_id',
		'aws_access_key',
		'aws_secret_key',
		'allow_mobile_call_recording_incoming',
		'allow_mobile_call_recording_outgoing',
		'allow_automatic_record_call',
		'google_analytics_code',
		'remarketing_script'
	];
}
