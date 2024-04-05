<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'player';
    public $timestamps = false;
    protected $fillable = [
        'player_id', 'campaign_id', 'game_type_id', 'user_id', 'player_character_name', 'player_profile_picture'
    ];
    public function getRouteKeyName()
    {
        return 'player_id';
    }
}
