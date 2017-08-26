<?php
/**
 * Created by Reliese Model.
 * Date: Thu, 27 Apr 2017 14:14:35 +0530.
 */
namespace App\Models;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProjectBlock
 * 
 * @property int $id
 * @property int $project_id
 * @property int $block_type_id
 * @property int $wing_id
 * @property string $block_sub_type
 * @property string $carpet_area_in_sqft
 * @property string $carpet_terrace_in_sqft
 * @property string $mezzanine_area_in_sqft
 * @property string $additional_area_in_sqft
 * @property string $sellable_area_in_sqft
 * @property string $carpet_area_in_sqmtr
 * @property string $carpet_terrace_in_sqmtr
 * @property string $mezzanine_area_in_sqmtr
 * @property string $additional_area_in_sqmtr
 * @property string $sellable_area_in_sqmtr
 * @property string $other1_label
 * @property string $other1_value_sqft
 * @property string $other1_value_sqmtr
 * @property string $other2_label
 * @property string $other2_value_sqft
 * @property string $other2_value_sqmtr
 * @property string $other3_label
 * @property string $other3_value_sqft
 * @property string $other3_value_sqmtr
 * @property int $block_availablity
 * @property int $show_on_website
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
class ProjectBlock extends Eloquent
{
	protected $casts = [
		'project_id' => 'int',
		'block_type_id' => 'int',
		'wing_id' => 'int',
		'block_availablity' => 'int',
		'show_on_website' => 'int',
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
		'block_type_id',
		'wing_id',
		'block_sub_type',
		'carpet_area_in_sqft',
		'carpet_terrace_in_sqft',
		'mezzanine_area_in_sqft',
		'additional_area_in_sqft',
		'sellable_area_in_sqft',
		'carpet_area_in_sqmtr',
		'carpet_terrace_in_sqmtr',
		'mezzanine_area_in_sqmtr',
		'additional_area_in_sqmtr',
		'sellable_area_in_sqmtr',
		'other1_label',
		'other1_value_sqft',
		'other1_value_sqmtr',
		'other2_label',
		'other2_value_sqft',
		'other2_value_sqmtr',
		'other3_label',
		'other3_value_sqft',
		'other3_value_sqmtr',
		'block_availablity',
		'show_on_website',
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
        public function getBlockType()
        {
            return $this->hasMany('App\Models\MlstBmsbBlockType','id','block_type_id')->select("id","block_name");
        }
}
