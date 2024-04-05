<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'campaign_message';
    protected $fillable = [
        'campaign_message_id', 'campaign_chat_id', 'player_id', 'campaign_message_content',  'campaign_message_created_at', 'campaign_message_updated_at'
    ];
    public function getRouteKeyName()
    {
        return 'campaign_message_id';
    }
}
