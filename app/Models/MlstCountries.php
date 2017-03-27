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
class MlstCountries extends Eloquent
{
	protected $primaryKey = 'id';
	 protected $connection = 'masterdb';
	public $timestamps = false;

	protected $fillable = [
                'id',
                'sortname',
                'name',
                'phonecode',
                'created_date',
                'created_at',
                'created_by',
                'created_IP',
                'created_browser',
                'created_mac_id',
                'updated_date',
                'updated_at',
                'updated_by',
                'updated_IP',
                'updated_browser',
                'updated_mac_id',
                
	];
}
