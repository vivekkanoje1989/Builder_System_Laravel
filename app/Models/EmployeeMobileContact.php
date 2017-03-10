<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 10:46:09 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class EmployeeMobileContact
 * 
 * @property int $id
 * @property int $client_id
 * @property int $employee_id
 * @property string $contact_name
 * @property string $profile_image
 * @property string $label_mobile1
 * @property string $mobile1
 * @property string $label_mobile2
 * @property string $mobile2
 * @property string $label_mobile3
 * @property string $mobile3
 * @property string $label_email1
 * @property string $email1
 * @property string $label_email2
 * @property string $email2
 * @property string $company
 * @property string $label_date1
 * @property \Carbon\Carbon $date1
 * @property string $label_date2
 * @property \Carbon\Carbon $date2
 * @property string $label_add1
 * @property string $address1
 * @property string $label_add2
 * @property string $address2
 * @property string $notes
 * @property \Carbon\Carbon $created_date_time
 *
 * @package App\Models
 */
class EmployeeMobileContact extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'employee_id' => 'int'
	];

	protected $dates = [
		'date1',
		'date2',
		'created_date_time'
	];

	protected $fillable = [
		'client_id',
		'employee_id',
		'contact_name',
		'profile_image',
		'label_mobile1',
		'mobile1',
		'label_mobile2',
		'mobile2',
		'label_mobile3',
		'mobile3',
		'label_email1',
		'email1',
		'label_email2',
		'email2',
		'company',
		'label_date1',
		'date1',
		'label_date2',
		'date2',
		'label_add1',
		'address1',
		'label_add2',
		'address2',
		'notes',
		'created_date_time'
	];
}
