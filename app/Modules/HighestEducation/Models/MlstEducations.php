<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */
namespace App\Modules\HighestEducation\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstEducation
 * 
 * @property int $blood_group_id
 * @property string $blood_group
 *
 * @package App\Models
 */
class MlstEducations extends Eloquent
{
	protected $primaryKey = 'education_id';

	protected $connection = 'masterdb';

	public $timestamps = false;
	protected $fillable = [
		'education_title',
                'education_id',
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
