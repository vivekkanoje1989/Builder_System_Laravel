<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstEducation
 * 
 * @property int $blood_group_id
 * @property string $blood_group
 *
 * @package App\Models
 */
class BlockStages extends Eloquent
{
	protected $primaryKey = 'id';


	public $timestamps = false;
	protected $fillable = [
		'block_stages',
		'project_type_id'
	];
}
