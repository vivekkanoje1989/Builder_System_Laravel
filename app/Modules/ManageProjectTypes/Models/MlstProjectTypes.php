<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Modules\ManageProjectTypes\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstCity
 * 
 * @property int $city_id
 * @property int $state_id
 * @property string $city_name
 *
 * @package App\Models
 */
class MlstProjectTypes extends Eloquent
{
	protected $primaryKey = 'id';
	public $timestamps = false;
        protected $connection = 'masterdb';

        protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		
		'project_type_name',
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
