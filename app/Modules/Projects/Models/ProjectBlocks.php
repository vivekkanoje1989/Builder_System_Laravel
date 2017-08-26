<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 06 Apr 2017 13:11:18 +0530.
 */

namespace App\Modules\Projects\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ProjectWebPage
 * 
 * @property int $id
 * @property int $project_id
 * @property int $alias_status
 * @property string $project_alias
 * @property string $project_logo
 * @property string $project_thumbnail
 * @property string $project_favicon
 * @property string $short_description
 * @property string $brief_description
 * @property string $project_banner_images
 * @property string $project_background_images
 * @property string $project_amenities_list
 * @property string $amenities_images
 * @property string $amenities_description
 * @property string $specification_images
 * @property string $specification_description
 * @property string $layout_plan_images
 * @property string $location_map_images
 * @property string $floor_plan_images
 * @property string $project_address
 * @property int $project_country
 * @property int $project_state
 * @property int $project_city
 * @property int $project_location
 * @property string $google_map_short_url
 * @property string $google_map_iframe
 * @property string $project_latitude
 * @property string $project_logitude
 * @property string $project_contact_numbers
 * @property string $project_website
 * @property string $page_title
 * @property string $project_broacher
 * @property string $seo_url
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $canonical_tag
 * @property string $project_gallery
 * @property string $video_link
 * @property string $video_short_link
 * @property int $show_on_website
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
 * @property int $deleted_status
 * @property \Carbon\Carbon $deleted_date
 * @property int $deleted_by
 * @property int $deleted_IP
 * @property int $deleted_browser
 * @property int $deleted_mac_id
 *
 * @package App\Models
 */
class ProjectBlocks extends Eloquent {

    protected $casts = [
        'project_id' => 'int',
        'wing_id' => 'int',
        'block_type_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_status' => 'int',
        'deleted_by' => 'int',
        'deleted_IP' => 'int',
        'deleted_browser' => 'int',
        'deleted_mac_id' => 'int'
    ];
    protected $dates = [
        'created_date',
        'updated_date',
        'deleted_date'
    ];
    protected $fillable = [
        'other2_value_sqft',
        'other2_value_sqmtr',
        'other3_value_sqft',
        'other3_label',
        'other3_value_sqmtr',
        'block_availablity',
        'show_on_website',
        'project_id',
        'block_type_id',
        'wing_id',
        'block_sub_type',
        'carpet_area_in_sqft',
        'carpet_terrace_in_sqft',
        'mezzanine_area_in_sqft',
        'additional_area_in_sqft',
        'carpet_area_in_sqmtr',
        'carpet_terrace_in_sqmtr',
        'mezzanine_area_in_sqmtr',
        'additional_area_in_sqmtr',
        'sellable_area_in_sqmtr',
        'other1_label',
        'other1_value_sqft',
        'other1_value_sqmtr',
        'other2_label',
        'created_date',
        'created_by',
        'created_IP',
        'created_browser',
        'created_mac_id',
        'updated_date',
        'updated_by',
        'updated_IP',
        'updated_browser',
        'updated_mac_id',
        'deleted_status',
        'deleted_date',
        'deleted_by',
        'deleted_IP',
        'deleted_browser',
        'deleted_mac_id'
    ];

}
