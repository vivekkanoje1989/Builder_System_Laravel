<?php

namespace App\Modules\MyStorage\Models;

use Illuminate\Database\Eloquent\Model;

class StorageFiles extends Model {
   
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
    'storage_id',
    'id',
    'share_with',
    'file_name',
    'file_url',
    'file',    
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
