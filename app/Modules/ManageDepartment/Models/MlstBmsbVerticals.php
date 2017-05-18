<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 05 Apr 2017 12:54:18 +0530.
 */

namespace App\Modules\ManageDepartment\Models;

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
class MlstBmsbVerticals extends Eloquent {

    public $timestamps = false;
    protected $connection = 'masterdb';
    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'int',
     
    ];
    
    protected $fillable = [
        'id',
        'name',
    ];
}
