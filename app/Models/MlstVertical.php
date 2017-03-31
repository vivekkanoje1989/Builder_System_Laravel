<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Mar 2017 12:50:56 +0530.
 */

namespace App\Models;
//use App\Modules\ManageDepartment\Models\MlstDepartments;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstVertical
 * 
 * @property int $id
 * @property string $name
 *
 * @package App\Models
 */
class MlstVertical extends Eloquent {

    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    public $table = 'mlst_bmsb_verticals';
    public $incrementing = false;
    //public $timestamps = false;
    protected $fillable = [
        'name'
    ];    
    public static function deparments()
    {
        //$table =$this->$table;
        return self::$table->hasMany('App\Modules\ManageDepartment\Models\MlstDepartments');
    }
}
