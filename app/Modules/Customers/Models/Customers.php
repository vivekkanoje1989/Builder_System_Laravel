<?php

namespace App\Modules\Customers\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class Customers extends Eloquent {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'client_id',
        'title_id',
        'first_name',
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
        'created_at',
        'created_by',
        'created_IP',
        'created_mac_id',
        'created_browser',
        'updated_date',
        'updated_at',
        'updated_by',
        'updated_IP',
        'deleted_status',
        'deleted_date',
        'deleted_by',
        'deleted_IP', 'deleted_browser',
        'deleted_mac_id'
    ];

    public static function validationMessages() {
        $messages = array(
            'title_id.required' => 'Please enter title',
            'first_name.required' => 'Please enter first name',
            'last_name.required' => 'Please enter last name',
            'gender_id.required' => 'Please enter gender',
            'profession_id.required' => 'Please enter profession',
            'monthly_income' => ['required' => 'Please enter monthly income', 'numeric' => 'Monthly income must be numbers'],
            'birth_date.required' => 'Please select birth date',
            'source_id.required' => 'Please select source',
            'source_description.required' => 'Please enter source description',
            'aadhar_number.required' => 'Please enter aadhar number',
            'sms_privacy_status.required' => 'Please enter aadhar number',
            'email_privacy_status.required' => 'Please enter aadhar number'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'title_id' => 'required',
            'first_name' => 'required|max:15',
            'middle_name' => 'max:15',
            'last_name' => 'required|max:15',
            'gender_id' => 'required',
            'profession_id' => 'required',
            'monthly_income' => 'required|numeric|max:999999',
            'birth_date' => 'required|date',
            'source_id' => 'required|numeric',
            'subsource_id' => 'numeric',
            'source_description' => 'required',
            'aadhar_number' => 'required',
            'email_privacy_status' => 'required',
            'sms_privacy_status' => 'required'
        );
        return $rules;
    }

    public function getTitle() {
        return $this->hasOne('App\Models\MlstTitle', 'id', 'title_id')->select("id", "title");
    }

    public function getProfession() {
        return $this->hasOne('App\Models\MlstProfession', 'id', 'profession_id')->select("id", "profession");
    }

    public function getSource() {
        return $this->hasOne('App\Models\MlstBmsbEnquirySalesSource', 'id', 'source_id')->select("id", "sales_source_name");
    }

}
