<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstCountry
 * 
 * @property int $country_id
 * @property string $country_name
 *
 * @package App\Models
 */
class LstCountriesLogs extends Eloquent
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
                 'record_restore_status',
                 'record_type',
                 'column_names',
                 'main_record_id',
                 'record_restore_status',
                 'record_type'
	];
}
