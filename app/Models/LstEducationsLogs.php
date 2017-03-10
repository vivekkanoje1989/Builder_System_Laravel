<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 05:28:47 +0000.
 */

namespace App\Models;

use DB;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstBloodGroup
 * 
 * @property int $blood_group_id
 * @property string $blood_group
 *
 * @package App\Models
 */
class LstEducationsLogs extends Eloquent
{
	protected $primaryKey = 'education_id';
	 protected $connection = 'masterdb';
	
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'education_id' => 'int'
	];

	protected $fillable = [
		'education_id',
               'education_title'
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
