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
 *
 * @package App\Models
 */
class ProjectWebPagesLogs extends Eloquent
{
	protected $casts = [
		'main_record_id' => 'int',
		'project_id' => 'int',
		'alias_status' => 'int',
		'project_country' => 'int',
		'project_state' => 'int',
		'project_city' => 'int',
		'project_location' => 'int',
		'show_on_website' => 'int',
		'created_by' => 'int',
	];

	protected $dates = [
		'created_date'
	];

	protected $fillable = [
                'main_record_id',
		'project_id',
		'alias_status',
		'project_alias',
		'project_logo',
		'project_thumbnail',
		'project_favicon',
		'short_description',
		'brief_description',
		'project_banner_images',
		'project_background_images',
		'project_amenities_list',
		'amenities_images',
		'amenities_description',
		'specification_images',
		'specification_description',
		'layout_plan_images',
		'location_map_images',
		'floor_plan_images',
		'project_address',
		'project_country',
		'project_state',
		'project_city',
		'project_location',
		'google_map_short_url',
		'google_map_iframe',
		'project_latitude',
		'project_logitude',
		'project_contact_numbers',
		'project_website',
		'page_title',
		'project_broacher',
		'seo_url',
		'meta_description',
		'meta_keywords',
		'canonical_tag',
		'project_gallery',
		'video_link',
		'video_short_link',
		'show_on_website',
		'created_date',
		'created_by',
		'created_IP',
		'created_browser',
		'created_mac_id',
		'record_restore_status',
		'record_type',
		'column_names'
	];
}
