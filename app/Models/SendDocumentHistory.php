<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 07 Sep 2017 13:04:50 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SendDocumentHistory
 * 
 * @property int $id
 * @property int $enquiry_id
 * @property int $project_id
 * @property string $send_documents
 * @property \Carbon\Carbon $send_datetime
 * @property int $send_by
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
class SendDocumentHistory extends Eloquent
{
	protected $table = 'send_document_history';

	protected $casts = [
		'enquiry_id' => 'int',
		'project_id' => 'int',
		'send_by' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int',
		'deleted_IP' => 'int',
		'deleted_browser' => 'int',
		'deleted_mac_id' => 'int'
	];

	protected $dates = [
		'send_datetime',
		'created_date',
		'updated_date',
		'deleted_date'
	];

	protected $fillable = [
		'enquiry_id',
		'project_id',
		'send_documents',
		'send_datetime',
		'send_by',
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
