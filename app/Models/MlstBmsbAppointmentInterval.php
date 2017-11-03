<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 31 Oct 2017 09:23:54 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstBmsbAppointmentInterval
 * 
 * @property int $id
 * @property int $interval
 *
 * @package App\Models
 */
class MlstBmsbAppointmentInterval extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'interval' => 'int'
	];

	protected $fillable = [
		'interval'
	];
}
