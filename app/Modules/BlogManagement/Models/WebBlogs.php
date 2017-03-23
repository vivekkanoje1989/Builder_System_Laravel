<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 10 Jan 2017 10:34:58 +0000.
 */

 namespace App\Modules\BlogManagement\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * 
 * 
 * 
 * 
 *
 * @package App\Models
 */
class WebBlogs extends Eloquent
{
	protected $primaryKey = 'blog_id';
	public $timestamps = false;
        protected $fillable = [
            'blog_id',
            'blog_title',
            'blog_description',
            'blog_short_description',
            'meta_description',
            'meta_keywords',
            'blog_images',
            'blog_banner_images',
            'blog_seo_url',
            'blog_code',
            'blog_publish',
            'created_date',
            'created_at',
            'created_by',
            'created_IP',
            'created_browser',
            'created_mac_id',
                
	];
}
