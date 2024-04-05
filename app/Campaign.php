<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'campaign';
    public $timestamps = false;
    protected $fillable = [
        'campaign_id', 'game_type_id', 'user_id', 'campaign_player_limit', 'campaign_title', 'campaign_description'
    ];
    public function getRouteKeyName()
    {
        return 'campaign_id';
    }
}
