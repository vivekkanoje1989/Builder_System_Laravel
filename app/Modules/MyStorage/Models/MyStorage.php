<?php

namespace App\Modules\MyStorage\Models;

use Illuminate\Database\Eloquent\Model;

class MyStorage extends Model {
   
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
    'folder',
    'id',
    'sub_folder',    
    'share_with',
    'sub_folder_status',
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
