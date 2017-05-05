<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 28 Apr 2017 11:15:54 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstBmsbVertical
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class MlstBmsbVertical extends Eloquent {

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    protected $fillable = [
        'name'
    ];

}
