<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Modules\ContactUs\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * 
 * 
 * 
 * 
 *
 * @package App\Models
 */
class WebContactus extends Eloquent {

    protected $primaryKey = 'id';
    public $timestamps = false;
    public $table = 'web_contactus';
    protected $fillable = [
        'id',
        'email',
        'country_id',
        'state_id',
        'city_id',
        'location_type_id',
        'contact_number1',
        'contact_number2',
        'contact_number3',
        'pin_code',
        'contact_person_name',
        'address',
        'created_date',
        'created_at',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_at',
        'updated_by',
        'updated_IP',
        'updated_browser',
        'updated_mac_id',
    ];

    
}
