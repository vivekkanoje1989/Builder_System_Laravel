<?php
namespace App\Modules\MasterSales\Models;
use Illuminate\Database\Eloquent\Model;

class EnquiryDetailsLogs extends Model
{
	protected $casts = [
		'main_record_id	' => 'int',
		'enquiry_id' => 'int',
		'property_type_id' => 'int',
		'property_subtype_id' => 'int',
		'property_category_id' => 'int',
		'property_categeory_subtype_id' => 'int',
		'block_id' => 'int',
		'property_required_for' => 'int',
		'tenants_type_id' => 'int',
		'sales_subcategory_id' => 'int',
		'area_in_sqft' => 'int',
	];

	protected $dates = [
		'created_date',
	];

	protected $fillable = [
		'main_record_id	',
		'enquiry_id',
		'property_type_id',
		'property_subtype_id',
		'property_category_id' ,
		'property_categeory_subtype_id' ,
		'block_id' ,
		'property_required_for',
		'tenants_type_id',
		'area_in_sqft',
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
