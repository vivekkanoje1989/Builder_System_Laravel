<?php

namespace App\Modules\DashBoard\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model {

    protected $primaryKey = 'id';
    protected $table = 'request';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        
        "id",
        "designation_id",
        "from_date",
        "to_date",
        "reply_by",
        "reply_date",
        "reply",
        "created_date",
        "created_at",
        "created_by",
        "created_IP",
        "created_browser",
        "created_mac_id",
        "updated_date",
        "updated_at",
        "updated_by",
        "updated_IP",
        "updated_browser",
        "updated_mac_id"
    ];

}
