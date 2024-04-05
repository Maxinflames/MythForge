<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscribed_Item extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'subscribed_item';
    public $timestamps = false;
    protected $fillable = [
        'subscribed_item_id', 'item_id', 'user_id'
    ];
    public function getRouteKeyName()
    {
        return 'subscribed_item_id';
    }
}
