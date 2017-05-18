<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 31 Mar 2017 15:22:37 +0530.
 */

namespace App\Modules\Projects\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstBmsbProjectType
 * 
 * @property int $id
 * @property string $project_type
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 *
 * @package App\Models
 */
class MlstBmsbProjectType extends Eloquent {

    public $timestamps = false;
    protected $connection = 'masterdb';
    protected $casts = [
        'created_by' => 'int'
    ];
    protected $dates = [
        'created_date'
    ];
    protected $fillable = [
        'project_type',
        'created_date',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id'
    ];

}
