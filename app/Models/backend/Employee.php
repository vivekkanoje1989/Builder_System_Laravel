<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models\backend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\classes\CommonFunctions;
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
 * @property string $remember_token
 * @property string $usertype
 * @property int $team_lead_id
 * @property string $designation
 * @property string $department_id
 * @property int $reporting_to_id
 * @property string $title
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property \Carbon\Carbon $date_of_birth
 * @property string $gender
 * @property int $marital_status
 * @property \Carbon\Carbon $marriage_date
 * @property int $blood_group_id
 * @property int $physic_status_id
 * @property string $physic_desc
 * @property int $mobile1_calling_code
 * @property string $personal_mobile_no1
 * @property int $mobile2_calling_code
 * @property string $personal_mobile_no2
 * @property int $landline_calling_code
 * @property int $landline_no
 * @property string $email
 * @property string $personal_email_id2
 * @property int $office_mobile_country_id
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
 * @property string $emp_photo_url
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
class Employee extends Authenticatable
{
    
        use Notifiable;
	public $timestamps = false;
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
		'physic_status_id' => 'int',
		'mobile1_calling_code' => 'int',
		'mobile2_calling_code' => 'int',
		'landline_calling_code' => 'int',
		'landline_no' => 'int',
		'office_mobile_country_id' => 'int',
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
//		'password',
//		'high_security_password',
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
		'designation',
		'department_id',
		'reporting_to_id',
		'title',
		'first_name',
		'middle_name',
		'last_name',
		'date_of_birth',
		'gender',
		'marital_status',
		'marriage_date',
		'blood_group_id',
		'physic_status_id',
		'physic_desc',
		'mobile1_calling_code',
		'personal_mobile_no1',
		'mobile2_calling_code',
		'personal_mobile_no2',
		'landline_calling_code',
		'landline_no',
		'email',
		'personal_email_id2',
		'office_mobile_country_id',
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
		'emp_photo_url',
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
        
    public static function getRecords($select,$where){
        $attributes = empty($select) ? '*' : $select;
        $getEmployeeRecords = Employee::select($attributes)->where($where)->get();
        return json_decode($getEmployeeRecords);
    }
    
