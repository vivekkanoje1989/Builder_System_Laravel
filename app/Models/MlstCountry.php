<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstCountry
 * 
 * @property int $country_id
 * @property string $country_name
 *
 * @package App\Models
 */
class MlstCountry extends Eloquent
{
	protected $primaryKey = 'id';
	 protected $connection = 'masterdb';
	public $timestamps = false;

	protected $fillable = [
            'id',
            'sortname',
            'name',
            'phonecode'
	];
}
