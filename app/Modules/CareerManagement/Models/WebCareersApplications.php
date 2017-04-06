<?php

namespace App\Modules\CareerManagement\Models;

use Illuminate\Database\Eloquent\Model;

class WebCareersApplications extends Model {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'job_title',
        'job_eligibility',
        'job_locations',
        'job_role',
        'job_responsibilities',
        'application_start_date',
        'application_close_date',
        'number_of_positions',
        'approved_by',
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
