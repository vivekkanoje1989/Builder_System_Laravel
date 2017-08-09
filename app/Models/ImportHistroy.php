<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 18 Jul 2017 15:52:34 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ImportHistroy
 * 
 * @property int $id
 * @property \Carbon\Carbon $created_datetime
 * @property int $employee_id
 * @property string $import_file
 * @property string $report_status
 * @property string $error_report_file
 *
 * @package App\Models
 */
class ImportHistroy extends Eloquent
{
	protected $table = 'import_histroy';
	public $timestamps = false;

	protected $casts = [
		'employee_id' => 'int'
	];

	protected $dates = [
		'created_datetime'
	];

	protected $fillable = [
		'created_datetime',
		'employee_id',
		'import_file',
		'report_status',
		'error_report_file'
	];
        
         public function getEmployee()
        {
            return $this->belongsTo('App\Models\backend\Employee','employee_id')->select("id","first_name", "last_name");
        }
        
}
