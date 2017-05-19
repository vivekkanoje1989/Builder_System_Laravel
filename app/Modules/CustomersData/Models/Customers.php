<?php namespace App\Modules\CustomersData\Models;

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
        'marriage_date','source_id',
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
        'deleted_IP','deleted_browser',
        'deleted_mac_id'
    ];

}
