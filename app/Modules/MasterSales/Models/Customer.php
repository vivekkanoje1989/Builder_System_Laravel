<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Feb 2017 14:08:01 +0530.
 */
namespace App\Modules\MasterSales\Models;

use Illuminate\Database\Eloquent\Model;

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
class Customer extends Model
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
            'title_id.required' => 'Please enter title',
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'gender_id.required' => 'Please enter gender',
            'profession_id.required' => 'Please enter profession',
            'monthly_income' => ['required' => 'Please enter monthly income', 'numeric' => 'Monthly income must be numbers'],
            'pan_number.required' => 'Please enter pan number',
            'aadhar_number.required' => 'Please enter aadhar number',
            'birth_date.required' => 'Please select birth date',
            'marriage_date.required' => 'Please select marriage date',
            'source_id.required' => 'Please select source',
            'subsource_id.required' => 'Please select sub source',
            'source_description.required' => 'Please enter source description'
        );
        return $messages;
    }
    public static function validationRules(){
        $rules = array(
            'title_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'gender_id' => 'required',
            'profession_id' => 'required',
            'monthly_income' => 'required|numeric',
            'pan_number' => 'required',
            'aadhar_number' => 'required|numeric',
            'birth_date' => 'required',
            'marriage_date' => 'required',
            'source_id' => 'required|numeric',
            'subsource_id' => 'required|numeric',
            'source_description' => 'required'
        );
        return $rules;
    }
    public static function doAction($input){        
        $input['customerData']['birth_date'] =  date('Y-m-d', strtotime($input['customerData']['birth_date']));
        $input['customerData']['marriage_date'] =  date('Y-m-d', strtotime($input['customerData']['marriage_date']));
    }
}
