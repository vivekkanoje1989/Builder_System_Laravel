<?php 

namespace App\Modules\Testimonials\Models;


use Reliese\Database\Eloquent\Model as Eloquent;


class Testimonials extends Eloquent {

	protected $primaryKey = 'testimonial_id';
    public $timestamps = false;
    protected $casts = [
        'testimonial_id' => 'int'
    ];
    protected $fillable = [
        'testimonial_id',
        'testimonial_designation_id',
        'person_name',
        'photo_src',
        'video_url',
        'company_name',
        'testimonial',
        'mobile_no',
        'is_shown',
        'is_approve',
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
