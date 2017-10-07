<?php   namespace App\Modules\ManageLostReason\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class MlstBmsbEnquiryLostReasons extends Eloquent
{
       // protected $primaryKey = 'id';
	protected $casts = [
		'client_id' => 'int',
		'vertical_id' => 'int',
		'lost_reason_status' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];
        protected  $connection = 'masterdb';

        protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'client_id',
		'vertical_id',
		'reason',
		'lost_reason_status',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'updated_date',
		'updated_by',
		'updated_IP',
		'updated_browser',
		'updated_mac_id'
	];
}
