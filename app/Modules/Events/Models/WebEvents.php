<?php

namespace App\Modules\Events\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class WebEvents extends Eloquent {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'description',
        'gallery',
        'status',
        'projects_id',
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
        'deleted_IP', 
        'deleted_browser',
        'deleted_mac_id'
    ];

}
