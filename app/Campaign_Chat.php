<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign_Chat extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'campaign_chat';
    public $timestamps = false;
    protected $fillable = [
        'campaign_chat_id', 'campaign_id', 'campaign_chat_title'
    ];

    public function getRouteKeyName()
    {
        return 'campaign_chat_id';
    }
}
