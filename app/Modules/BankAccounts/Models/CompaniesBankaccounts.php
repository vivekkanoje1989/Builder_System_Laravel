<?php

namespace App\Modules\BankAccounts\Models;

use Illuminate\Database\Eloquent\Model;

class CompaniesBankaccounts extends Model {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name', 
        'company_id',
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
        'created_at',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_by',
        'updated_IP',
        'updated_browser',
        'updated_mac_id',
        'deleted_date',
        'deleted_IP',
        'deleted_mac_id'
    ];

}
