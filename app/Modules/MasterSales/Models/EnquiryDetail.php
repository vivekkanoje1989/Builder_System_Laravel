<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 14 Sep 2017 13:09:41 +0530.
 */

namespace App\Modules\MasterSales\Models;

use Reliese\Database\Eloquent\Model as Model;

/**
 * Class EnquiryDetail
 * 
 * @property int $id
 * @property int $client_id
 * @property int $enquiry_id
 * @property int $project_id
 * @property string $block_id
 * @property string $sub_block_id
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
class EnquiryDetail extends Model {

    protected $primaryKey = 'id';
    protected $casts = [
        'client_id' => 'int',
        'enquiry_id' => 'int',
        'project_id' => 'int',
        'area_in_sqft' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];
    protected $dates = [
        'created_date',
        'updated_date'
    ];
    protected $fillable = [
        'client_id',
        'enquiry_id',
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

    public function getProjectName() {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }

    public function getBlock() {
        return $this->belongsTo('App\Models\ProjectBlock', 'block_id');
    }

}
