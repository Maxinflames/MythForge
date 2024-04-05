<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player_Inventory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'player_inventory';
    public $timestamps = false;
    protected $fillable = [
        'player_inventory_id', 'player_id'
    ];
    public function getRouteKeyName()
    {
        return 'player_inventory_id';
    }
}
