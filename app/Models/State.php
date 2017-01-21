<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class State
 * 
 * @property int $state_id
 * @property int $country_id
 * @property string $state_name
 *
 * @package App\Models
 */
class State extends Eloquent
{
	protected $primaryKey = 'state_id';
	public $timestamps = false;

	protected $casts = [
		'country_id' => 'int'
	];

	protected $fillable = [
		'country_id',
		'state_name'
	];
}
