<?php namespace App\Modules\News\Models;

use Illuminate\Database\Eloquent\Model;

class WebNews extends Model {

	
	protected $primaryKey = 'id';
	public $timestamps = false;
        protected $fillable = [
            'id',
            'news_title',
            'news_description',
            'news_short_description',
            'meta_description',
            'meta_keywords',
            'news_images',
            'news_banner_images',
            'news_seo_url',
            'news_code',
            'news_publish',
            'created_date',
            'created_at',
            'created_by',
            'created_IP',
            'created_browser',
            'created_mac_id',
                
	];

}
