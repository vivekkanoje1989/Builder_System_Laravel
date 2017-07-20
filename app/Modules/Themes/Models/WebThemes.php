<?php namespace App\Modules\Themes\Models;


use Reliese\Database\Eloquent\Model as Eloquent;

class WebThemes extends Eloquent {

		protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = [
        'status' => 'int'
    ];
    protected $fillable = [
        'id',
        'theme_name',
        'image_url',
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
