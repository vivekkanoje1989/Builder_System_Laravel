<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeDocument
 * 
 * @property int $id
 * @property int $client_id
 * @property int $employee_id
 * @property int $document_id
 * @property string $document_url
 * @property string $extra_document_name
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_time
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 *
 * @package App\Models
 */
class EmployeeDocument extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'employee_id' => 'int',
		'document_id' => 'int',
		'created_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'created_time'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'document_id',
		'document_url',
		'extra_document_name',
		'created_date',
		'created_time',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id'
	];
}
