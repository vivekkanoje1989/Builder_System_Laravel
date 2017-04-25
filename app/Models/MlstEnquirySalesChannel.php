<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 22 Apr 2017 15:06:43 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MlstEnquirySalesChannel
 * 
 * @property int $id
 * @property string $channel_name
 * @property string $channel_icon_file
 * @property string $channel_position_css
 *
 * @package App\Models
 */
class MlstEnquirySalesChannel extends Eloquent {

    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    public $timestamps = false;
    protected $fillable = [
        'channel_name',
        'channel_icon_file',
        'channel_position_css'
    ];

}
