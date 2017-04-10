<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 06 Apr 2017 13:26:35 +0530.
 */

namespace App\Models;

use DB;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstBmsbDepartment
 * 
 * @property int $id
 * @property int $client_id
 * @property int $vertical_id
 * @property string $department_name
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
class MlstBmsbDepartment extends Eloquent {

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    protected $casts = [
        'client_id' => 'int',
        'vertical_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];
    protected $dates = [
        'created_date',
        'updated_date'
    ];
    protected $fillable = [
        'client_id',
        'vertical_id',
        'department_name',
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

}
