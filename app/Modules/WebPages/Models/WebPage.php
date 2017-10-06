<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Mar 2017 11:38:03 +0530.
 */

namespace App\Modules\WebPages\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class WebPage
 * 
 * @property int $id
 * @property int $page_type
 * @property int $parent_id
 * @property int $parent_page_postition
 * @property int $child_page_id
 * @property int $child_page_position
 * @property string $page_name
 * @property string $page_title
 * @property string $seo_url
 * @property string $seo_page_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $canonical_tag
 * @property string $page_content
 * @property string $banner_images
 * @property string $background_images
 * @property string $other_images
 * @property int $status
 * @property \Carbon\Carbon $created_date
 * @property \Carbon\Carbon $created_at
 * @property int $created_by
 * @property string $created_IP
 * @property string $created_browser
 * @property string $created_mac_id
 * @property \Carbon\Carbon $updated_date
 * @property \Carbon\Carbon $updated_at
 * @property int $updated_by
 * @property string $updated_IP
 * @property string $updated_browser
 * @property string $updated_mac_id
 *
 * @package App\Models
 */
class WebPage extends Eloquent {

    protected $primaryKey = 'id';
    protected $casts = [
        'page_type' => 'int',
        'parent_id' => 'int',
        'parent_page_postition' => 'int',
        'child_page_id' => 'int',
        'child_page_position' => 'int',
        'status' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int'
    ];
    protected $dates = [
        'created_date',
        'updated_date'
    ];
    protected $fillable = [
        'page_type',
        'parent_id',
        'parent_page_postition',
        'child_page_id',
        'child_page_position',
        'page_name',
        'page_title',
        'seo_url',
        'seo_page_title',
        'meta_description',
        'meta_keywords',
        'canonical_tag',
        'page_content',
        'banner_images',
        'background_images',
        'other_images',
        'status',
        'created_date',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_by',
        'updated_IP',
        'updated_browser',
        'updated_mac_id'
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
    public static function validationMessages1() {
        $messages = array(
            'page_name.required' => 'Please enter page name',
            'page_title.required' => 'Please enter page title',
            'status.required' => 'Please select status',
            'child_page_position.required' => 'Please enter page position'
        );
        return $messages;
    }

    public static function validationRules1() {
        $rules = array(
            'page_name' => 'required',
            'page_title' => 'required',
            'status' => 'required',
            'child_page_position' => 'required'
        );
        return $rules;
    }

    public function menuList() {
        return $this->hasMany('App\Modules\WebPages\Models\WebPage', 'parent_id');
    }

}
