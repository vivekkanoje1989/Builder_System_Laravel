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

    public static function validationMessages() {
        $messages = array(
            'payment_heading.required' => 'Please enter payment heading.',
            'tax_heading.required' => 'Please select tax heading.',
            'date_dependent_tax.required' => 'Please select date dependants.',
            'tax_applicable' => 'Please select tax applicable.'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'payment_heading' => 'required',
            'tax_heading' => 'required',
            'date_dependent_tax' => 'required',
            'tax_applicable' => 'required'
        );
        return $rules;
    }

}
