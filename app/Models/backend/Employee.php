<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models\backend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Classes\CommonFunctions;
use Illuminate\Hashing\HashServiceProvider;

/**
 * Class Employee
 * 
 * @property int $id
 * @property int $client_id
 * @property int $client_role_id
 * @property int $employee_id
 * @property string $username
 * @property string $password
 * @property int $high_security_password_type
 * @property int $high_security_password
 * @property int $password_changed
 * @property string $mobile_remember_token
 * @property string $remember_token
 * @property string $usertype
 * @property int $team_lead_id
 * @property string $designation_id
 * @property string $department_id
 * @property int $reporting_to_id
 * @property string $title_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property \Carbon\Carbon $date_of_birth
 * @property string $gender_id
 * @property int $marital_status
 * @property \Carbon\Carbon $marriage_date
 * @property int $blood_group_id
 * @property int $physic_status
 * @property string $physic_desc
 * @property int $personal_mobile1_calling_code
 * @property string $personal_mobile1
 * @property int $personal_mobile2_calling_code
 * @property string $personal_mobile2
 * @property int $personal_landline_calling_code
 * @property int $personal_landline_no
 * @property string $personal_email1
 * @property string $personal_email2
 * @property int $office_mobile_calling_code
 * @property string $office_mobile_no
 * @property string $office_email_id
 * @property int $current_country_id
 * @property int $current_state_id
 * @property int $current_city_id
 * @property int $current_pin
 * @property string $current_address
 * @property int $permenent_country_id
 * @property int $permenent_state_id
 * @property int $permenent_city_id
 * @property int $permenent_pin
 * @property string $permenent_address
 * @property int $highest_education_id
 * @property string $education_details
 * @property string $employee_photo_file_name
 * @property \Carbon\Carbon $joining_date
 * @property int $employee_status
 * @property bool $show_on_homepage
 * @property string $employee_submenus
 * @property string $employee_permissions
 * @property string $employee_email_subscriptions
 * @property string $employee_sms_subscrption
 * @property string $employee_info_form_url
 * @property int $employee_info_form_url_status
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
 *
 * @package App\Models
 */
class Employee extends Authenticatable {

    use Notifiable;

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $casts = [
        'client_id' => 'int',
        'client_role_id' => 'int',
        'employee_id' => 'int',
        'high_security_password_type' => 'int',
        'high_security_password' => 'int',
        'password_changed' => 'int',
        'team_lead_id' => 'int',
        'reporting_to_id' => 'int',
        'marital_status' => 'int',
        'blood_group_id' => 'int',
        'physic_status' => 'int',
        'personal_mobile1_calling_code' => 'int',
        'personal_mobile2_calling_code' => 'int',
        'personal_landline_calling_code' => 'int',
        'personal_landline_no' => 'int',
        'office_mobile_calling_code' => 'int',
        'current_country_id' => 'int',
        'current_state_id' => 'int',
        'current_city_id' => 'int',
        'current_pin' => 'int',
        'permenent_country_id' => 'int',
        'permenent_state_id' => 'int',
        'permenent_city_id' => 'int',
        'permenent_pin' => 'int',
        'highest_education_id' => 'int',
        'employee_status' => 'int',
        'show_on_homepage' => 'bool',
        'employee_info_form_url_status' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];
    protected $dates = [
        'date_of_birth',
        'marriage_date',
        'joining_date',
        'created_date',
        'updated_date'
    ];
    protected $hidden = [
        'remember_token'
    ];
    protected $fillable = [
        'client_id',
        'client_role_id',
        'employee_id',
        'username',
        'password',
        'high_security_password_type',
        'high_security_password',
        'password_changed',
        'remember_token',
        'usertype',
        'team_lead_id',
        'designation_id',
        'department_id',
        'reporting_to_id',
        'title_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender_id',
        'marital_status',
        'marriage_date',
        'blood_group_id',
        'physic_status',
        'physic_desc',
        'personal_mobile1_calling_code',
        'personal_mobile1',
        'personal_mobile2_calling_code',
        'personal_mobile2',
        'personal_landline_calling_code',
        'personal_landline_no',
        'personal_email1',
        'personal_email2',
        'office_mobile_calling_code',
        'office_mobile_no',
        'office_email_id',
        'current_country_id',
        'current_state_id',
        'current_city_id',
        'current_pin',
        'current_address',
        'permenent_country_id',
        'permenent_state_id',
        'permenent_city_id',
        'permenent_pin',
        'permenent_address',
        'highest_education_id',
        'education_details',
        'employee_photo_file_name',
        'joining_date',
        'employee_status',
        'show_on_homepage',
        'employee_submenus',
        'employee_permissions',
        'employee_email_subscriptions',
        'employee_sms_subscrption',
        'employee_info_form_url',
        'employee_info_form_url_status',
        'created_date',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_by',
        'updated_IP',
        'updated_browser',
        'updated_mac_id'
    ];

