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
class PaymentHeadings extends Eloquent
{
	protected $primaryKey = 'id';
	public $timestamps = false;
        protected $fillable = [
            'id',
            'type_of_payment',
            'project_type_id',
            'is_tax_heading',
            'is_date_dependent'
	];
}
