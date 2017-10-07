<?php 

namespace App\Modules\Testimonials\Models;


use Reliese\Database\Eloquent\Model as Eloquent;


class WebTestimonials extends Eloquent {

	protected $primaryKey = 'testimonial_id';
    public $timestamps = false;
    protected $casts = [
        'testimonial_id' => 'int'
    ];
    protected $fillable = [
        'testimonial_id',
        'testimonial_designation_id',
        'customer_name',
        'photo_url',
        'video_url',
        'company_name',
        'testimonial',
        'description',
        'mobile_number',
        'web_status',
        'approve_status',
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
    
    public static function validationMessages() {
        $messages = array(
            'customer_name.required' => 'Please enter customer name.',
            'company_name.required' => 'Please enter company name.',
            'mobile_number.required' => 'Please enter mobile number.',
            'photo_url' => 'Please upload photo.',
            'description' => 'Please enter description.'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'customer_name' => 'required',
            'company_name' => 'required',
            'mobile_number' => 'required',
            'photo_url' => 'required',
            'description' => 'required'
        );
        return $rules;
    }
    
    public static function validationMessages1() {
        $messages = array(
            'customer_name.required' => 'Please enter customer name.',
            'company_name.required' => 'Please enter company name.',
            'mobile_number.required' => 'Please enter mobile number.',
            'description' => 'Please enter description.',
            'approve_status' => 'Please select status.'
        );
        return $messages;
    }

    public static function validationRules1() {
        $rules = array(
            'customer_name' => 'required',
            'company_name' => 'required',
            'mobile_number' => 'required',
            'description' => 'required',
            'approve_status' => 'required'
        );
        return $rules;
    }

}
