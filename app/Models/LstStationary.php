<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 11 Apr 2017 13:30:25 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstStationary
 * 
 * @property int $id
 * @property int $firm_partner_id
 * @property string $name
 * @property string $letter_head
 * @property string $receipt_letter_head
 * @property string $stamp
 * @property \Carbon\Carbon $created_on
 *
 * @package App\Models
 */
class LstStationary extends Eloquent
{
	protected $table = 'lst_stationary';
	public $timestamps = false;

	protected $casts = [
		'firm_partner_id' => 'int'
	];

	protected $dates = [
		'created_on'
	];

	protected $fillable = [
		'firm_partner_id',
		'name',
		'letter_head',
		'receipt_letter_head',
		'stamp',
		'created_on'
	];
}
