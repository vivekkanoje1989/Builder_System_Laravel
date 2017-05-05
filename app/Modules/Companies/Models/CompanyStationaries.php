<?php

namespace App\Modules\Companies\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyStationaries extends Model {

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'id' => 'int'
    ];
    protected $fillable = [
        'id',
        'company_id',
        'stationary_set_name',
        'estimate_letterhead_file',
        'estimate_logo_file',
        'demandletter_letterhead_file',
        'demandletter_logo_file',
        'receipt_letterhead_file',
        'receipt_logo_file',
        'rubber_stamp_file',
        'status',
        'created_date',
        'created_at',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_at',
        'updated_IP',
        'updated_mac_id',
        'updated_browser'
    ];

}
