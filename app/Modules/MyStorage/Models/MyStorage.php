<?php

namespace App\Modules\MyStorage\Models;

use Illuminate\Database\Eloquent\Model;

class MyStorage extends Model {
   
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
    'folder',
    'id',
    'folder_id',
    'phonecode',
    'share_with',
    'file',    
    'created_on',
    'created_by',
    'created_by',
    'created_IP',
    'updated_on',
    'updated_by',
    'deleted_on',
    'deleted_by',    
    ];
}
