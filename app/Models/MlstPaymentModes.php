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
class MlstPaymentModes extends Eloquent
{
	protected $primaryKey = 'id';
        protected $connection = 'masterdb';
	public $timestamps = false;

	protected $fillable = [
                'id',
                'payment_mode',
                'status',
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
                'deleted_status',
                'deleted_date',
                'deleted_by',
                'deleted_IP',
                'deleted_browser',
                'deleted_mac_id',
	];
}
