<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Feb 2017 14:08:01 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Customer
 * 
 * @property int $id
 * @property int $client_id
 * @property int $title_id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property int $gender_id
 * @property int $profession_id
 * @property int $monthly_income
 * @property string $pan_number
 * @property int $aadhar_number
 * @property string $image_file
 * @property \Carbon\Carbon $birth_date
 * @property \Carbon\Carbon $marriage_date
 * @property int $source_id
 * @property int $subsource_id
 * @property string $source_description
 * @property int $sms_privacy_status
 * @property int $email_privacy_status
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
class Customer extends Eloquent
{
	protected $casts = [
		'client_id' => 'int',
		'title_id' => 'int',
		'gender_id' => 'int',
		'profession_id' => 'int',
		'monthly_income' => 'int',
		'aadhar_number' => 'int',
		'source_id' => 'int',
		'subsource_id' => 'int',
		'sms_privacy_status' => 'int',
		'email_privacy_status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'birth_date',
		'marriage_date',
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
		'title_id',
		'first_name',
		'middle_name',
		'last_name',
		'gender_id',
		'profession_id',
		'monthly_income',
		'pan_number',
		'aadhar_number',
		'image_file',
		'birth_date',
		'marriage_date',
		'source_id',
		'subsource_id',
		'source_description',
		'sms_privacy_status',
		'email_privacy_status',
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
        
    public static function validationMessages(){
        $messages = array(
            'username.required' => 'Please enter user name',
            'username.numeric' => 'Please enter user name numeric',
            'password.numeric' => 'Please enter password numeric',
            'password.required' => 'Please enter password',
            'designation.required' => 'Please enter designation',
            'department_id.required' => 'Please enter department',
            'reporting_to_id.required' => 'Please enter reporting to',
            'title.required' => 'Please enter title',
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'date_of_birth.required' => 'Please enter birth date',
            'gender.required' => 'Please enter gender',
            'marital_status.required' => 'Please enter marital status',
            'physic_status_id.required' => 'Please enter physic status',
            'personal_mobile_no1.required' => 'Please enter personal mobile number',
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
    public static function validationRules(){
        $rules = array(
            'username' => 'required|numeric',
            'password' => 'required|max:6',
            'designation' => 'required',
            'department_id' => 'required',
            'reporting_to_id' => 'required',
            'title' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
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
            'joining_date' => 'required|date',
        );
        return $rules;
    }
}
