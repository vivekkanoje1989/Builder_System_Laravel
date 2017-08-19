<?php
namespace App\Modules\MasterSales\Models;
use Illuminate\Database\Eloquent\Model;
use App\Classes\CommonFunctions;
class EnquiryFollowup extends Model
{
	protected $fillable = [
		'enquiry_id',
                'client_id',
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
                'booked_vehicle_id',
		'finance_category_id',
		'finance_subcategory_id',
		'finance_status_id',
		'finance_substatus_id',
                'exchange_category_id' => 'int',
		'exchange_subcategory_id' => 'int',
		'exchange_status_id' => 'int',
		'exchange_substatus_id' => 'int',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'updated_date',
		'updated_by',
		'updated_IP',
		'updated_browser',
		'updated_mac_id',
		'deleted_status',
		'deleted_date',
		'deleted_by',
		'deleted_IP',
		'deleted_browser',
		'deleted_mac_id',
	];
        
    public static function doAction($input){ 
        $getMacAddress = CommonFunctions::getMacAddress();
        $loginDateTime = date('Y-m-d');
        $loginIP = $_SERVER['REMOTE_ADDR'];
        $loginBrowser = $_SERVER['HTTP_USER_AGENT'];
        $loginMacId = empty($getMacAddress) ? "" : $getMacAddress;
    	$enquiryFollowupData = [];  
        $enquiryFollowupData['enquiry_id'] = !empty($input['enquiry_id']) ? $input['enquiry_id'] : "0";
        $enquiryFollowupData['followup_by'] = !empty($input['followup_by']) ? $input['followup_by'] : "0";
        $enquiryFollowupData['followup_date_time'] = date('Y-m-d H:i:s');
        $enquiryFollowupData['followup_entered_through'] = !empty($input['followup_entered_through']) ? $input['followup_entered_through'] :"0";
        $enquiryFollowupData['remarks'] = !empty($input['remarks']) ? $input['remarks'] : '';
        $enquiryFollowupData['call_recording_log_type'] = !empty($input['call_recording_log_type']) ? $input['call_recording_log_type'] : '0';
        $enquiryFollowupData['call_recording_id'] = !empty($input['call_recording_id']) ? $input['call_recording_id'] : "0";
        $enquiryFollowupData['next_followup_date'] = !empty($input['next_followup_date']) ? date('Y-m-d', strtotime($input['next_followup_date'])) : '';
        $enquiryFollowupData['next_followup_time'] = !empty($input['next_followup_time']) ? date('H:i:s', strtotime($input['next_followup_time'])) : "";
        $enquiryFollowupData['actual_followup_date_time'] = !empty($input['actual_followup_date_time']) ? $input['actual_followup_date_time'] : "";
        $enquiryFollowupData['sales_category_id'] = !empty($input['sales_category_id']) ? $input['sales_category_id'] : "0";
        $enquiryFollowupData['sales_subcategory_id'] = !empty($input['sales_subcategory_id']) ? $input['sales_subcategory_id'] : "0";
        $enquiryFollowupData['sales_status_id'] = !empty($input['sales_status_id']) ? $input['sales_status_id'] : "0";
        $enquiryFollowupData['sales_substatus_id'] = !empty($input['sales_substatus_id']) ? $input['sales_substatus_id'] : "0";
        $enquiryFollowupData['booked_vehicle_id'] = !empty($input['booked_vehicle_id']) ? $input['booked_vehicle_id'] : "0";
        $enquiryFollowupData['finance_category_id'] = !empty($input['finance_category_id']) ? $input['finance_category_id'] : "0";
        $enquiryFollowupData['finance_subcategory_id'] = !empty($input['finance_subcategory_id']) ? $input['finance_subcategory_id'] : "0";
        $enquiryFollowupData['finance_status_id'] = !empty($input['finance_status_id']) ? $input['finance_status_id'] : "0";
        $enquiryFollowupData['finance_substatus_id'] = !empty($input['finance_substatus_id']) ? $input['finance_substatus_id'] : "0";
        $enquiryFollowupData['exchange_category_id'] = !empty($input['exchange_category_id']) ? $input['exchange_category_id'] : "0";
        $enquiryFollowupData['exchange_subcategory_id'] = !empty($input['exchange_subcategory_id']) ? $input['exchange_subcategory_id'] : "0";
        $enquiryFollowupData['exchange_status_id'] = !empty($input['exchange_status_id']) ? $input['exchange_status_id'] : "0";
        $enquiryFollowupData['exchange_substatus_id'] = !empty($input['exchange_substatus_id']) ? $input['exchange_substatus_id'] : "0";
        $enquiryFollowupData['created_by'] = !empty($input['followup_by']) ? $input['followup_by'] : "0";
        $enquiryFollowupData['created_date'] = $loginDateTime;
        $enquiryFollowupData['created_browser'] = $loginBrowser;
        $enquiryFollowupData['created_mac_id'] = $getMacAddress;
        $enquiryFollowupData['created_IP'] = $loginIP;
        
       //print_r($enquiryFollowupData);exit;
        return $enquiryFollowupData;
    }
}
