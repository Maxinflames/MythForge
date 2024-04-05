<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'item';
    public $timestamps = false;
    protected $fillable = [
        'item_id', 'user_id', 'game_type_id', 'item_title', 'item_description', 'item_status'
    ];
    public function getRouteKeyName()
    {
        return 'item_id';
    }
}
