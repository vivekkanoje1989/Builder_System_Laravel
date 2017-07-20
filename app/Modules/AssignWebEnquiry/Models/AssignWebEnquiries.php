<?php namespace App\Modules\AssignWebEnquiry\Models;

use Illuminate\Database\Eloquent\Model;

class AssignWebEnquiries extends Model {

	protected $primaryKey = 'id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'employee_id',
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
