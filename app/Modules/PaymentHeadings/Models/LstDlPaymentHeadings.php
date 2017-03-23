<?php

namespace App\Modules\PaymentHeadings\Models;

use Illuminate\Database\Eloquent\Model;

class LstDlPaymentHeadings extends Model {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'payment_heading',
        'tax_heading',
        'date_dependent_tax',
        'tax_applicable',
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
