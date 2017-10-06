<?php

namespace App\Modules\CareerManagement\Models;

use Illuminate\Database\Eloquent\Model;

class WebCareersApplications extends Model {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'first_name',
        'career_id',
        'last_name',
        'mobile_number',
        'email_id',
        'resume_file_name',
        'photo_url',
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
        'deleted_status',
        'deleted_date',
        'deleted_by',
        'deleted_IP',
        'deleted_browser',
        'deleted_mac_id',
    ];

}
