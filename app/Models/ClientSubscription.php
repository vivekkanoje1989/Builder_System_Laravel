<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ClientSubscription
 * 
 * @property int $id
 * @property int $client_id
 * @property int $system_type_id
 * @property int $system_varient_id
 * @property int $sub_menu_id
 * @property int $service_start_date
 * @property int $service_end_date
 *
 * @package App\Models
 */
class ClientSubscription extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'system_type_id' => 'int',
		'system_varient_id' => 'int',
		'sub_menu_id' => 'int',
		'service_start_date' => 'int',
		'service_end_date' => 'int'
	];

	protected $fillable = [
		'client_id',
		'system_type_id',
		'system_varient_id',
		'sub_menu_id',
		'service_start_date',
		'service_end_date'
	];
}
