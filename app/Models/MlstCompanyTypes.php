<?php  namespace App\Models;
use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LstCity
 * 
 * @property int $city_id
 * @property int $state_id
 * @property string $city_name
 *
 * @package App\Models
 */
class MlstCompanyTypes extends Eloquent
{
	protected $primaryKey = 'id';
        protected $connection = 'masterdb';
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'type_of_company',
		'id',
		'status',
	];
}
