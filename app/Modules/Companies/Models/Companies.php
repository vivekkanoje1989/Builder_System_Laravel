<?php

namespace App\Modules\Companies\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model {

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'id' => 'int',
         'client_id'=>'int',
    ];
    protected $fillable = [
        'id',
        'client_id',
        'punch_line',
        'legal_name',
        'receipt_number_alias',
        'firm_logo',
        'pan_number',
        'tan_number',
        'type_of_company',
        'company_register_no',
        'marketing_name',
        'pin_code',
        'country_id',
        'state_id',
        'state_code',
        'fevicon',
        'contact_person',
        'vat_number',
        'office_address',
        'gst_number',
        'cloud_telephoney_client',
        'domain_name',
        'created_date',
        'created_at',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_at',
        'updated_IP',
        'updated_mac_id',
        'updated_browser'
    ];

    public static function validationMessages() {
        $messages = array(
            'legal_name.required' => 'Please enter legal name.',
            'punch_line.required' => 'Please enter punch line.',
           
            'office_address' => 'Please enter address.'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'legal_name' => 'required',
            'punch_line' => 'required',
           
            'office_address' => 'required'
        );
        return $rules;
    }

}
