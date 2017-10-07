<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeesPasswordReset
 * 
 * @property string $email
 * @property string $token
 * @property \Carbon\Carbon $created_at
 *
 * @package App\Models
 */
class EmployeesPasswordReset extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'email',
		'token'
	];
}
