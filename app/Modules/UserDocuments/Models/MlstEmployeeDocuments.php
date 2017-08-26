<?php

namespace App\Modules\UserDocuments\Models;

use Illuminate\Database\Eloquent\Model;

class MlstEmployeeDocuments extends Model {

    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    public $timestamps = false;
    protected $casts = [
        'id' => 'int'
    ];
    protected $fillable = [
        'document_name',
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
    
     
}
