<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 27 Mar 2017 12:30:49 +0530.
 */

namespace App\Modules\EmailConfig\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmailConfiguration
 * 
 * @property int $id
 * @property int $client_id
 * @property string $department_id
 * @property string $email
 * @property string $password
 * @property string $status
 *
 * @package App\Models
 */
class EmailConfiguration extends Eloquent
{
	protected $table = 'email_configuration';
	public $timestamps = false;
        protected $primaryKey = 'id';   
	protected $casts = [
		'client_id' => 'int'
	];


	protected $fillable = [
		'client_id',
		'department_id',
		'email',
		'password',
		'status'
	];
}
