<?php

namespace App\Modules\MasterSales\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

class Enquiry extends Eloquent {

    protected $primaryKey = 'id';
    protected $casts = [
        'client_id' => 'int',
        'customer_id' => 'int',
        'sales_employee_id' => 'int',
        'sales_source_id' => 'int',
        'sales_subsource_id' => 'int',
        'sales_status_id' => 'int',
        'sales_substatus_id' => 'int',
        'sales_category_id' => 'int',
        'sales_subcategory_id' => 'int',
        'sales_lost_reason_id' => 'int',
        'max_budget' => 'int',
        'quotation_given' => 'int',
        'test_drive_given' => 'int',
        'exchange_required' => 'int',
        'exchange_required_from' => 'int',
        'exchange_employee_id' => 'int',
        'exchange_source_id' => 'int',
        'exchange_subsource_id' => 'int',
        'exchange_source_discription' => 'int',
        'exchange_category_id' => 'int',
        'exchange_subcategory_id' => 'int',
        'exchange_status_id' => 'int',
        'exchange_substatus_id' => 'int',
        'exchange_enquiry_form_status' => 'int',
        //'max_rent_budget' => 'int',
        //'max_deposit' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];
    protected $dates = [
        'sales_enquiry_date',
        'finance_enquiry_date',
        'exchange_enquiry_date',
        'created_date',
        'updated_date'
    ];
    protected $fillable = [
        'client_id',
        'customer_id',
        'sales_enquiry_date',
        'sales_employee_id',
        'sales_source_id',
        'sales_subsource_id',
        'sales_source_description',
        'sales_status_id',
        'sales_substatus_id',
        'sales_category_id',
        'sales_subcategory_id',
        'sales_lost_reason_id',
        'sales_enquiry_form_token',
        'sales_enquiry_form_status',
        'parking_type',
        //'enquiry_locations',
        //'parking_required',
        'max_budget',
        //'max_rent_budget',
        //'max_deposit',
        'payment_mode',
        //'payment_instalments',
        'quotation_given',
        'test_drive_given',
        'finance_required',
        'finance_required_from',
        'finance_enquiry_date',
        'finance_employee_id',
        'finance_source_id',
        'finance_subsource_id',
        'finance_source_discription',
        'finance_category_id',
        'finance_subcategory_id',
        'finance_status_id',
        'finance_substatus_id',
        'finance_enquiry_form_token',
        'finance_enquiry_form_status',
        'exchange_required',
        'exchange_required_from',
        'exchange_enquiry_date',
        'exchange_employee_id',
        'exchange_source_id',
        'exchange_subsource_id',
        'exchange_source_discription',
        'exchange_category_id',
        'exchange_subcategory_id',
        'exchange_status_id',
        'exchange_substatus_id',
        'exchange_enquiry_form_status',
        'exchange_enquiry_form_token',
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

    public static function doAction($input) {
        $enquiryData = [];
        $enquiryData['sales_enquiry_date'] = !empty($input['sales_enquiry_date']) ? date('Y-m-d', strtotime($input['sales_enquiry_date'])) : '';
        $enquiryData['finance_enquiry_date'] = !empty($input['finance_enquiry_date']) ? date('Y-m-d', strtotime($input['finance_enquiry_date'])) : '';
        $enquiryData['client_id'] = !empty($input['client_id']) ? $input['client_id'] : "0";
        $enquiryData['customer_id'] = !empty($input['customer_id']) ? $input['customer_id'] : "0";
        $enquiryData['sales_employee_id'] = !empty($input['sales_employee_id']) ? $input['sales_employee_id'] : "0";
        $enquiryData['sales_source_id'] = !empty($input['sales_source_id']) ? $input['sales_source_id'] : '';
        $enquiryData['sales_subsource_id'] = !empty($input['sales_subsource_id']) ? $input['sales_subsource_id'] : '0';
        $enquiryData['sales_source_description'] = !empty($input['sales_source_description']) ? $input['sales_source_description'] : "";
        $enquiryData['sales_status_id'] = !empty($input['sales_status_id']) ? $input['sales_status_id'] : "0";
        $enquiryData['sales_substatus_id'] = !empty($input['sales_substatus_id']) ? $input['sales_substatus_id'] : "0";
        $enquiryData['sales_category_id'] = !empty($input['sales_category_id']) ? $input['sales_category_id'] : "0";
        $enquiryData['sales_subcategory_id'] = !empty($input['sales_subcategory_id']) ? $input['sales_subcategory_id'] : "0";
        $enquiryData['sales_lost_reason_id'] = !empty($input['sales_lost_reason_id']) ? $input['sales_lost_reason_id'] : "0";
        $enquiryData['max_budget'] = !empty($input['max_budget']) ? $input['max_budget'] : "0";
        $enquiryData['payment_mode'] = !empty($input['payment_mode']) ? $input['payment_mode'] : "0";
        $enquiryData['finance_required'] = !empty($input['finance_required']) ? $input['finance_required'] : "0";
        $enquiryData['finance_required_from'] = !empty($input['finance_required_from']) ? $input['finance_required_from'] : "0";
        $enquiryData['finance_employee_id'] = !empty($input['finance_employee_id']) ? $input['finance_employee_id'] : "0";
        $enquiryData['finance_source_id'] = !empty($input['finance_source_id']) ? $input['finance_source_id'] : "0";
        $enquiryData['finance_subsource_id'] = !empty($input['finance_subsource_id']) ? $input['finance_subsource_id'] : "0";
        $enquiryData['finance_source_discription'] = !empty($input['finance_source_discription']) ? $input['finance_source_discription'] : "";
        $enquiryData['finance_status_id'] = !empty($input['finance_status_id']) ? $input['finance_status_id'] : "0";
        $enquiryData['finance_substatus_id'] = !empty($input['finance_substatus_id']) ? $input['finance_substatus_id'] : "0";
        $enquiryData['finance_category_id'] = !empty($input['finance_category_id']) ? $input['finance_category_id'] : "0";
        $enquiryData['finance_subcategory_id'] = !empty($input['finance_subcategory_id']) ? $input['finance_subcategory_id'] : "0";
        $enquiryData['quotation_given'] = !empty($input['quotation_given']) ? $input['quotation_given'] : "0";
        $enquiryData['test_drive_given'] = !empty($input['test_drive_given']) ? $input['test_drive_given'] : "0";
        $enquiryData['exchange_required'] = !empty($input['exchange_required']) ? $input['exchange_required'] : "0";
        $enquiryData['exchange_required_from'] = !empty($input['exchange_required_from']) ? $input['exchange_required_from'] : "0";
        $enquiryData['exchange_employee_id'] = !empty($input['exchange_employee_id']) ? $input['exchange_employee_id'] : "0";
        $enquiryData['exchange_source_id'] = !empty($input['exchange_source_id']) ? $input['exchange_source_id'] : "0";
        $enquiryData['exchange_subsource_id'] = !empty($input['exchange_subsource_id']) ? $input['exchange_subsource_id'] : "0";
        $enquiryData['exchange_source_discription'] = !empty($input['exchange_source_discription']) ? $input['exchange_source_discription'] : "";
        $enquiryData['exchange_status_id'] = !empty($input['exchange_status_id']) ? $input['exchange_status_id'] : "0";
        $enquiryData['exchange_substatus_id'] = !empty($input['exchange_substatus_id']) ? $input['exchange_substatus_id'] : "0";
        $enquiryData['exchange_category_id'] = !empty($input['exchange_category_id']) ? $input['exchange_category_id'] : "0";
        $enquiryData['exchange_subcategory_id'] = !empty($input['exchange_subcategory_id']) ? $input['exchange_subcategory_id'] : "0";
        return $enquiryData;
    }
  
}
