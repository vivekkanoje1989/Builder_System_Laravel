<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 01 Apr 2017 15:19:04 +0530.
 */

namespace App\Modules\PropertyPortals\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstBmsbPropertyPortal
 * 
 * @property int $id
 * @property string $portal_name
 *
 * @package App\Models
 */
class MlstBmsbPropertyPortal extends Eloquent {

    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    public $timestamps = false;
    protected $fillable = [
        'portal_name',
        'status',
    ];

}
