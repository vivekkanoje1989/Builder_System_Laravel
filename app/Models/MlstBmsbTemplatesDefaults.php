<?php

/**
 * Created by Reliese Model.
 * Date: Mon, 06 Feb 2017 09:11:10 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class TemplatesDefault
 * 
 * @property int $id
 *
 * @package App\Models
 */
class MlstBmsbTemplatesDefaults extends Eloquent {

    protected $primaryKey = 'id';
    protected $connection = 'masterdb';
    protected $table = 'mlst_bmsb_templates_defaults';
    public $timestamps = false;

}
