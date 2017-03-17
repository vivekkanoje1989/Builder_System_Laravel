<?php namespace App\Modules\PaymentHeadings\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHeadings extends Model {

	protected $primaryKey = 'id';
	public $timestamps = false;
        protected $fillable = [
            'id',
            'type_of_payment',
            'project_type_id',
            'is_tax_heading',
            'is_date_dependent',
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
