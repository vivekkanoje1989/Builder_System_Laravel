<?php

namespace App\Modules\EmployeeDocuments\Models;

use Illuminate\Database\Eloquent\Model;

class MlstEmployeeDocuments extends Model {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $connection = "masterdb"; 
    protected $fillable = [
        'document_name',
        'id',
        'created_on',
        'created_by',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'created_date',
        'updated_at',
        'deleted_status',
        'sub_folder_status',
    ];

}
