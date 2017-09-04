<?php namespace App\Modules\Companies\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyDocuments extends Model {

	
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'id' => 'int'
    ];
    protected $fillable = [
        'id',
        'company_id',
        'document_name',
        'document_file',
        'status',
        'created_date',
        'created_at',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_at',
        'updated_IP',
        'updated_mac_id',
        'updated_browser'
    ];
}