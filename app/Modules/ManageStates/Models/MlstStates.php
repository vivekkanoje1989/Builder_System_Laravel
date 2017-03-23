<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Modules\ManageStates\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstEducation
 * 
 * @property int $blood_group_id
 * @property string $blood_group
 *
 * @package App\Models
 */
class MlstStates extends Eloquent
{
	protected $primaryKey = 'id';

        protected $connection = "masterdb";
	public $timestamps = false;
	protected $fillable = [
		'name',
		'country_id',
                'id',
                'created_date',
                'created_at',
                'created_by',
                'created_IP',
                'created_browser',
                'created_mac_id',
                
	];
}
