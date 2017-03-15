<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 Mar 2017 15:46:21 +0530.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ContentPage
 * 
 * @property int $page_id
 * @property int $main_record_id
 * @property string $page_name
 * @property string $page_title
 * @property string $seo_url
 * @property string $seo_page_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $canonical_tag
 * @property string $page_content
 * @property string $banner_images
 * @property int $position
 * @property int $status
 * @property int $parent_id
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property int $record_restore_status
 * @property int $record_type
 * @property string $column_names
 *
 * @package App\Models
 */
class ContentPage extends Eloquent {

    protected $primaryKey = 'page_id';
    public $timestamps = false;
    protected $casts = [
        'main_record_id' => 'int',
        'position' => 'int',
        'status' => 'int',
        'parent_id' => 'int',
        'created_by' => 'int',
        'record_restore_status' => 'int',
        'record_type' => 'int'
    ];
    protected $dates = [
        'created_date'
    ];
    protected $fillable = [
        'main_record_id',
        'page_name',
        'page_title',
        'seo_url',
        'seo_page_title',
        'meta_description',
        'meta_keywords',
        'canonical_tag',
        'page_content',
        'banner_images',
        'position',
        'status',
        'parent_id',
        'created_date',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'record_restore_status',
        'record_type',
        'column_names'
    ];

    public static function validationMessages() {
        $messages = array(
            'page_name.required' => 'Please enter page name',
            'page_title.required' => 'Please enter page title',
            'status.required' => 'Please select status'
        );
        return $messages;
    }

    public static function validationRules() {
        $rules = array(
            'page_name' => 'required',
            'page_title' => 'required',
            'status' => 'required'
        );
        return $rules;
    }

}
