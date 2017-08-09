<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 10 Apr 2017 14:38:37 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TemplatesCustom
 * 
 * @property int $id
 * @property int $client_id
 * @property int $template_event_id
 * @property string $sms_body
 * @property string $email_subject
 * @property string $email_body
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
class TemplatesCustom extends Eloquent
{
	protected $casts = [
		'client_id' => 'int',
		'template_event_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int',
		'deleted_IP' => 'int',
		'deleted_browser' => 'int',
		'deleted_mac_id' => 'int',
                'sr_no'=>'int'
	];

	protected $dates = [
		'created_date',
		'updated_date',
		'deleted_date'
	];

	protected $fillable = [
		'client_id',
		'template_event_id',
		'sms_body',
		'email_subject',
		'email_body',
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
		'deleted_mac_id',
                'sr_no',
                'friendly_name'
	];
}