    public static function getRecords($select, $where) {
        $attributes = empty($select) ? '*' : $select;
        $getEmployeeRecords = Employee::select($attributes)->where($where)->get();
        return json_decode($getEmployeeRecords);
    }

    public static function validationMessages() {
        $messages = array(
            'username.required' => 'Please enter user name',
            'username.numeric' => 'Please enter user name numeric',
            'password.numeric' => 'Please enter password numeric',
            'password.required' => 'Please enter password',
            'designation_id.required' => 'Please enter designation_id',
            'department_id.required' => 'Please enter department',
//            'reporting_to_id.required' => 'Please enter reporting to',
            'title_id.required' => 'Please enter title_id',
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'date_of_birth.required' => 'Please enter birth date',
            'gender_id.required' => 'Please enter gender_id',
            'marital_status.required' => 'Please enter marital status',
            'physic_status.required' => 'Please enter physic status',
            'personal_mobile1.required' => 'Please enter personal mobile number',
            'office_mobile_no.required' => 'Please enter office mobile number',
            'current_country_id.required' => 'Please enter current country',
            'current_state_id.required' => 'Please enter current state',
            'current_city_id.required' => 'Please enter current city',
            'current_pin.required' => 'Please enter current pin code',
            'current_address.required' => 'Please enter current address',
            'permenent_country_id.required' => 'Please enter permenent country',
            'permenent_state_id' => 'Please enter permenent state',
            'permenent_city_id' => 'Please enter permenent city',
            'permenent_pin' => 'Please enter permenent pin code',
            'permenent_address' => 'Please enter permenent address',
            'highest_education_id' => 'Please enter highest education',
            'joining_date' => 'Please enter joining date'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'username' => 'required|numeric',
            'password' => 'required|max:6',
            'designation_id' => 'required',
            'department_id' => 'required',
//            'reporting_to_id' => 'required',
            'title_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'gender_id' => 'required',
            'marital_status' => 'required',
            'blood_group_id' => 'required',
            'physic_status' => 'required',
            'personal_mobile1' => 'required',
            'office_mobile_no' => 'required',
            'personal_email1' => 'required|email|unique:employees',
            'current_country_id' => 'required',
            'current_state_id' => 'required',
            'current_city_id' => 'required',
            'current_pin' => 'required',
            'current_address' => 'required',
            'permenent_country_id' => 'required',
            'permenent_state_id' => 'required',
            'permenent_city_id' => 'required',
            'permenent_pin' => 'required',
            'permenent_address' => 'required',
            'highest_education_id' => 'required',
            'joining_date' => 'required|date',
        );
        return $rules;
    }
    
    public function designationName()
    {
        return $this->belongsTo('App\Models\MlstBmsbDesignation', 'id')->where("employees.designation_id", 'id'); //(designation model name, primary of designation model) 
    }
    
