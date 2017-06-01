<?php
namespace App\Modules\MasterSales\Models;
use Illuminate\Database\Eloquent\Model;

class EnquiryFollowupsLogs extends Model
{
	protected $fillable = [
		'main_record_id',
		'enquiry_id',
		'followup_date_time',
		'followup_by',
		'followup_entered_through',
		'remarks' ,
		'call_recording_log_type' ,
		'call_recording_id' ,
		'next_followup_date',
		'next_followup_time',
		'actual_followup_date_time',
		'sales_category_id',
		'sales_subcategory_id',
		'sales_status_id',
		'sales_substatus_id',
		'finance_category_id',
		'finance_subcategory_id',
		'finance_status_id',
		'finance_substatus_id',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'record_type',
		'column_names',
		'record_restore_status',
	];
}
