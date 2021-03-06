<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 18 Jan 2017 09:04:39 +0000.
 */

namespace App\Modules\BlockStages\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstEducation
 * 
 * @property int $blood_group_id
 * @property string $blood_group
 *
 * @package App\Models
 */
class LstDlBlockStages extends Eloquent
{
	protected $primaryKey = 'id';
	public $timestamps = false;
	protected $fillable = [
		'block_stage_name',
		'project_type_id',
                'created_date',
                'created_at',
                'created_by',
                'created_IP',
                'created_browser',
                'created_mac_id',
                
	];
        
         public static function validationMessages() {
        $messages = array(
            'block_stage_name.required' => 'Please enter block stage',
            'project_type_id.required' => 'Please select project type'
            
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'block_stage_name' => 'required',
            'project_type_id' => 'required'
           
        );
        return $rules;
    }
}