    public static function doAction($input) {
        if (!empty($input['userData']['departmentid'])) {
            $input['userData']['department_id'] = $input['userData']['departmentid'];
        } else {
            $input['userData']['department_id'] = implode(',', array_map(function($el) {
                        return $el['id'];
            }, $input['userData']['department_id']));
        }
        $input['userData']['date_of_birth'] = date('Y-m-d', strtotime($input['userData']['date_of_birth']));
        $input['userData']['joining_date'] = date('Y-m-d', strtotime($input['userData']['joining_date']));

        $input['userData']['client_id'] = !empty($input['client_id']) ? $input['userData']['client_id'] : "0";
        $input['userData']['client_role_id'] = "1";
        $input['userData']['employee_id'] = !empty($input['userData']['employee_id']) ? $input['userData']['employee_id'] :1;
        $input['userData']['high_security_password_type'] = !empty($input['userData']['high_security_password_type']) ? $input['userData']['high_security_password_type'] : "0";
        $input['userData']['high_security_password'] = (!empty($input['userData']['high_security_password']) && $input['userData']['high_security_password_type'] == 1) ? $input['userData']['high_security_password'] : "";
        $input['userData']['password_changed'] = !empty($input['userData']['password_changed']) ? $input['userData']['password_changed'] : "0";
        $input['userData']['remember_token'] = \Hash::make(str_random(6));
        $input['userData']['team_lead_id'] = !empty($input['userData']['team_lead_id']) ? $input['userData']['team_lead_id'] : "1";
        $input['userData']['middle_name'] = !empty($input['userData']['middle_name']) ? $input['userData']['middle_name'] : "";

        if (empty($input['userData']['marriage_date']) || $input['userData']['marriage_date'] == "0000-00-00") {

            $input['userData']['marriage_date'] = "";
        } else {
            $input['userData']['marriage_date'] = !empty($input['userData']['marriage_date']) ? date('Y-m-d', strtotime($input['userData']['marriage_date'])) : "";
        }
        $input['userData']['physic_desc'] = !empty($input['userData']['physic_desc']) ? $input['userData']['physic_desc'] : NULL;

        $personalMobileNo1 = explode("-", $input['userData']['personal_mobile1']);
        $input['userData']['personal_mobile1_calling_code'] = (int) $personalMobileNo1[0];
        $input['userData']['personal_mobile1'] = $personalMobileNo1[1];

        if (!empty($input['userData']['personal_mobile2'])) {
            $personalMobileNo2 = explode("-", $input['userData']['personal_mobile2']);
            $input['userData']['personal_mobile2_calling_code'] = (int) $personalMobileNo2[0];
            $input['userData']['personal_mobile2'] = !empty($personalMobileNo2[1]) ? $personalMobileNo2[1] : NULL;
            $input['userData']['personal_mobile2_calling_code'] = !empty($input['userData']['personal_mobile2']) ? $input['userData']['personal_mobile2_calling_code'] : NULL;
        }

        if (!empty($input['userData']['office_mobile_no'])) {
            $officeMobileNo = explode("-", $input['userData']['office_mobile_no']);
            $input['userData']['office_mobile_calling_code'] = (int) $officeMobileNo[0];
            $input['userData']['office_mobile_no'] = $officeMobileNo[1];
        }

        if (!empty($input['userData']['personal_landline_no'])) {
            $landlineNo = explode("-", $input['userData']['personal_landline_no']);
            $input['userData']['personal_landline_calling_code'] = !empty($landlineNo[1]) ? (int) $landlineNo[0] : NULL;
            $input['userData']['personal_landline_no'] = (!empty($landlineNo[1])) ? $landlineNo[1] : "";
        }
        $input['userData']['education_details'] = !empty($input['userData']['education_details']) ? $input['userData']['education_details'] : "";
        $input['userData']['show_on_homepage'] = !empty($input['userData']['show_on_homepage']) ? $input['userData']['show_on_homepage'] : "1";
        $input['userData']['employee_submenus'] = !empty($input['userData']['employee_submenus']) ? $input['userData']['employee_submenus'] : '[]';
        $input['userData']['employee_permissions'] = !empty($input['userData']['employee_permissions']) ? $input['userData']['employee_permissions'] : "1";
        $input['userData']['employee_info_form_url'] = !empty($input['userData']['employee_info_form_url']) ? $input['userData']['employee_info_form_url'] : "1";
        $input['userData']['employee_info_form_url_status'] = !empty($input['userData']['employee_info_form_url_status']) ? $input['userData']['employee_info_form_url_status'] : "1";
        return $input;
    }


}
