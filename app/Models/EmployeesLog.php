<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 05 Apr 2017 16:41:34 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeesLog
 * 
 * @property int $id
 * @property int $main_record_id
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
 * @property int $team_lead_id
 * @property string $designation_id
 * @property string $department_id
 * @property int $reporting_to_id
 * @property int $title_id
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
 * @property string $personal_landline_no
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
 * @property string $employee_photo_file _name
 * @property \Carbon\Carbon $joining_date
 * @property int $employee_status
 * @property bool $show_on_homepage
 * @property string $employee_submenus
 * @property string $employee_permissions
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
		'main_record_id' => 'int',
		'client_id' => 'int',
		'client_role_id' => 'int',
		'employee_id' => 'int',
		'high_security_password_type' => 'int',
		'high_security_password' => 'int',
		'password_changed' => 'int',
		'team_lead_id' => 'int',
		'reporting_to_id' => 'int',
		'title_id' => 'int',
		'marital_status' => 'int',
		'blood_group_id' => 'int',
		'physic_status' => 'int',
		'personal_mobile1_calling_code' => 'int',
		'personal_mobile2_calling_code' => 'int',
		'personal_landline_calling_code' => 'int',
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
		'mobile_remember_token',
		'remember_token'
	];

	protected $fillable = [
		'main_record_id',
		'client_id',
		'client_role_id',
		'employee_id',
		'username',
		'password',
		'high_security_password_type',
		'high_security_password',
		'password_changed',
		'mobile_remember_token',
		'remember_token',
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
		'employee_photo_file _name',
		'joining_date',
		'employee_status',
		'show_on_homepage',
		'employee_submenus',
		'employee_permissions',
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
