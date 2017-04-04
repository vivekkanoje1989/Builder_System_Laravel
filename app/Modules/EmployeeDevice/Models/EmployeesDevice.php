<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 03 Apr 2017 15:22:17 +0530.
 */

namespace App\Modules\EmployeeDevice\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeesDevice
 * 
 * @property int $id
 * @property int $client_id
 * @property string $employee_id
 * @property string $device_name
 * @property string $device_mac
 * @property int $device_type
 * @property string $device_description
 * @property string $remarks
 * @property int $device_status
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_time
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property \Carbon\Carbon $updated_date
 * @property \Carbon\Carbon $updated_time
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
class EmployeesDevice extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'device_type' => 'int',
		'device_status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int',
		'deleted_IP' => 'int',
		'deleted_browser' => 'int',
		'deleted_mac_id' => 'int'
	];

	protected $dates = [
		'created_date',
		'created_time',
		'updated_date',
		'updated_time',
		'deleted_date'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'device_name',
		'device_mac',
		'device_type',
		'device_description',
		'remarks',
		'device_status',
		'created_date',
		'created_time',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'updated_date',
		'updated_time',
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
        
         public static function validationMessages() {
        $messages = array(
            'employee_id.required' => 'Please select employees',
            'device_name.numeric' => 'Please enter device name',
            'device_mac.numeric' => 'Please enter device mac',
            'device_type.required' => 'Select device type',
            'device_status.required' => 'Select device status',
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'employee_id' => 'required',
            'device_name' => 'required',
            'device_mac' => 'required',
            'device_type' => 'required',
            'device_status' => 'required',            
        );
        return $rules;
    }    
    
}