    public static function validationMessages(){
        $messages = array(
            'username.required' => 'Please enter user name',
            'password.required' => 'Please enter password',
            'designation.required' => 'Please enter designation',
            'department_id.required' => 'Please enter department',
            'reporting_to_id.required' => 'Please enter reporting to',
            'title_id.required' => 'Please enter title',
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'date_of_birth.required' => 'Please enter birth date',
            'gender_id.required' => 'Please enter gender',
            'marital_status.required' => 'Please enter marital status',
            'physic_status_id.required' => 'Please enter physic status',
            'personal_mobile_no1' => ['required' => 'Please enter personal mobile number'],
            'office_mobile_no' => ['required' => 'Please enter office mobile number'],
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
            'emp_photo_url' => 'Please select photo',
            'joining_date' => 'Please enter joining date'
        );
        return $messages;
    }
    public static function validationRules(){
        $rules = array(
            'username' => 'required',
            'password' => 'required|max:12',
            'designation' => 'required',
            'department_id' => 'required',
            'reporting_to_id' => 'required',
            'title_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'gender_id' => 'required',
            'marital_status' => 'required',
            'blood_group_id' => 'required',
            'physic_status_id' => 'required',
            'personal_mobile_no1' => 'required',
            'office_mobile_no' => 'required',
            'email' => 'required|email|unique:employees',
            'personal_email_id2' => 'email',
            'office_email_id' => 'email',
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
            'emp_photo_url' => 'required',
            'joining_date' => 'required|date',
        );
        return $rules;
    }
    
    
    public static function createEmployee($input = array()) {
//        echo "in model<pre>";print_r($input);
//        $aa = Employee::create($input);
//        echo "in model<pre>";print_r($aa);exit;
        
        return Employee::create([
            
            'username' => $input['username'],
            'password' => $input['password'],
            'designation' => $input['designation'],
            'department_id' => implode(',', array_map(function($el){ return $el['id']; }, $input['department_id'])),
            'reporting_to_id' => $input['reporting_to_id'],
            'title_id' => $input['title_id'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'date_of_birth' => $input['date_of_birth'],
            'gender_id' => $input['gender_id'],
            'marital_status' => $input['marital_status'],
            'blood_group_id' => $input['blood_group_id'],
            'physic_status_id' => $input['physic_status_id'],
            'personal_mobile_no1' => $input['personal_mobile_no1'],
            'office_mobile_no' => $input['office_mobile_no'],
            'email' => $input['email'],
            'office_email_id' => !empty($input['office_email_id']) ? $input['office_email_id'] : "",
            'current_country_id' => $input['current_country_id'],
            'current_state_id' => $input['current_state_id'],
            'current_city_id' => $input['current_city_id'],
            'current_pin' => $input['current_pin'],
            'current_address' => $input['current_address'],
            'permenent_country_id' => $input['permenent_country_id'],
            'permenent_state_id' => $input['permenent_state_id'],
            'permenent_city_id' => $input['permenent_city_id'],
            'permenent_pin' => $input['permenent_pin'],
            'permenent_address' => $input['permenent_address'],
            'highest_education_id' => $input['highest_education_id'],
            'emp_photo_url' => $input['emp_photo_url'],
            'joining_date' => $input['joining_date'],
                    
                    
            'client_id' => !empty($input['client_id']) ? $input['client_id'] : "0",
            'client_role_id' => !empty($input['client_role_id']) ? $input['client_role_id'] : "1",
            'employee_id' => !empty($input['employee_id']) ? $input['employee_id'] : "1",
            'high_security_password_type' => !empty($input['high_security_password_type']) ? $input['high_security_password_type'] : "1",
            'high_security_password' => !empty($input['high_security_password']) ? $input['high_security_password'] : "8899",
            'password_changed' => !empty($input['password_changed']) ? $input['password_changed'] : "0",
            'remember_token' => !empty($input['remember_token']) ? $input['remember_token'] : str_random(10),
            'usertype' => !empty($input['usertype']) ? $input['usertype'] : "admin",
            'team_lead_id' => !empty($input['team_lead_id']) ? $input['team_lead_id'] : "1",           
            'middle_name' => !empty($input['middle_name']) ? $input['middle_name'] : "",
            'marriage_date' => !empty($input['marriage_date']) ? $input['marriage_date'] : "",
            'physic_desc' => !empty($input['physic_desc']) ? $input['physic_desc'] : "",
            'mobile1_calling_code' => !empty($input['mobile1_calling_code']) ? $input['mobile1_calling_code'] : "",
            'mobile2_calling_code' => !empty($input['mobile2_calling_code']) ? $input['mobile2_calling_code'] : "",
            'personal_mobile_no2' => !empty($input['personal_mobile_no2']) ? $input['personal_mobile_no2'] : "",
            'landline_calling_code' => !empty($input['landline_calling_code']) ? $input['landline_calling_code'] : "",
            'landline_no' => !empty($input['landline_no']) ? $input['landline_no'] : "",
            'personal_email_id2' => !empty($input['personal_email_id2']) ? $input['personal_email_id2'] : "",
            'office_mobile_country_id' => !empty($input['office_mobile_country_id']) ? $input['office_mobile_country_id'] : "",            
            'education_details' => !empty($input['education_details']) ? $input['education_details'] : "",
            'employee_status' => !empty($input['employee_status']) ? $input['employee_status'] : "",
            'show_on_homepage' => !empty($input['show_on_homepage']) ? $input['show_on_homepage'] : "1",
            'employee_submenus' => !empty($input['employee_submenus']) ? $input['employee_submenus'] : '["0101","0102","0103","0104"]',
            'employee_permissions' => !empty($input['employee_permissions']) ? $input['employee_permissions'] : "1",
            'employee_email_subscriptions' => !empty($input['employee_email_subscriptions']) ? $input['employee_email_subscriptions'] : "1",
            'employee_sms_subscrption' => !empty($input['employee_sms_subscrption']) ? $input['employee_sms_subscrption'] : "1",
            'employee_info_form_url' => !empty($input['employee_info_form_url']) ? $input['employee_info_form_url'] : "1",
            'employee_info_form_url_status' => !empty($input['employee_info_form_url_status']) ? $input['employee_info_form_url_status'] : "1",
            'created_date' => date('Y-m-d'),
            'created_by' => 1,
            'created_IP' => $_SERVER['REMOTE_ADDR'],
            'created_browser' => $_SERVER['HTTP_USER_AGENT'],
            'created_mac_id' => CommonFunctions::getMacAddress(),
//            'updated_date' => ,
//            'updated_by' => ,
//            'updated_IP' => ,
//            'updated_browser' => ,
//            'updated_mac_id' => ,
                    
        ]);
        exit;
    }
}
