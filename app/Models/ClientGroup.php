<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ClientGroup
 * 
 * @property int $id
 * @property int $group_name
 *
 * @package App\Models
 */
class ClientGroup extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'group_name' => 'int'
	];

	protected $fillable = [
		'id',
		'group_name'
	];
}
