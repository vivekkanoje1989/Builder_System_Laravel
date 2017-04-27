<?php

namespace App\Modules\Companies\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model {

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'id' => 'int'
    ];
    protected $fillable = [
        'id',
        'punch_line',
        'legal_name',
        'receipt_number_alias',
        'firm_logo',
        'pan_number',
        'service_tax_number',
        'vat_number',
        'office_address',
        'gst_number',
        'cloud_telephoney_client',
        'domain_name',
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
