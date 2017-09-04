<?php
/**
 * Created by Reliese Model.
 * Date: Fri, 14 Apr 2017 12:13:51 +0530.
 */
namespace App\Modules\Wings\Models;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProjectWing
 * 
 * @property int $id
 * @property int $project_id
 * @property int $company_id
 * @property int $stationary_id
 * @property string $wing_name
 * @property int $number_of_floors
 * @property int $number_of_floors_below_ground
 * @property int $wing_status
 * @property int $wing_status_for_enquiries
 * @property int $wing_status_for_bookings
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
class ProjectWing extends Eloquent
{
	protected $casts = [
		'project_id' => 'int',
		'company_id' => 'int',
		'stationary_id' => 'int',
		'number_of_floors' => 'int',
		'number_of_floors_below_ground' => 'int',
		'wing_status' => 'int',
		'wing_status_for_enquiries' => 'int',
		'wing_status_for_bookings' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_status' => 'int',
		'deleted_by' => 'int',
		'deleted_IP' => 'int',
		'deleted_browser' => 'int',
		'deleted_mac_id' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date',
		'deleted_date'
	];

	protected $fillable = [
		'project_id',
		'company_id',
		'stationary_id',
		'wing_name',
		'number_of_floors',
		'number_of_floors_below_ground',
		'wing_status',
		'wing_status_for_enquiries',
		'wing_status_for_bookings',
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
        public static function validationMessages() {
        $messages = array(
            'project_id.required' => 'Please select project',
            'company_id.required' => 'Please select company',
            'stationary_id.required' => 'Please select stationary',
            'number_of_floors' =>'Please enter numeric floors',
            'wing_name.required' => 'Please enter name',
            'wing_status.required' => 'Please select status',
            'wing_status_for_enquiries.required' => 'Please select enquiry status',
            'wing_status_for_bookings.required' => 'Please select booking status'            
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'project_id' => 'required',
            'company_id' => 'required',
            'stationary_id' => 'required',
            'number_of_floors'=>'required|numeric',
            'wing_name' => 'required',
            'wing_status' => 'required',
            'wing_status_for_enquiries' => 'required',
            'wing_status_for_bookings' => 'required',            
        );
        return $rules;
    }
     public function projectName()
    {
        return $this->belongsTo('App\Modules\Projects\Models\Project', 'project_id'); //(Project model name, foreign key of ProjectWing model) 
    }
    public function stationaryName()
    {
        return $this->belongsTo('App\Models\CompanyStationary', 'stationary_id'); //(stationary model name, foreign key of ProjectWing model) 
    }
    public function companyName()
    {
        return $this->belongsTo('App\Models\Company', 'company_id'); //(Company model name, foreign key of ProjectWing model) 
    }
}
