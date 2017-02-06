<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ClientPurchaseLog
 * 
 * @property int $id
 * @property int $client_id
 * @property int $employee_id
 * @property int $service_type_id
 * @property int $service_start_date
 * @property int $service_end_date
 * @property int $invoice_url
 * @property int $invoice_status
 * @property int $invoice_date
 * @property int $invoice_number
 * @property int $receipt_date
 * @property int $receipt_number
 * @property int $receipt_url
 *
 * @package App\Models
 */
class ClientPurchaseLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'employee_id' => 'int',
		'service_type_id' => 'int',
		'service_start_date' => 'int',
		'service_end_date' => 'int',
		'invoice_url' => 'int',
		'invoice_status' => 'int',
		'invoice_date' => 'int',
		'invoice_number' => 'int',
		'receipt_date' => 'int',
		'receipt_number' => 'int',
		'receipt_url' => 'int'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'service_type_id',
		'service_start_date',
		'service_end_date',
		'invoice_url',
		'invoice_status',
		'invoice_date',
		'invoice_number',
		'receipt_date',
		'receipt_number',
		'receipt_url'
	];
}
