<?php

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
class MlstBmscEnquirySalesSources extends Eloquent {

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    protected $fillable = [
        'sales_source_name'
    ];

}
