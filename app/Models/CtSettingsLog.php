<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CtSettingsLog
 * 
 * @property int $id
 * @property int $client_id
 * @property int $ct_billing_settings_id
 * @property int $main_record_id
 * @property int $virtual_number
 * @property bool $default_number
 * @property bool $menu_status
 * @property int $ivr_type_id
 * @property int $welcome_tune_type_id
 * @property string $welcome_tune
 * @property int $hold_tune_type_id
 * @property string $hold_tune
 * @property int $forwarding_type_id
 * @property int $forwarding_time
 * @property string $employees
 * @property int $source_id
 * @property int $sub_source_id
 * @property string $source_disc
 * @property int $model_project_id
 * @property bool $insert_enquiry
 * @property bool $missed_call_insert_enquiry
 * @property bool $ec_call_status
 * @property int $ec_welcome_tune_type_id
 * @property string $ec_welcome_tune
 * @property int $ec_hold_tune_type_id
 * @property string $ec_hold_tune
 * @property int $nwh_status
 * @property \Carbon\Carbon $nwh_start_time
 * @property \Carbon\Carbon $nwh_end_time
 * @property int $nwh_welcome_tune_type_id
 * @property string $nwh_welcome_tune
 * @property int $nwh_call_insert_enquiry
 * @property bool $msc_employee_type
 * @property int $msc_default_employee_id
 * @property bool $msc_facility_status
 * @property int $msc_welcome_tune_type_id
 * @property string $msc_welcome_tune
 * @property bool $inbound_call_status
 * @property bool $outbound_call_status
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
class CtSettingsLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'ct_billing_settings_id' => 'int',
		'main_record_id' => 'int',
		'virtual_number' => 'int',
		'default_number' => 'bool',
		'menu_status' => 'bool',
		'ivr_type_id' => 'int',
		'welcome_tune_type_id' => 'int',
		'hold_tune_type_id' => 'int',
		'forwarding_type_id' => 'int',
		'forwarding_time' => 'int',
		'source_id' => 'int',
		'sub_source_id' => 'int',
		'model_project_id' => 'int',
		'insert_enquiry' => 'bool',
		'missed_call_insert_enquiry' => 'bool',
		'ec_call_status' => 'bool',
		'ec_welcome_tune_type_id' => 'int',
		'ec_hold_tune_type_id' => 'int',
		'nwh_status' => 'int',
		'nwh_welcome_tune_type_id' => 'int',
		'nwh_call_insert_enquiry' => 'int',
		'msc_employee_type' => 'bool',
		'msc_default_employee_id' => 'int',
		'msc_facility_status' => 'bool',
		'msc_welcome_tune_type_id' => 'int',
		'inbound_call_status' => 'bool',
		'outbound_call_status' => 'bool',
		'created_by' => 'int',
		'record_type' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		//'nwh_start_time',
		//'nwh_end_time',
		'created_date'
	];

	protected $fillable = [
		'client_id',
		'ct_billing_settings_id',
		'main_record_id',
		'virtual_number',
		'default_number',
		'menu_status',
		'ivr_type_id',
		'welcome_tune_type_id',
		'welcome_tune',
		'hold_tune_type_id',
		'hold_tune',
		'forwarding_type_id',
		'forwarding_time',
		'employees',
		'source_id',
		'sub_source_id',
		'source_disc',
		'model_project_id',
		'insert_enquiry',
		'missed_call_insert_enquiry',
		'ec_call_status',
		'ec_welcome_tune_type_id',
		'ec_welcome_tune',
		'ec_hold_tune_type_id',
		'ec_hold_tune',
		'nwh_status',
		'nwh_start_time',
		'nwh_end_time',
		'nwh_welcome_tune_type_id',
		'nwh_welcome_tune',
		'nwh_call_insert_enquiry',
		'msc_employee_type',
		'msc_default_employee_id',
		'msc_facility_status',
		'msc_welcome_tune_type_id',
		'msc_welcome_tune',
		'inbound_call_status',
		'outbound_call_status',
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
