<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Country
 * 
 * @property int $country_id
 * @property string $country_name
 *
 * @package App\Models
 */
class Country extends Eloquent
{
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
            'countryid',
            'countryname',
            'countrycode'
	];
}
