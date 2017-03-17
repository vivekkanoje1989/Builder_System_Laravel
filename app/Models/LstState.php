<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Modules\Models;

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
class LstState extends Eloquent
{
	protected $primaryKey = 'id';
	 protected $connection = 'masterdb';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'country_id',
		'name'
	];
}
