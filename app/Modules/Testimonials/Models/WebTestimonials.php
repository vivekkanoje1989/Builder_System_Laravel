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

}
