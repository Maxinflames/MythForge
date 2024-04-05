<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player_Inventory_Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'player_inventory_item';
    public $timestamps = false;
    protected $fillable = [
        'player_inventory_item_id', 'player_inventory_id', 'item_id', 'item_quantity'
    ];
    public function getRouteKeyName()
    {
        return 'player_inventory_item_id';
    }
}
