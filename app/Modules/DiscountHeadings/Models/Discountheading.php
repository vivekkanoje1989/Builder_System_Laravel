<?php

namespace App\Modules\DiscountHeadings\Models;
use Reliese\Database\Eloquent\Model as Eloquent;

class MlstEducations extends Eloquent {

    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    public $timestamps = false;
    protected $fillable = [
        'education',
        'id',
        'status',
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
