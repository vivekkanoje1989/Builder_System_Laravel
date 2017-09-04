<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Feb 2017 12:09:45 +0530.
 */

namespace App\Modules\ManageProfession\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstProfession
 * 
 * @property int $id
 * @property string $profession
 *
 * @package App\Models
 */
class MlstProfessions extends Eloquent {

    public $timestamps = false;
    protected $connection = 'masterdb';
    protected $fillable = [
        'profession',
        'id',
        'created_date',
        'created_at',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_at',
        'updated_by',
        'updated_IP',
        'updated_browser',
        'updated_mac_id',
    ];

}
