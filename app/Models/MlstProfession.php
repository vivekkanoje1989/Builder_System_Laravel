<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Feb 2017 12:09:45 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstProfession
 * 
 * @property int $id
 * @property string $profession
 *
 * @package App\Models
 */
class MlstProfession extends Eloquent
{
	public $timestamps = false;
	protected $connection = 'masterdb';

	protected $fillable = [
		'profession'
	];
}
