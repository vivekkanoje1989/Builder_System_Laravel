<?php

namespace App\Modules\Companies\Models;

use Illuminate\Database\Eloquent\Model;

class CompaniesBankaccounts extends Model {

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'id' => 'int'
    ];
    protected $fillable = [
        'id',
        'name',
        'branch',
        'ifsc',
        'micr',
        'account_number',
        'account_type',
        'address',
        'phone',
        'email',
        'preffered_payment_headings_ids',
        'created_date',
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
