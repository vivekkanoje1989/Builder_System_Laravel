<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

namespace App\Modules\DiscountHeadings\Models;


use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * 
 * 
 * 
 * 
 *
 * @package App\Models
 */
class Discountheading extends Eloquent
{
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $fillable = [
            'id',
            'discount_name',
            'status',
	];
}
