<?php

namespace App\Modules\DashBoard\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequest extends Model {

    protected $primaryKey = 'id';
    protected $table = 'request';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        "in_date",
        "id",
        "request_type",
        "deal_id", "uid",
        "to_uid", "req_desc",
        "cc", "status",
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
