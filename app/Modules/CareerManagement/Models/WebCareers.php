<?php

namespace App\Modules\CareerManagement\Models;

use Illuminate\Database\Eloquent\Model;

class WebCareers extends Model {

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
    
    public static function validationMessages() {
        $messages = array(
            'job_title.required' => 'Please enter job title.',
            'job_eligibility.required' => 'Please enter job eligibility.',
            'job_locations.required' => 'Please enter job location.',
            'job_role' => 'Please enter job role.',
            'job_responsibilities' => 'Please enter job responsibility.',
            'application_start_date' => 'Please select application start date.',
            'application_close_date' => 'Please enter application close date.',
            'number_of_positions' => 'Please enter number of positions.'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'job_title' => 'required',
            'job_eligibility' => 'required',
            'job_locations' => 'required',
            'job_role' => 'required',
            'job_responsibilities' => 'required',
            'application_start_date' => 'required',
            'application_close_date' => 'required',
            'number_of_positions' => 'required'
        );
        return $rules;
    }


}
