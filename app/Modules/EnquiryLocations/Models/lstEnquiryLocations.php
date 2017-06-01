<?php namespace App\Modules\EnquiryLocations\Models;

use Illuminate\Database\Eloquent\Model;

class lstEnquiryLocations extends Model {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'country_id',
        'state_id',
        'city_id',
        'location',
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

    public function getCityName()
    {
        return $this->belongsTo('App\Modules\ManageCity\Models\MlstCities','city_id');
    }
}
