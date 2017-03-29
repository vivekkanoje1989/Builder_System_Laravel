<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Mar 2017 14:54:44 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeesLog
 * 
 * @property int $id
 * @property int $client_id
 * @property int $main_record_id
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
 * @property string $landline_no
 * @property string $email
 * @property string $personal_email_id2
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
 * @property int $record_type
 * @property string $column_names
 * @property int $record_restore_status
 *
 * @package App\Models
 */
class EmployeesLog extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'main_record_id' => 'int',
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
		'record_type' => 'int',
		'record_restore_status' => 'int'
	];

	protected $dates = [
		'date_of_birth',
		'marriage_date',
		'joining_date',
		'created_date'
	];

	protected $hidden = [
		'password',
		'high_security_password',
		'remember_token'
	];

	protected $fillable = [
		'client_id',
		'main_record_id',
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
		'record_type',
		'column_names',
		'record_restore_status'
	];
}
