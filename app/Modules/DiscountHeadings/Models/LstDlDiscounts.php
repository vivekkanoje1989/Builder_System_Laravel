<?php

namespace App\Modules\DiscountHeadings\Models;
use Reliese\Database\Eloquent\Model as Eloquent;

class LstDlDiscounts extends Eloquent {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'discount_name',
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
