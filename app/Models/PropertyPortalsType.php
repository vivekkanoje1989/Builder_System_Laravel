<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 09 Mar 2017 16:05:41 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PropertyPortalsType
 * 
 * @property int $id
 * @property string $portal_name
 * @property int $status
 *
 * @package App\Models
 */
class PropertyPortalsType extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $fillable = [
		'portal_name',
		'status'
	];
}
