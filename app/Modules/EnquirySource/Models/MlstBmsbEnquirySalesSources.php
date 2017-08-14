<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 24 Feb 2017 15:00:41 +0530.
 */

namespace App\Modules\EnquirySource\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstDepartment
 * 
 * @property int $id
 * @property int $client_id
 * @property string $department_name
 *
 * @package App\Models
 */
class MlstBmsbEnquirySalesSources extends Eloquent
{
	protected $primaryKey = 'id';
	 protected $connection = 'masterdb';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'id',
		'source_name',
		'source_status'
	];
}
