<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loot_Group_Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'loot_group_item';
    public $timestamps = false;
    protected $fillable = [
        'loot_group_item_id', 'loot_group_id', 'item_id', 'loot_group_item_quantity'
    ];
    public function getRouteKeyName()
    {
        return 'loot_group_item_id';
    }
}
