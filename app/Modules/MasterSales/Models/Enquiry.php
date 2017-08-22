<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 20 Apr 2017 18:04:56 +0530.
 */

namespace App\Modules\MasterSales\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Enquiry
 * 
 * @property int $id
 * @property int $client_id
 * @property int $customer_id
 * @property \Carbon\Carbon $sales_enquiry_date
 * @property int $sales_employee_id
 * @property int $sales_channel_id
 * @property string $sales_channel_info
 * @property int $sales_source_id
 * @property int $sales_subsource_id
 * @property string $sales_source_description
 * @property int $sales_status_id
 * @property int $sales_substatus_id
 * @property int $sales_category_id
 * @property int $sales_subcategory_id
 * @property int $sales_enquiry_form_status
 * @property string $enquiry_locations
 * @property int $property_possession_type
 * @property \Carbon\Carbon $property_possession_date
 * @property int $max_budget
 * @property int $payment_mode
 * @property int $payment_instalments
 * @property int $parking_required
 * @property int $parking_type
 * @property int $2wheeler_parkings_required
 * @property int $4wheeler_parkings_required
 * @property int $finance_required
 * @property int $finance_required_from
 * @property \Carbon\Carbon $finance_enquiry_date
 * @property int $finance_employee_id
 * @property int $finance_tieup_id
 * @property int $finance_source_id
 * @property int $finance_subsource_id
 * @property int $finance_source_discription
 * @property int $finance_status_id
 * @property int $finance_substatus_id
 * @property int $finance_category_id
 * @property int $finance_subcategory_id
 * @property int $finance_enquiry_form_status
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property \Carbon\Carbon $updated_date
 * @property \Carbon\Carbon $updated_at
 * @property int $updated_by
 * @property string $updated_IP
 * @property string $updated_browser
 * @property string $updated_mac_id
 * @property int $deleted_status
 * @property \Carbon\Carbon $deleted_date
 * @property int $deleted_by
 * @property int $deleted_IP
 * @property int $deleted_browser
 * @property int $deleted_mac_id
 *
 * @package App\Models
 */
class Enquiry extends Eloquent {

    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'int',
        'client_id' => 'int',
        'customer_id' => 'int',
        'sales_employee_id' => 'int',
        'sales_channel_id' => 'int',
        'sales_source_id' => 'int',
        'sales_subsource_id' => 'int',
        'sales_status_id' => 'int',
        'sales_substatus_id' => 'int',
        'sales_category_id' => 'int',
        'sales_subcategory_id' => 'int',
        'sales_enquiry_form_status' => 'int',
        'property_possession_type' => 'int',
        'max_budget' => 'int',
        'payment_mode' => 'int',
        'payment_instalments' => 'int',
        'parking_required' => 'int',
        'parking_type' => 'int',
        'two_wheeler_parkings_required' => 'int',
        'four_wheeler_parkings_required' => 'int',
        'finance_required' => 'int',
        'finance_required_from' => 'int',
        'finance_employee_id' => 'int',
        'finance_tieup_id' => 'int',
        'finance_source_id' => 'int',
        'finance_subsource_id' => 'int',
        'finance_source_discription' => 'int',
        'finance_status_id' => 'int',
        'finance_substatus_id' => 'int',
        'finance_category_id' => 'int',
        'finance_subcategory_id' => 'int',
        'finance_enquiry_form_status' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_status' => 'int',
        'deleted_by' => 'int',
        'deleted_IP' => 'int',
        'deleted_browser' => 'int',
        'deleted_mac_id' => 'int'
    ];
    protected $dates = [
        'sales_enquiry_date',
        'property_possession_date',
        'finance_enquiry_date',
        'created_date',
        'updated_date',
        'deleted_date'
    ];
    protected $fillable = [
        'client_id',
        'customer_id',
        'sales_enquiry_date',
        'sales_employee_id',
        'sales_channel_id',
        'sales_channel_info',
        'sales_source_id',
        'sales_subsource_id',
        'sales_source_description',
        'sales_status_id',
        'sales_substatus_id',
        'sales_category_id',
        'sales_subcategory_id',
        'sales_enquiry_form_status',
        'enquiry_locations',
        'property_possession_type',
        'property_possession_date',
        'max_budget',
        'payment_mode',
        'payment_instalments',
        'parking_required',
        'parking_type',
        'two_wheeler_parkings_required',
        'four_wheeler_parkings_required',
        'finance_required',
        'finance_required_from',
        'finance_enquiry_date',
        'finance_employee_id',
        'finance_tieup_id',
        'finance_source_id',
        'finance_subsource_id',
        'finance_source_discription',
        'finance_status_id',
        'finance_substatus_id',
        'finance_category_id',
        'finance_subcategory_id',
        'finance_enquiry_form_status',
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
        'deleted_mac_id'
    ];

    public function getEnquiryCategoryName() {
        return $this->belongsTo('App\Models\MlstEnquirySalesCategory', 'sales_category_id');
    }

    public function getEnquiryDetails() {
        return $this->belongsTo('App\Modules\MasterSales\Models\EnquiryDetail', 'id', 'enquiry_id')->with('getProjectName', 'getBlock');
    }

    public function getFollowupDetails() { // get last followup details
        $date = date('Y-m-d');
        //return $this->belongsTo('App\Modules\MasterSales\Models\EnquiryFollowup', 'id', 'enquiry_id')->where('next_followup_date','=',$date);
        return $this->belongsTo('App\Modules\MasterSales\Models\EnquiryFollowup', 'id', 'enquiry_id');
    }

    public function channelName() {
        return $this->belongsTo('App\Models\MlstEnquirySalesChannel', 'sales_channel_id');
    }

    public function customerDetails() {
        return $this->belongsTo('App\Modules\MasterSales\Models\Customer', 'customer_id');
    }

    public function customerContacts() {
        return $this->belongsTo('App\Modules\MasterSales\Models\CustomersContact', 'customer_id');
    }

    public function getEnquiryLocation() {
        return $this->belongsTo('App\Models\LstEnquiryLocation', 'enquiry_locations');
    }
    
     public static function validationMessages() {
        $messages = array(
            'sales_enquiry_date.required' => 'Please enter date',
            'sales_category_id.required' => 'Please select category',
//            'max_budget.required' => 'Please enter max budget',
            'remarks.required' => 'Please enter remarks',
            'enquiry_locations.required' => 'Please enter location',
            'next_followup_date' => 'Please enter followup date',
//            'parking_type' => 'Please select parking type'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'sales_enquiry_date' => 'required',
            'sales_category_id' => 'required',
//            'max_budget' => 'required',
            'remarks' => 'required',
            'enquiry_locations' => 'required',
            'next_followup_date' => 'required',
//            'parking_type' => 'required'
        );
        return $rules;
    }
}
