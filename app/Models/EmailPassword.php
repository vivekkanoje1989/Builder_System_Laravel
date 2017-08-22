<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 13 Mar 2017 12:51:50 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmailPassword
 * 
 * @property int $id
 * @property string $email_id
 * @property string $email_pwd
 * @property string $type
 * @property string $client_id
 * @property string $system_id
 * @property int $status
 *
 * @package App\Models
 */
class EmailPassword extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'email_id',
		'email_pwd',
		'type',
		'client_id',
		'system_id',
		'status'
	];
}
