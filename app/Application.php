<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'application';
    public $timestamps = false;
    protected $fillable = [
        'application_id', 'campaign_id', 'user_id', 'application_message', 'application_status'
    ];

    public function getRouteKeyName()
    {
        return 'application_id';
    }
}
