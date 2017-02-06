<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CtBillingSetting
 * 
 * @property int $id
 * @property int $client_id
 * @property string $virtual_number
 * @property bool $default_number
 * @property bool $incoming_call_status
 * @property int $incoming_pulse_duration
 * @property int $incoming_pulse_rate
 * @property bool $outbound_call_status
 * @property int $outbound_pulse_duration
 * @property int $outbound_pulse_rate
 * @property \Carbon\Carbon $activation_date
 * @property int $rent_duration
 * @property int $rent_amount
 * @property \Carbon\Carbon $created_date
 * @property int $created_by
 * @property int $number_status
 * @property \Carbon\Carbon $deactivation_date
 * @property int $deactivated_by
 * @property string $deactivation_reason
 * @property \Carbon\Carbon $updated_date
 * @property int $updated_by
 *
 * @package App\Models
 */
class CtBillingSetting extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'client_id' => 'int',
		'default_number' => 'bool',
		'incoming_call_status' => 'bool',
		'incoming_pulse_duration' => 'int',
		'incoming_pulse_rate' => 'int',
		'outbound_call_status' => 'bool',
		'outbound_pulse_duration' => 'int',
		'outbound_pulse_rate' => 'int',
		'rent_duration' => 'int',
		'rent_amount' => 'int',
		'created_by' => 'int',
		'number_status' => 'int',
		'deactivated_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'activation_date',
		'created_date',
		'deactivation_date',
		'updated_date'
	];

	protected $fillable = [
		'id',
		'client_id',
		'virtual_number',
		'default_number',
		'incoming_call_status',
		'incoming_pulse_duration',
		'incoming_pulse_rate',
		'outbound_call_status',
		'outbound_pulse_duration',
		'outbound_pulse_rate',
		'activation_date',
		'rent_duration',
		'rent_amount',
		'created_date',
		'created_by',
		'number_status',
		'deactivation_date',
		'deactivated_by',
		'deactivation_reason',
		'updated_date',
		'updated_by'
	];
}
