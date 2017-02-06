<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 17 Jan 2017 11:45:51 +0000.
 */

/**
 * Class Employee
 * 
 * @property int $id
 * @property int $client_role_id
 * @property int $employee_id
 * @property string $username
 * @property string $password
 * @property int $password_changed
 * @property string $remember_token
 * @property string $usertype
 * @property int $team_lead_id
 * @property string $designation
 * @property string $department_id
 * @property int $reporting_to_id
 * @property int $title_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property \Carbon\Carbon $date_of_birth
 * @property int $gender_id
 * @property int $marital_status
 * @property \Carbon\Carbon $marriage_date
 * @property int $blood_group_id
 * @property int $physic_status_id
 * @property string $physic_desc
 * @property int $mobile1_country_id
 * @property string $personal_mobile_no1
 * @property int $mobile2_country_id
 * @property string $personal_mobile_no2
 * @property int $landline_country_id
 * @property int $landline_no
 * @property string $personal_email_id1
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
 * @property int $show_on_homepage
 * @property string $employee_submenus
 * @property string $employee_permissions
 * @property string $employee_email_subscriptions
 * @property string $employee_sms_subscrption
 * @property string $employee_info_form_url
 * @property int $employee_info_form_url_status
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
 *
 * @package App\Models
 */
//class Employee extends Eloquent
//{
namespace App\Models\backend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Employee extends Authenticatable
{
    use Notifiable;
	public $timestamps = false;

	protected $casts = [
		'client_role_id' => 'int',
		'employee_id' => 'int',
		'password_changed' => 'int',
		'team_lead_id' => 'int',
		'reporting_to_id' => 'int',
		'title_id' => 'int',
		'gender_id' => 'int',
		'marital_status' => 'int',
		'blood_group_id' => 'int',
		'physic_status_id' => 'int',
		'mobile1_country_id' => 'int',
		'mobile2_country_id' => 'int',
		'landline_country_id' => 'int',
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
		'show_on_homepage' => 'int',
		'employee_info_form_url_status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'date_of_birth',
		'marriage_date',
		'joining_date',
		'created_date',
		'created_time',
		'updated_date',
		'updated_time'
	];

	protected $hidden = [
//		'password',
	];

	protected $fillable = [
		'client_role_id',
		'employee_id',
		'username',
		'password',
		'password_changed',
		'remember_token',
		'usertype',
		'team_lead_id',
		'designation',
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
		'physic_status_id',
		'physic_desc',
		'mobile1_country_id',
		'personal_mobile_no1',
		'mobile2_country_id',
		'personal_mobile_no2',
		'landline_country_id',
		'landline_no',
		'email',//personal_email_id1
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
                'high_security_password',
                'flag_high_security_password'
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
            'personal_email_id' => 'email',
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
}


/*Delimiter//
CREATE PROCEDURE get_employees
(
IN client_role_id int(11),
employee_id int(11), 
username int(11),
password int(11),
password_changed int(11),
remember_token int(11),
usertype int(11),
team_lead_id int(11),
designation int(11),
department_id int(11),
reporting_to_id int(11),
title_id int(11),
first_name int(11),
middle_name int(11),
last_name int(11),
date_of_birth int(11),
gender_id int(11),
marital_status int(11),
marriage_date int(11),
blood_group_id int(11),
physic_status_id int(11),
physic_desc int(11),
mobile1_country_id int(11),
personal_mobile_no1 int(11),
mobile2_country_id int(11),
personal_mobile_no2 int(11),
landline_country_id int(11) int(11),
landline_no int(11) int(11),
email int(11),
personal_email_id2 int(11),
office_mobile_country_id int(11),
office_mobile_no int(11),
office_email_id int(11),
current_country_id int(11),
current_state_id int(11),
current_city_id int(11),
current_pin int(11),
current_address int(11),
permenent_country_id int(11),
permenent_state_id int(11),
permenent_city_id int(11),
permenent_pin int(11),
permenent_address int(11),
highest_education_id int(11),
education_details int(11),
emp_photo_url int(11),
joining_date int(11),
employee_status int(11),
show_on_homepage int(11),
employee_submenus int(11),
employee_permissions int(11),
employee_email_subscriptions int(11),
employee_sms_subscrption int(11),
employee_info_form_url int(11),
employee_info_form_url_status int(11),
created_date int(11),
created_time int(11),
created_by int(11),
created_IP int(11),
created_browser int(11),
created_mac_id int(11),
updated_date int(11),
updated_time int(11),
updated_by int(11),
updated_IP int(11),
updated_browser int(11),
updated_mac_id int(11)
)

BEGIN
    SELECT client_role_id,
employee_id, 
username,
password,
password_changed,
remember_token,
usertype,
team_lead_id,
designation,
department_id,
reporting_to_id,
title_id,
first_name,
middle_name,
last_name,
date_of_birth,
gender_id,
marital_status,
marriage_date,
blood_group_id,
physic_status_id,
physic_desc,
mobile1_country_id,
personal_mobile_no1,
mobile2_country_id,
personal_mobile_no2,
landline_country_id,
landline_no,
email,
personal_email_id2,
office_mobile_country_id,
office_mobile_no,
office_email_id,
current_country_id,
current_state_id,
current_city_id,
current_pin,
current_address,
permenent_country_id,
permenent_state_id,
permenent_city_id,
permenent_pin,
permenent_address,
highest_education_id,
education_details,
emp_photo_url,
joining_date,
employee_status,
show_on_homepage,
employee_submenus,
employee_permissions,
employee_email_subscriptions,
employee_sms_subscrption,
employee_info_form_url,
employee_info_form_url_status,
created_date,
created_time,
created_by,
created_IP,
created_browser,
created_mac_id,
updated_date,
updated_time,
updated_by,
updated_IP,
updated_browser,
updated_mac_id)    
INTO client_role_id,
employee_id, 
username,
password,
password_changed,
remember_token,
usertype,
team_lead_id,
designation,
department_id,
reporting_to_id,
title_id,
first_name,
middle_name,
last_name,
date_of_birth,
gender_id,
marital_status,
marriage_date,
blood_group_id,
physic_status_id,
physic_desc,
mobile1_country_id,
personal_mobile_no1,
mobile2_country_id,
personal_mobile_no2,
landline_country_id,
landline_no,
email,
personal_email_id2,
office_mobile_country_id,
office_mobile_no,
office_email_id,
current_country_id,
current_state_id,
current_city_id,
current_pin,
current_address,
permenent_country_id,
permenent_state_id,
permenent_city_id,
permenent_pin,
permenent_address,
highest_education_id,
education_details,
emp_photo_url,
joining_date,
employee_status,
show_on_homepage,
employee_submenus,
employee_permissions,
employee_email_subscriptions,
employee_sms_subscrption,
employee_info_form_url,
employee_info_form_url_status,
created_date,
created_time,
created_by,
created_IP,
created_browser,
created_mac_id,
updated_date,
updated_time,
updated_by,
updated_IP,
updated_browser,
updated_mac_id 
FROM employees
WHERE 
    users_id = userId;
END             


*/


