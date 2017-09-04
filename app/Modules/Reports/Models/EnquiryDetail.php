<?php
namespace App\Modules\MasterSales\Models;
use Illuminate\Database\Eloquent\Model;

class EnquiryDetail extends Model
{
	protected $casts = [
		'enquiry_id' => 'int',
		'brand_id' => 'int',
		'model_id' => 'int',
		'sub_model_id' => 'int',
		'veriant_id' => 'int',
		'sub_veriant_id' => 'int',
		'transmission_id' => 'int',
		'engine_id' => 'int',
		'fuel_id' => 'int',
		'color_id' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int',
		'deleted_IP' => 'int',
		'deleted_browser' => 'int',
		'deleted_mac_id' => 'int'
	];

	protected $dates = [
		//'finance_enquiry_date',
		//'exchange_enquiry_date',
		'created_date',
		'updated_date',
		'deleted_date'
	];

	protected $fillable = [
		'enquiry_id',
		'brand_id',
		'model_id',
		'sub_model_id',
		'veriant_id',
		'sub_veriant_id',
		'transmission_id',
		'engine_id',
		'fuel_id',
		'color_id',
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
        
    public static function doAction($input){ 
        
    	$enquiryDetailsData = [];  
        $enquiryDetailsData['enquiry_id'] = !empty($input['enquiry_id']) ? $input['enquiry_id'] : "0";
        $enquiryDetailsData['brand_id'] = !empty($input['brand_id']) ? $input['brand_id'] :"0";
        $enquiryDetailsData['model_id'] = !empty($input['model_id']) ? $input['model_id'] : '0';
        $enquiryDetailsData['sub_model_id'] = !empty($input['sub_model_id']) ? $input['sub_model_id'] : '0';
        $enquiryDetailsData['veriant_id'] = !empty($input['veriant_id']) ? $input['veriant_id'] : "";
        $enquiryDetailsData['sub_veriant_id'] = !empty($input['sub_veriant_id']) ? $input['sub_veriant_id'] : "0";
        $enquiryDetailsData['transmission_id'] = !empty($input['transmission_id']) ? $input['transmission_id'] : "0";
        $enquiryDetailsData['engine_id'] = !empty($input['engine_id']) ? $input['engine_id'] : "0";
        $enquiryDetailsData['fuel_id'] = !empty($input['fuel_id']) ? $input['fuel_id'] : "0";
        $enquiryDetailsData['color_id'] = !empty($input['color_id']) ? $input['color_id'] : "0";
        
        return $enquiryDetailsData;
    }
    
    
    public function brandName()
        {
            return $this->belongsTo('App\Models\MlstLmsaBrand', 'brand_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
        
        public function modelName()
        {
            return $this->belongsTo('App\Models\MlstLmsaModel', 'model_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
        
        public function submodelName()
        {
            return $this->belongsTo('App\Models\MlstLmsaSubmodel', 'sub_model_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
        
        public function variantName()
        {
            return $this->belongsTo('App\Models\MlstLmsaVarient', 'veriant_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
        
        public function subvariantName()
        {
            return $this->belongsTo('App\Models\MlstLmsaSubvarient', 'sub_veriant_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
        
        public function transmissionName()
        {
            return $this->belongsTo('App\Models\MlstLmsaTransmission', 'transmission_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
        
        public function engineName()
        {
            return $this->belongsTo('App\Models\MlstLmsaEngine', 'engine_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
        
        public function fuelName()
        {
            return $this->belongsTo('App\Models\MlstLmsaFuel', 'fuel_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
        
        public function colorName()
        {
            return $this->belongsTo('App\Models\MlstLmsaColor', 'color_id'); //(stationary model name, foreign key of ProjectWing model) 
        }
}
