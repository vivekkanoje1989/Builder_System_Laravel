<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 01 Apr 2017 15:23:53 +0530.
 */

namespace App\Modules\PropertyPortals\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstPropertyPortalsConfig
 * 
 * @property int $id
 * @property int $api_type
 * @property int $property_portal_id
 * @property string $username
 * @property string $password
 * @property string $api_key
 * @property string $portal_name
 * @property int $enquiry_alocation_types
 * @property string $employee_id
 * @property int $project_id
 * @property int $status
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
class LstPropertyPortalsConfig extends Eloquent {

    protected $casts = [
        'api_type' => 'int',
        'property_portal_id' => 'int',
        'enquiry_alocation_types' => 'int',
        'project_id' => 'int',
        'status' => 'int',
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
        'updated_date',
        'deleted_date'
    ];
//	protected $hidden = [
//		'password'
//	];

    protected $fillable = [
        'api_type',
        'property_portal_id',
        'username',
        'password',
        'api_key',
        'portal_name',
        'enquiry_alocation_types',
        'employee_id',
        'project_id',
        'status',
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

    public static function validationMessages() {
        $messages = array(
            'portal_name.required' => 'Please enter account name.',
            'enquiry_alocation_types.required' => 'This field is required.'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'portal_name' => 'required',
            'enquiry_alocation_types' => 'required'
        );
        return $rules;
    }

    public static function validationMessages1() {
        $messages = array(
            'employee_id.required' => 'Please select employee.',
            'portal_name.required' => 'Please enter account name.',
            'enquiry_alocation_types.required' => 'This field is required.'
        );
        return $messages;
    }

    public static function validationRules1() {
        $rules = array(
            'employee_id' => 'required',
             'portal_name' => 'required',
            'enquiry_alocation_types' => 'required'
        );
        return $rules;
    }

}
