<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Modules\ManageCity\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstState
 * 
 * @property int $state_id
 * @property int $country_id
 * @property string $state_name
 *
 * @package App\Models
 */
class LstStates extends Eloquent
{
	protected $primaryKey = 'id';
	 protected $connection = 'masterdb';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'country_id',
		'name',
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
