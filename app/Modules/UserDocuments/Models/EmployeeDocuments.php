<?php

namespace App\Modules\UserDocuments\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocuments extends Model {

    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $casts = [
        'id' => 'int'
    ];
    protected $fillable = [
        'client_id',
        'employee_id',
        'document_id',
        'document_url',
        'document_number',
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
    
     public function userDocuments() {
        return $this->belongsTo('App\Modules\UserDocuments\Models\MlstEmployeeDocuments', 'document_id','id')->select("id", "document_name");
    }

}
