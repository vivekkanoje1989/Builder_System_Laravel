<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 29 Mar 2017 17:02:33 +0530.
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
    public $table = 'mlst_bmsb_verticals';
    public $incrementing = false;
    protected $fillable = [
        'name'
    ];
}
