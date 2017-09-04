<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 21 Apr 2017 10:15:08 +0530.
 */

namespace App\Modules\MasterSales\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EnquiryDetail
 * 
 * @property int $id
 * @property int $enquiry_id
 * @property int $project_id
 * @property int $block_id
 * @property int $sub_block_id
 * @property int $area_in_sqft
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
 *
 * @package App\Models
 */
class EnquiryDetail extends Eloquent
{
	protected $casts = [
		'enquiry_id' => 'int',
		'project_id' => 'int',
		'block_id' => 'int',
		'sub_block_id' => 'int',
		'area_in_sqft' => 'int',
		'created_by' => 'int',
		'updated_by' => 'int'
	];

	protected $dates = [
		'created_date',
		'updated_date'
	];

	protected $fillable = [
		'enquiry_id',
                'client_id',
		'project_id',
		'block_id',
		'sub_block_id',
		'area_in_sqft',
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
        
        public function getProjectName()
        {
            return $this->belongsTo('App\Models\Project','project_id');
        }
        public function getBlock()
        {
            return $this->belongsTo('App\Models\ProjectBlock','block_id');
        }
}
