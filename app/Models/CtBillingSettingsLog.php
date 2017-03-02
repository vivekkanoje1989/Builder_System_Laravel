<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CtBillingSettingsLog
 * 
 * @property int $id
 * @property int $client_id
 * @property int $main_record_id
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
 * @property int $number_status
 * @property \Carbon\Carbon $deactivation_date
 * @property int $deactivated_by
 * @property string $deactivation_reason
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
class CtBillingSettingsLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'main_record_id' => 'int',
		'default_number' => 'bool',
		'incoming_call_status' => 'bool',
		'incoming_pulse_duration' => 'int',
		'incoming_pulse_rate' => 'int',
		'outbound_call_status' => 'bool',
		'outbound_pulse_duration' => 'int',
		'outbound_pulse_rate' => 'int',
		'rent_duration' => 'int',
		'rent_amount' => 'int',
		'number_status' => 'int',
		'deactivated_by' => 'int',
		'created_by' => 'int',
		'record_type' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		'activation_date',
		'deactivation_date',
		'created_date'
	];

	protected $fillable = [
		'client_id',
		'main_record_id',
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
		'number_status',
		'deactivation_date',
		'deactivated_by',
		'deactivation_reason',
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
