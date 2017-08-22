<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstCity
 * 
 * @property int $city_id
 * @property int $state_id
 * @property string $city_name
 *
 * @package App\Models
 */
class ProjectStages extends Eloquent
{
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		
		'project_stages'
	];
}
