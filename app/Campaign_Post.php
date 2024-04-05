<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'campaign_post';
    protected $fillable = [
        'campaign_post_id', 'campaign_id', 'campaign_post_title', 'campaign_post_content', 'campaign_post_status', 'campaign_post_created_at', 'campaign_post_updated_at'
    ];
    public function getRouteKeyName()
    {
        return 'campaign_post_id';
    }
}
